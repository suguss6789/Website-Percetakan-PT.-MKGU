<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Category;
use App\Models\Partner;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SiteTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    private function admin(): Admin
    {
        return Admin::first();
    }

    public function test_public_pages_load(): void
    {
        foreach (['/', '/tentang-kami', '/layanan', '/kontak', '/produk', '/produk?kategori=digital-printing', '/produk?q=kaos', '/sitemap.xml'] as $url) {
            $this->get($url)->assertOk();
        }
        $this->get('/produk/brosur-poster-flyer')->assertOk()->assertSee('Rp400 – Rp4.500 / lembar', false)->assertSee('A4');
        $this->get('/produk/tidak-ada')->assertNotFound();
    }

    public function test_price_range_labels(): void
    {
        $p = Product::where('slug', 'brosur-poster-flyer')->first();
        $this->assertSame('Rp400 – Rp4.500 / lembar', $p->price_range_label);

        $p->sizes()->create(['label' => 'Custom', 'price_min' => 100, 'unit' => 'per rim']);
        $this->assertSame('Mulai Rp100', $p->fresh()->price_range_label);

        $p->sizes()->delete();
        $this->assertNull($p->fresh()->price_range_label);
        $this->get('/produk/brosur-poster-flyer')->assertSee('Harga sesuai permintaan');
    }

    public function test_hidden_product_is_not_public(): void
    {
        $p = Product::first();
        $p->update(['is_active' => false]);
        $this->get('/produk/' . $p->slug)->assertNotFound();
        $this->get('/produk')->assertDontSee($p->name);
    }

    public function test_admin_requires_login_and_login_is_throttled(): void
    {
        $this->get('/admin')->assertRedirect('/admin/login');
        $this->post('/admin/login', ['email' => 'admin@mkgu.test', 'password' => 'ganti-password-ini'])->assertRedirect('/admin');

        auth()->logout();
        for ($i = 0; $i < 5; $i++) {
            $this->post('/admin/login', ['email' => 'x@y.z', 'password' => 'salah']);
        }
        $this->post('/admin/login', ['email' => 'x@y.z', 'password' => 'salah'])->assertStatus(429);
    }

    public function test_admin_pages_load(): void
    {
        $this->actingAs($this->admin());
        $p = Product::first();
        foreach (['/admin/partners', '/admin/partners/create', '/admin', '/admin/products', '/admin/products/create', "/admin/products/{$p->id}/edit", '/admin/categories', '/admin/categories/create', '/admin/settings', '/admin/account'] as $url) {
            $this->get($url)->assertOk();
        }
    }

    public function test_admin_can_create_update_and_delete_product(): void
    {
        Storage::fake('public');
        $this->actingAs($this->admin());
        $cat = Category::first();

        $this->post('/admin/products', [
            'name' => 'Stiker Vinyl',
            'category_id' => $cat->id,
            'short_description' => 'Stiker tahan air.',
            'description' => "Paragraf satu.\n\nParagraf dua.",
            'is_active' => '1',
            'cover_image' => UploadedFile::fake()->image('cover.jpg', 2400, 1800),
            'gallery' => [UploadedFile::fake()->image('a.png', 800, 800), UploadedFile::fake()->image('b.jpg', 500, 500)],
            'sizes' => [
                ['label' => 'A5', 'dimension' => '14,8 × 21 cm', 'price_min' => '1.500', 'price_max' => '3000', 'unit' => 'per lembar'],
                ['label' => '', 'price_min' => '', 'unit' => 'per pcs'], // baris kosong dibuang
                ['label' => 'A4', 'price_min' => '2500', 'price_max' => '', 'unit' => 'per lembar'],
            ],
            'specs' => [['label' => 'Bahan', 'value' => 'Vinyl'], ['label' => '', 'value' => '']],
        ])->assertSessionHasNoErrors();

        $p = Product::where('slug', 'stiker-vinyl')->firstOrFail();
        $this->assertCount(2, $p->sizes);
        $this->assertSame(1500, $p->sizes[0]->price_min);
        $this->assertNull($p->sizes[1]->price_max);
        $this->assertSame([['label' => 'Bahan', 'value' => 'Vinyl']], $p->specifications);
        $this->assertCount(2, $p->images);
        Storage::disk('public')->assertExists([$p->cover_image, thumb_path($p->cover_image)]);
        [$w] = getimagesize(Storage::disk('public')->path($p->cover_image));
        $this->assertSame(1600, $w);
        $this->assertSame('Rp1.500 – Rp3.000 / lembar', $p->price_range_label);

        // Harga maksimum < minimum ditolak
        $this->put("/admin/products/{$p->id}", [
            'name' => 'Stiker Vinyl', 'category_id' => $cat->id, 'short_description' => 'x', 'description' => 'y',
            'sizes' => [['label' => 'A5', 'price_min' => '5000', 'price_max' => '1000', 'unit' => 'per lembar']],
        ])->assertSessionHasErrors('sizes.0.price_max');

        // Update: ganti ukuran, sembunyikan
        $this->put("/admin/products/{$p->id}", [
            'name' => 'Stiker Vinyl Glossy', 'slug' => 'stiker-vinyl', 'category_id' => $cat->id,
            'short_description' => 'x', 'description' => 'y',
            'sizes' => [['label' => 'A3', 'price_min' => '4000', 'price_max' => '8000', 'unit' => 'per lembar']],
        ])->assertSessionHasNoErrors();
        $p->refresh();
        $this->assertSame('Stiker Vinyl Glossy', $p->name);
        $this->assertFalse($p->is_active);
        $this->assertCount(1, $p->sizes);

        // Hapus satu foto galeri
        $img = $p->images->first();
        $this->delete("/admin/products/{$p->id}/images/{$img->id}");
        Storage::disk('public')->assertMissing($img->path);

        // Hapus produk → semua file ikut terhapus
        $cover = $p->cover_image;
        $this->delete("/admin/products/{$p->id}")->assertRedirect('/admin/products');
        $this->assertModelMissing($p);
        Storage::disk('public')->assertMissing($cover);
        $this->assertDatabaseMissing('product_sizes', ['product_id' => $p->id]);
    }

    public function test_toggle_and_category_rules(): void
    {
        $this->actingAs($this->admin());
        $p = Product::first();
        $this->patch("/admin/products/{$p->id}/toggle");
        $this->assertFalse($p->fresh()->is_active);

        $cat = $p->category;
        $this->delete("/admin/categories/{$cat->id}")->assertSessionHas('error');
        $this->assertModelExists($cat);

        $this->post('/admin/categories', ['name' => 'Kemasan'])->assertSessionHasNoErrors();
        $new = Category::where('slug', 'kemasan')->firstOrFail();
        $this->delete("/admin/categories/{$new->id}");
        $this->assertModelMissing($new);
    }

    public function test_settings_update_changes_whatsapp_everywhere(): void
    {
        $this->actingAs($this->admin());
        $this->put('/admin/settings', [
            'company_name' => 'MKGU', 'address' => 'Jl. Contoh 1', 'email' => 'a@b.co', 'whatsapp' => '0811-2222-3333',
            'maps_embed_raw' => '<iframe src="https://www.google.com/maps/embed?pb=abc&amp;x=1" width="600"></iframe>',
        ])->assertSessionHasNoErrors();

        $this->assertSame('6281122223333', setting('whatsapp'));
        $this->assertSame('https://www.google.com/maps/embed?pb=abc&x=1', setting('maps_embed_url'));
        $this->get('/')->assertSee('wa.me/6281122223333', false)->assertSee('0811-2222-3333');
    }

    public function test_account_password_change(): void
    {
        $admin = $this->admin();
        $this->actingAs($admin)->put('/admin/account', [
            'name' => 'Budi', 'email' => $admin->email, 'current_password' => 'salah',
        ])->assertSessionHasErrors('current_password');

        $this->put('/admin/account', [
            'name' => 'Budi', 'email' => $admin->email, 'current_password' => 'ganti-password-ini',
            'password' => 'passwordbaru123', 'password_confirmation' => 'passwordbaru123',
        ])->assertSessionHasNoErrors();
        $this->assertTrue(\Hash::check('passwordbaru123', $admin->fresh()->password));
    }

    public function test_partners_shown_and_managed(): void
    {
        Storage::fake('public');
        $this->get('/')->assertSee('Dipercaya oleh')->assertSee('BPOM')->assertSee('SKIN+');
        $this->get('/tentang-kami')->assertOk()->assertDontSee('Dipercaya oleh');

        $this->actingAs($this->admin());
        $this->post('/admin/partners', [
            'name' => 'Bank Contoh', 'description' => 'Perbankan', 'is_active' => '1',
            'logo' => UploadedFile::fake()->image('logo.png', 1200, 400),
        ])->assertSessionHasNoErrors();
        $p = Partner::where('name', 'Bank Contoh')->firstOrFail();
        Storage::disk('public')->assertExists($p->logo);
        $this->assertSame(600, getimagesize(Storage::disk('public')->path($p->logo))[0]);
        $this->get('/')->assertSee('Logo Bank Contoh', false);

        $this->put("/admin/partners/{$p->id}", ['name' => 'Bank Contoh', 'remove_logo' => '1'])->assertSessionHasNoErrors();
        $old = $p->logo;
        $p->refresh();
        $this->assertNull($p->logo);
        $this->assertFalse($p->is_active);
        Storage::disk('public')->assertMissing($old);
        $this->get('/')->assertDontSee('Bank Contoh');

        $this->delete("/admin/partners/{$p->id}");
        $this->assertModelMissing($p);

        Partner::query()->update(['is_active' => false]);
        $this->get('/')->assertDontSee('Dipercaya oleh');
    }
}

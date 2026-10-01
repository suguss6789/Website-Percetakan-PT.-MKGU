<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use App\Services\ImageService;
use Illuminate\Http\Request;

class PartnerAdminController extends Controller
{
    public function __construct(private ImageService $images)
    {
    }

    public function index()
    {
        return view('admin.partners.index', ['partners' => Partner::ordered()->get()]);
    }

    public function create()
    {
        return view('admin.partners.form', ['partner' => new Partner(['is_active' => true])]);
    }

    public function store(Request $request)
    {
        $partner = Partner::create($this->validated($request));

        return redirect()->route('admin.partners.index')->with('status', "Partner “{$partner->name}” ditambahkan.");
    }

    public function edit(Partner $partner)
    {
        return view('admin.partners.form', compact('partner'));
    }

    public function update(Request $request, Partner $partner)
    {
        $partner->update($this->validated($request, $partner));

        return redirect()->route('admin.partners.index')->with('status', 'Partner diperbarui.');
    }

    public function destroy(Partner $partner)
    {
        $name = $partner->name;
        $partner->delete();

        return redirect()->route('admin.partners.index')->with('status', "Partner “{$name}” dihapus.");
    }

    private function validated(Request $request, ?Partner $partner = null): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:80'],
            'description' => ['nullable', 'string', 'max:120'],
            'url' => ['nullable', 'url', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:999'],
            'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'remove_logo' => ['nullable', 'boolean'],
        ], [], ['name' => 'nama partner', 'description' => 'keterangan', 'url' => 'link website']);

        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);
        $data['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('logo')) {
            $this->images->delete($partner?->logo);
            $data['logo'] = $this->images->store($request->file('logo'), 'partners', 600);
        } elseif ($request->boolean('remove_logo') && $partner?->logo) {
            $this->images->delete($partner->logo);
            $data['logo'] = null;
        } else {
            unset($data['logo']);
        }
        unset($data['remove_logo']);

        return $data;
    }
}

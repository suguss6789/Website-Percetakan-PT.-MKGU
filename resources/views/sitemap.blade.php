{!! '<?xml version="1.0" encoding="UTF-8"?>' !!}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
@foreach (['home', 'about', 'services', 'products.index', 'contact'] as $r)
    <url><loc>{{ route($r) }}</loc></url>
@endforeach
@foreach ($products as $p)
    <url><loc>{{ route('products.show', $p->slug) }}</loc><lastmod>{{ $p->updated_at->toAtomString() }}</lastmod></url>
@endforeach
</urlset>

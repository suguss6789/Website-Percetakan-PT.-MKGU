@props(['product'])
<article class="group relative flex flex-col">
    <a href="{{ route('products.show', $product) }}" class="block">
        <div class="relative aspect-[4/5] overflow-hidden border border-line bg-white">
            @if ($product->thumb_url)
                <img src="{{ $product->thumb_url }}" alt="{{ $product->name }}" loading="lazy" decoding="async"
                    class="h-full w-full object-contain p-4 transition duration-500 group-hover:scale-[1.03]">
            @else
                <x-sheet-blank :title="$product->name" />
            @endif
            @if ($product->is_featured)
                <span class="absolute left-3 top-3 bg-brand-yellow px-2 py-1 font-mono text-[10px] font-medium uppercase tracking-[0.14em] text-ink">Unggulan</span>
            @endif
        </div>
    </a>
    <div class="flex flex-1 flex-col pt-4">
        <p class="label-mono">{{ $product->category?->name }}</p>
        <h3 class="mt-1.5 text-xl font-bold">
            <a href="{{ route('products.show', $product) }}" class="after:absolute after:inset-0 hover:text-brand-green-deep">{{ $product->name }}</a>
        </h3>
        <p class="mt-2 line-clamp-2 text-[15px] text-ink-muted">{{ $product->short_description }}</p>
        <p class="mt-auto pt-3 font-mono text-[14px] font-medium text-ink">
            @if ($product->price_range_label)
                <span class="highlight">{{ $product->price_range_label }}</span>
            @else
                <span class="text-ink-muted">Harga sesuai permintaan</span>
            @endif
        </p>
    </div>
</article>

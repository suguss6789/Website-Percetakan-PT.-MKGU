@props(['product'])
<article class="group relative flex flex-col">
    <a href="{{ route('products.show', $product) }}" class="block">
        <div class="relative aspect-[4/5] overflow-hidden border border-line bg-white">
            @if ($product->thumb_url)
                <img src="{{ $product->thumb_url }}" alt="{{ $product->name }}" loading="lazy" decoding="async"
                    class="h-full w-full object-contain p-2 transition sm:p-4 duration-500 group-hover:scale-[1.03]">
            @else
                <x-sheet-blank :title="$product->name" />
            @endif
            @if ($product->is_featured)
                <span class="absolute left-2 top-2 bg-brand-yellow px-1.5 py-0.5 font-mono text-[0.5625rem] sm:left-3 sm:top-3 sm:px-2 sm:py-1 sm:text-[0.625rem] font-medium uppercase tracking-[0.14em] text-ink">Unggulan</span>
            @endif
        </div>
    </a>
    <div class="flex flex-1 flex-col pt-4">
        <p class="label-mono truncate text-[0.625rem] sm:text-[0.6875rem]">{{ $product->category?->name }}</p>
        <h3 class="mt-1.5 text-base font-bold leading-snug sm:text-xl">
            <a href="{{ route('products.show', $product) }}" class="after:absolute after:inset-0 hover:text-brand-green-deep">{{ $product->name }}</a>
        </h3>
        <p class="mt-2 line-clamp-2 hidden text-[0.9375rem] text-ink-muted sm:block">{{ $product->short_description }}</p>
        <p class="mt-auto pt-3 font-mono text-[0.75rem] font-medium leading-relaxed text-ink sm:text-sm">
            @if ($product->price_range_label)
                <span class="highlight">{{ $product->price_range_label }}</span>
            @else
                <span class="text-ink-muted">Harga sesuai permintaan</span>
            @endif
        </p>
    </div>
</article>

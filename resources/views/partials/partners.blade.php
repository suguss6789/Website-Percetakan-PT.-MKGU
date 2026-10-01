@php
    $partners = \App\Models\Partner::active()->ordered()->get();
    $cols = [1 => 'lg:grid-cols-4', 2 => 'lg:grid-cols-4', 3 => 'lg:grid-cols-4', 4 => 'lg:grid-cols-4', 5 => 'lg:grid-cols-5'][$partners->count()] ?? 'lg:grid-cols-6';
@endphp
@if ($partners->isNotEmpty())
    <section class="border-y border-line bg-white py-14 lg:py-20" aria-labelledby="partner-heading">
        <div class="container-page">
            <div class="max-w-2xl">
                <p class="label-mono">Dipercaya oleh</p>
                <h2 id="partner-heading" class="mt-3 text-3xl font-bold sm:text-[42px]">Instansi dan perusahaan yang pernah bekerja sama dengan kami.</h2>
            </div>

            <ul class="mt-10 grid grid-cols-2 border-l border-t border-line sm:grid-cols-3 {{ $cols }}">
                @foreach ($partners as $partner)
                    @php $tag = $partner->url ? 'a' : 'div'; @endphp
                    <li class="border-b border-r border-line">
                        <{{ $tag }} @if($partner->url) href="{{ $partner->url }}" target="_blank" rel="noopener" @endif
                            class="group flex h-full flex-col items-center justify-center gap-3 px-4 py-8 text-center transition-colors hover:bg-paper">
                            <span class="flex h-16 w-full items-center justify-center">
                                @if ($partner->logo_url)
                                    <img src="{{ $partner->logo_url }}" alt="Logo {{ $partner->name }}" loading="lazy"
                                        class="max-h-16 max-w-[150px] object-contain opacity-70 grayscale transition duration-300 group-hover:opacity-100 group-hover:grayscale-0">
                                @else
                                    <span class="font-display text-2xl font-extrabold tracking-tight text-ink/60 transition-colors group-hover:text-brand-green-deep sm:text-3xl">{{ $partner->name }}</span>
                                @endif
                            </span>
                            @if ($partner->description)
                                <span class="font-mono text-[10px] uppercase leading-relaxed tracking-[0.12em] text-ink-muted">{{ $partner->description }}</span>
                            @endif
                        </{{ $tag }}>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>
@endif

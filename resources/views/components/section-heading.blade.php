@props(['label' => null, 'title', 'number' => null])
<div {{ $attributes->merge(['class' => 'max-w-2xl']) }}>
    @if ($label || $number)
        <p class="label-mono flex items-center gap-3">
            @if ($number)<span class="text-brand-green-deep">{{ $number }}</span><span class="h-px w-8 bg-line"></span>@endif
            {{ $label }}
        </p>
    @endif
    <h2 class="mt-3 text-fluid-h2 font-bold">{{ $title }}</h2>
    @if ($slot->isNotEmpty())
        <div class="mt-4 text-[1.0625rem] text-ink-muted">{{ $slot }}</div>
    @endif
</div>

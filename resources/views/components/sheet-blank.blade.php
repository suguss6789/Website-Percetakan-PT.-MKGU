@props(['title', 'label' => null])
<div class="sheet-blank" aria-hidden="true">
    <div class="flex items-start justify-between">
        <span class="font-mono text-[0.625rem] uppercase tracking-[0.14em] text-ink-soft">{{ $label }}</span>
        <svg class="h-6 w-6 text-ink-soft" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"><circle cx="12" cy="12" r="6"/><path d="M12 2v20M2 12h20"/></svg>
    </div>
    <p class="font-display text-lg font-bold leading-tight text-ink/80 sm:text-2xl">{{ $title }}</p>
    <div class="flex items-end justify-between">
        <span class="font-mono text-[0.625rem] uppercase tracking-[0.14em] text-ink-soft">Foto menyusul</span>
        <span class="flex h-2 w-16"><span class="flex-1 bg-[#00A0E3]"></span><span class="flex-1 bg-[#E6007E]"></span><span class="flex-1 bg-[#FFED00]"></span><span class="flex-1 bg-ink"></span></span>
    </div>
</div>

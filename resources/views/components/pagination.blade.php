@if ($paginator->hasPages())
    <nav class="flex items-center justify-between gap-4 border-t border-line pt-6" aria-label="Halaman">
        @if ($paginator->onFirstPage())
            <span class="btn border border-line text-ink-soft">← Sebelumnya</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="btn-outline">← Sebelumnya</a>
        @endif
        <span class="font-mono text-xs uppercase tracking-[0.14em] text-ink-muted">Hal. {{ $paginator->currentPage() }} / {{ $paginator->lastPage() }}</span>
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="btn-outline">Berikutnya →</a>
        @else
            <span class="btn border border-line text-ink-soft">Berikutnya →</span>
        @endif
    </nav>
@endif

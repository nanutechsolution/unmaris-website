@props([
    'title',
    'description' => null,
])

<div class="rounded-3xl border border-dashed border-line-strong bg-surface px-6 py-14 text-center shadow-[var(--shadow-soft)]">
    @if (! $slot->isEmpty())
        <div class="mx-auto mb-5 grid h-16 w-16 place-items-center rounded-2xl bg-unmaris-yellow/15 text-brand-ink ring-1 ring-unmaris-yellow/40">
            {{ $slot }}
        </div>
    @endif
    <h3 class="heading-3">{{ $title }}</h3>
    @if ($description)
        <p class="mx-auto mt-2 max-w-md text-sm leading-relaxed text-muted">{{ $description }}</p>
    @endif
</div>

@props([
    'title',
    'description' => null,
])

<div class="rounded-2xl border border-dashed border-slate-300 bg-white px-6 py-16 text-center shadow-sm">
    @if (! $slot->isEmpty())
        <div class="mx-auto mb-5 grid h-16 w-16 place-items-center rounded-2xl bg-slate-50 text-slate-400">
            {{ $slot }}
        </div>
    @endif
    <h3 class="heading-3">{{ $title }}</h3>
    @if ($description)
        <p class="mx-auto mt-2 max-w-md text-sm leading-relaxed text-slate-500">{{ $description }}</p>
    @endif
</div>

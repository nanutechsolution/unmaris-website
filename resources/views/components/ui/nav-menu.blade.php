@props(['label', 'active' => false])

@php $menuId = 'nav-menu-' . \Illuminate\Support\Str::slug($label); @endphp

<div class="relative"
    x-data="{ open: false }"
    @mouseenter="if (window.matchMedia('(hover: hover)').matches) { open = true; $dispatch('nav-menu-open', $root) }"
    @mouseleave="if (window.matchMedia('(hover: hover)').matches) open = false"
    @focusout="if (! $el.contains($event.relatedTarget)) open = false"
    @click.outside="open = false"
    @nav-menu-open.window="if ($event.detail !== $root) open = false"
    @keydown.escape.window="if (open) { open = false; $refs.trigger.focus() }">
    <button type="button"
        x-ref="trigger"
        @click="open = ! open; if (open) $dispatch('nav-menu-open', $root)"
        :aria-expanded="open ? 'true' : 'false'"
        aria-haspopup="true"
        aria-controls="{{ $menuId }}"
        class="nav-link {{ $active ? 'nav-link-active' : '' }}">
        {{ $label }}
        <svg class="h-3.5 w-3.5 transition-transform duration-200" :class="{ 'rotate-180': open }"
            fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
        </svg>
    </button>

    <div id="{{ $menuId }}" x-show="open" x-cloak
        x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0 translate-y-1"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-1"
        class="absolute left-0 top-full z-50 pt-2">
        <div class="w-72 overflow-hidden rounded-2xl border border-line bg-surface p-2 shadow-[0_24px_60px_-24px_rgba(11,7,32,0.55)]">
            <div class="mb-1 flex items-center gap-2 px-3 py-2" aria-hidden="true">
                <span class="h-1 w-6 rounded-full bg-unmaris-yellow"></span>
                <span class="text-[9px] font-extrabold uppercase tracking-[0.18em] text-muted">{{ $label }}</span>
            </div>
            {{ $slot }}
        </div>
    </div>
</div>

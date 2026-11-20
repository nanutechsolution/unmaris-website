@props(['label', 'active' => false])

<div class="relative"
    x-data="{ open: false }"
    @mouseenter="open = true"
    @mouseleave="open = false"
    @focusin="open = true"
    @focusout="if (! $el.contains($event.relatedTarget)) open = false"
    @keydown.escape="open = false">
    <button type="button"
        @click="open = ! open"
        :aria-expanded="open"
        aria-haspopup="true"
        class="nav-link {{ $active ? 'nav-link-active' : '' }}">
        {{ $label }}
        <svg class="h-3.5 w-3.5 transition-transform duration-200" :class="{ 'rotate-180': open }"
            fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
        </svg>
    </button>

    <div x-show="open" x-cloak
        x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0 translate-y-1"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-1"
        class="absolute left-0 top-full z-50 pt-2">
        <div class="w-64 overflow-hidden rounded-xl border-t-4 border-unmaris-yellow bg-white p-2 shadow-2xl ring-1 ring-slate-200/70">
            {{ $slot }}
        </div>
    </div>
</div>

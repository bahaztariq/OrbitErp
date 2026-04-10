@props(['align' => 'right', 'width' => '48'])

@php
    $widthValue = $width == '48' ? 192 : (int) filter_var($width, FILTER_SANITIZE_NUMBER_INT);
    // If width is like 'w-56', we extract 56 and multiply by 4 to get pixels (roughly)
    if ($width != '48' && str_contains($width, 'w-')) {
        $widthValue = ((int) str_replace('w-', '', $width)) * 4;
    }
@endphp

<div class="relative inline-block text-left" 
     x-data="{ 
        open: false,
        triggerRect: {},
        updateRect() {
            this.triggerRect = $refs.trigger.getBoundingClientRect();
        }
     }" 
     @click.outside="open = false" 
     @close.stop="open = false"
     @scroll.window="if(open) open = false"
     @resize.window="if(open) open = false">
    
    <button x-ref="trigger"
            @click="open = !open; if(open) $nextTick(() => updateRect())" 
            type="button"
            class="p-2 text-gray-400 hover:text-gray-600 rounded-lg hover:bg-gray-100 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500/20">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
        </svg>
    </button>

    <template x-teleport="body">
        <div x-show="open" 
             x-transition:enter="transition ease-out duration-100"
             x-transition:enter-start="transform opacity-0 scale-95"
             x-transition:enter-end="transform opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-75"
             x-transition:leave-start="transform opacity-100 scale-100"
             x-transition:leave-end="transform opacity-0 scale-95"
             class="fixed z-[100] mt-1 {{ $width == '48' ? 'w-48' : $width }} rounded-xl bg-white shadow-2xl shadow-brand-500/20 border border-gray-100 py-1.5" 
             :style="{
                top: (triggerRect.bottom) + 'px',
                left: '{{ $align }}' === 'right' ? (triggerRect.right - {{ $widthValue }}) + 'px' : (triggerRect.left) + 'px'
             }"
             style="display: none;"
             @click="open = false">
            {{ $slot }}
        </div>
    </template>
</div>

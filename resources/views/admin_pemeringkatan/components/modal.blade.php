{{--
    Reusable Modal Component - Tailwind CSS + Alpine.js
    
    Usage Example:
    @include('admin_pemeringkatan.components.modal', [
        'id' => 'createModal',
        'title' => 'Create New Item',
        'size' => 'lg', // Options: 'sm', 'md', 'lg', 'xl', '2xl'
    ])
        <form>
            <!-- Modal content here -->
        </form>
    @endinclude
    
    To Open Modal (from button or anywhere):
    @click="$dispatch('modal-open-createModal')"
    
    To Close Modal (from inside modal or anywhere):
    @click="$dispatch('modal-close-createModal')"
--}}

@php
    $modalId = $id ?? 'defaultModal';
    $modalTitle = $title ?? 'Modal';
    $modalSize = $size ?? 'lg';
    
    // Size mappings
    $sizeClasses = [
        'sm' => 'max-w-sm',
        'md' => 'max-w-md',
        'lg' => 'max-w-lg',
        'xl' => 'max-w-xl',
        '2xl' => 'max-w-2xl',
        '3xl' => 'max-w-3xl',
        '4xl' => 'max-w-4xl',
        'full' => 'max-w-full mx-4',
    ];
    
    $maxWidth = $sizeClasses[$modalSize] ?? $sizeClasses['lg'];
@endphp

<div 
    x-data="{ 
        show: false,
        open() {
            this.show = true;
            document.body.style.overflow = 'hidden';
        },
        close() {
            this.show = false;
            document.body.style.overflow = 'auto';
        }
    }"
    x-show="show"
    x-cloak
    @modal-open-{{ $modalId }}.window="open()"
    @modal-close-{{ $modalId }}.window="close()"
    @keydown.escape.window="show && close()"
    class="fixed inset-0 z-50 overflow-y-auto"
    style="display: none;"
>
    <!-- Backdrop -->
    <div 
        x-show="show"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click="close()"
        class="fixed inset-0 bg-gray-900 bg-opacity-50"
    ></div>

    <!-- Modal Container -->
    <div class="flex items-center justify-center min-h-screen px-4 py-8">
        <div 
            x-show="show"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform scale-95"
            x-transition:enter-end="opacity-100 transform scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 transform scale-100"
            x-transition:leave-end="opacity-0 transform scale-95"
            @click.stop
            class="relative bg-white rounded-lg shadow-xl w-full {{ $maxWidth }}"
        >
            <!-- Modal Header -->
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 bg-gray-50 rounded-t-lg">
                <h3 class="text-xl font-semibold text-gray-800">
                    {{ $modalTitle }}
                </h3>
                <button 
                    type="button"
                    @click="close()"
                    class="text-gray-400 hover:text-gray-600 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-gray-300 rounded-lg p-1.5"
                    aria-label="Close modal"
                >
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="px-6 py-4 max-h-[calc(100vh-200px)] overflow-y-auto">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>

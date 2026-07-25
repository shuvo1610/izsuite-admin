{{-- Modal Component --}}
{{-- Usage: @include('components.modal', ['id' => 'my-modal', 'title' => '...', 'slot' => 'modal-body-content-view']) --}}

<div id="{{ $id }}" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="text-lg font-semibold text-[var(--text-primary)]">{{ $title ?? 'Modal' }}</h3>
            <button data-modal-close class="p-1 rounded-lg hover:bg-gray-100">
                <i data-lucide="x" class="w-5 h-5 text-[var(--text-secondary)]"></i>
            </button>
        </div>
        <div class="modal-body">
            @yield($slot ?? 'modal-body')
        </div>
        @hasSection($footerSlot ?? 'modal-footer')
            <div class="modal-footer">
                @yield($footerSlot ?? 'modal-footer')
            </div>
        @endif
    </div>
</div>

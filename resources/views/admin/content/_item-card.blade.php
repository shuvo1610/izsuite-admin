{{-- Reusable item card for repeatable CMS sections --}}
<div class="item-card" data-id="{{ $item->id }}">
    <div class="item-header">
        <span class="item-number font-medium text-sm text-[var(--text-primary)] flex items-center gap-1.5">
            <i data-lucide="grip-vertical" class="w-4 h-4 text-[var(--text-muted)] cursor-move"></i>
            {{ __($sectionDef['item_label']) }} #{{ $index + 1 }}
        </span>
        <div class="flex items-center gap-2">
            <button type="button" class="save-item-btn btn btn-sm btn-outline flex items-center gap-1" title="{{ __('Save') }}">
                <i data-lucide="save" class="w-3.5 h-3.5"></i> {{ __('Save') }}
            </button>
            <button type="button" class="delete-item-btn text-red-500 hover:text-red-600 transition p-1" data-id="{{ $item->id }}" title="{{ __('Delete') }}">
                <i data-lucide="trash-2" class="w-4 h-4 pointer-events-none"></i>
            </button>
        </div>
    </div>

    <div class="item-fields">
        @foreach($sectionDef['fields'] as $fieldKey => $fieldDef)
            @if($fieldDef['type'] === 'image')
                {{-- Image upload field --}}
                <div class="form-group flex flex-col gap-2">
                    <label class="form-label text-sm text-[var(--text-muted)]">{{ __($fieldDef['label']) }}</label>
                    <div class="flex items-center gap-4">
                        <div class="image-upload-inline flex items-center gap-4 flex-1">
                            <div class="thumb-wrap w-16 h-16 rounded-xl border border-[var(--card-border)] bg-gray-50 flex items-center justify-center overflow-hidden shrink-0">
                                @if($item->get($fieldKey))
                                    <img src="{{ $item->get($fieldKey) }}" class="w-full h-full object-cover">
                                @else
                                    <i data-lucide="image" class="w-6 h-6 text-gray-300"></i>
                                @endif
                            </div>
                            <div class="flex-1">
                                <input type="hidden" data-field="{{ $fieldKey }}" value="{{ $item->get($fieldKey) }}">
                                <input type="file" name="images[{{ $fieldKey }}][{{ $item->id }}]" class="item-image-input form-input text-xs w-full" data-field="{{ $fieldKey }}" accept="image/*">
                            </div>
                        </div>
                    </div>
                </div>
            @elseif($fieldDef['type'] === 'textarea')
                {{-- Textarea field --}}
                <div class="form-group flex flex-col gap-2 {{ ($fieldDef['span'] ?? '') === 'full' ? 'md:col-span-2' : '' }}">
                    <label class="form-label text-sm text-[var(--text-muted)]">{{ __($fieldDef['label']) }}</label>
                    <textarea name="items[{{ $item->id }}][{{ $fieldKey }}]" rows="3" class="form-input px-3 py-2 border border-[var(--card-border)] rounded-md w-full">{{ $item->get($fieldKey) }}</textarea>
                </div>
            @elseif($fieldDef['type'] === 'number')
                {{-- Number input field --}}
                <div class="form-group flex flex-col gap-2">
                    <label class="form-label text-sm text-[var(--text-muted)]">{{ __($fieldDef['label']) }}</label>
                    <input type="number" name="items[{{ $item->id }}][{{ $fieldKey }}]" step="any" class="form-input px-3 py-2 border border-[var(--card-border)] rounded-md w-full" value="{{ $item->get($fieldKey) }}">
                </div>
            @else
                {{-- Text input field --}}
                <div class="form-group flex flex-col gap-2">
                    <label class="form-label text-sm text-[var(--text-muted)]">{{ __($fieldDef['label']) }}</label>
                    <input type="text" name="items[{{ $item->id }}][{{ $fieldKey }}]" class="form-input px-3 py-2 border border-[var(--card-border)] rounded-md w-full" value="{{ $item->get($fieldKey) }}">
                </div>
            @endif
        @endforeach
    </div>
</div>

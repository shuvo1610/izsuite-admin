{{-- Shared App Category form partial — used by create.blade.php and edit.blade.php --}}
@php
    $isEdit = isset($appCategory) && $appCategory->exists;
@endphp

{{-- Name --}}
<div class="mb-4">
    <label class="form-label" for="name">{{ __('Category Name') }}</label>
    <input type="text" id="name" name="name" value="{{ old('name', $isEdit ? $appCategory->name : '') }}" class="form-input" placeholder="Productivity, Finance, Communication..." required>
    @error('name')
        <p class="text-xs mt-1 text-[var(--danger)]">{{ $message }}</p>
    @enderror
</div>

<div class="divider"></div>

{{-- Is Active (toggle switch) --}}
<div class="mb-4">
    <div class="flex items-center gap-3">
        <label class="flex items-center gap-3 cursor-pointer">
            <input type="checkbox" id="is_active" name="is_active" value="1" class="toggle-switch" {{ old('is_active', $isEdit ? $appCategory->is_active : true) ? 'checked' : '' }}>
            <span class="form-label mb-0">{{ __('Active') }}</span>
        </label>
    </div>
    <p class="text-xs mt-2 text-[var(--text-muted)]">{{ __('Toggle whether this category is available for use.') }}</p>
    @error('is_active')
        <p class="text-xs mt-1 text-[var(--danger)]">{{ $message }}</p>
    @enderror
</div>

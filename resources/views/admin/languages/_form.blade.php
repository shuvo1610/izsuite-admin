{{-- Language Form Partial --}}
<div class="form-group">
    <label for="name" class="form-label">{{ __('Language Name') }}</label>
    <input type="text" name="name" id="name" class="form-input"
           value="{{ old('name', $language->name ?? '') }}" placeholder="English" required>
    @error('name')
        <p class="text-xs mt-1 text-[var(--danger)]">{{ $message }}</p>
    @enderror
</div>

<div class="form-group">
    <label for="code" class="form-label">{{ __('Code') }}</label>
    <input type="text" name="code" id="code" class="form-input"
           value="{{ old('code', $language->code ?? '') }}" placeholder="en" required maxlength="5">
    @error('code')
        <p class="text-xs mt-1 text-[var(--danger)]">{{ $message }}</p>
    @enderror
</div>

<div class="form-group">
    <label for="native_name" class="form-label">{{ __('Native Name') }}</label>
    <input type="text" name="native_name" id="native_name" class="form-input"
           value="{{ old('native_name', $language->native_name ?? '') }}" placeholder="English">
    @error('native_name')
        <p class="text-xs mt-1 text-[var(--danger)]">{{ $message }}</p>
    @enderror
</div>

<div class="form-group">
    <label for="direction" class="form-label">{{ __('Direction') }}</label>
    <select name="direction" id="direction" class="form-input">
        <option value="ltr" {{ old('direction', $language->direction ?? 'ltr') === 'ltr' ? 'selected' : '' }}>{{ __('LTR (Left to Right)') }}</option>
        <option value="rtl" {{ old('direction', $language->direction ?? '') === 'rtl' ? 'selected' : '' }}>{{ __('RTL (Right to Left)') }}</option>
    </select>
</div>

<div class="flex items-center gap-6 mt-4">
    <label class="flex items-center gap-2 cursor-pointer">
        <input type="checkbox" name="is_active" value="1"
               {{ old('is_active', $language->is_active ?? true) ? 'checked' : '' }}
               class="form-checkbox">
        <span class="text-sm text-[var(--text-primary)]">{{ __('Active') }}</span>
    </label>
    <label class="flex items-center gap-2 cursor-pointer">
        <input type="checkbox" name="is_default" value="1"
               {{ old('is_default', $language->is_default ?? false) ? 'checked' : '' }}
               class="form-checkbox">
        <span class="text-sm text-[var(--text-primary)]">{{ __('Default Language') }}</span>
    </label>
</div>

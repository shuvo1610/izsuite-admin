{{-- Shared form fields for currency create / edit --}}
<div class="card mb-6">
    <h3 class="section-title mb-4">{{ __('Currency Details') }}</h3>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="form-label" for="name">{{ __('Name') }}</label>
            <input type="text" name="name" id="name" class="form-input" value="{{ old('name', $currency->name ?? '') }}" required placeholder="{{ __('e.g. US Dollar') }}">
        </div>

        <div>
            <label class="form-label" for="code">{{ __('Code') }}</label>
            <input type="text" name="code" id="code" class="form-input" value="{{ old('code', $currency->code ?? '') }}" required maxlength="10" placeholder="{{ __('e.g. USD') }}" style="text-transform: uppercase;">
        </div>

        <div>
            <label class="form-label" for="symbol">{{ __('Symbol') }}</label>
            <input type="text" name="symbol" id="symbol" class="form-input" value="{{ old('symbol', $currency->symbol ?? '') }}" required maxlength="10" placeholder="{{ __('e.g. $') }}">
        </div>

        <div>
            <label class="form-label" for="exchange_rate">{{ __('Exchange Rate') }}</label>
            <input type="number" name="exchange_rate" id="exchange_rate" class="form-input" step="0.000001" min="0.000001" value="{{ old('exchange_rate', $currency->exchange_rate ?? '1.000000') }}" required>
            <p class="text-xs mt-1 text-[var(--text-muted)]">{{ __('Relative to the default currency (1.0 = base rate)') }}</p>
        </div>
    </div>
</div>

<div class="card mb-6">
    <h3 class="section-title mb-4">{{ __('Options') }}</h3>

    <div class="flex items-center gap-6">
        <label class="flex items-center gap-2 cursor-pointer">
            <input type="checkbox" name="is_active" value="1" class="form-checkbox" {{ old('is_active', $currency->is_active ?? true) ? 'checked' : '' }}>
            <span class="text-sm font-medium">{{ __('Active') }}</span>
        </label>

        <label class="flex items-center gap-2 cursor-pointer">
            <input type="checkbox" name="is_default" value="1" class="form-checkbox" {{ old('is_default', $currency->is_default ?? false) ? 'checked' : '' }}>
            <span class="text-sm font-medium">{{ __('Default Currency') }}</span>
        </label>
    </div>
</div>

<div class="flex items-center gap-3">
    <button type="submit" class="btn btn-primary">
        <i data-lucide="save" class="w-4 h-4"></i>
        {{ isset($currency) ? __('Update Currency') : __('Create Currency') }}
    </button>
    <a href="{{ route('admin.currencies.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
</div>

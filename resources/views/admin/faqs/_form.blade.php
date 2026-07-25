@php $isEdit = isset($faq); @endphp

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-6">
        <div class="card">
            <label class="form-label">{{ __('Question') }} <span class="text-[var(--danger)]">*</span></label>
            <input
                type="text"
                name="question"
                class="form-input"
                placeholder="{{ __('e.g. How does the resume builder work?') }}"
                value="{{ old('question', $faq->question ?? '') }}"
                required
            >
            @error('question') <p class="form-error">{{ $message }}</p> @enderror
        </div>

        <div class="card">
            <label class="form-label">{{ __('Answer') }}</label>
            <textarea name="answer" id="summernote-answer">{{ old('answer', $faq->answer ?? '') }}</textarea>
            @error('answer') <p class="form-error">{{ $message }}</p> @enderror
        </div>
    </div>

    <div class="space-y-6">
        <div class="card">
            <h3 class="section-title mb-4">{{ __('Settings') }}</h3>

            <div class="mb-4">
                <label class="form-label">{{ __('Status') }}</label>
                <select name="status" class="form-input">
                    <option value="draft" {{ old('status', $faq->status ?? 'draft') === 'draft' ? 'selected' : '' }}>{{ __('Draft') }}</option>
                    <option value="published" {{ old('status', $faq->status ?? '') === 'published' ? 'selected' : '' }}>{{ __('Published') }}</option>
                </select>
                @error('status') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="form-label">{{ __('Sort Order') }}</label>
                <input type="number" name="sort_order" class="form-input" min="0" value="{{ old('sort_order', $faq->sort_order ?? 0) }}">
                <p class="text-xs mt-1 text-[var(--text-muted)]">{{ __('Lower numbers appear first on the website.') }}</p>
                @error('sort_order') <p class="form-error">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="btn btn-primary flex-1">
                <i data-lucide="save" class="w-4 h-4"></i>
                {{ $isEdit ? __('Update FAQ') : __('Create FAQ') }}
            </button>
            <a href="{{ route('admin.faqs.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
        </div>
    </div>
</div>

@php $isEdit = isset($page); @endphp

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-6">
        <div class="card">
            <label class="form-label">{{ __('Page Title') }} <span class="text-[var(--danger)]">*</span></label>
            <input type="text" name="title" id="page-title" class="form-input" placeholder="{{ __('e.g. Terms & Conditions') }}"
                   value="{{ old('title', $page->title ?? '') }}" required>
            @error('title') <p class="form-error">{{ $message }}</p> @enderror
        </div>

        <div class="card">
            <label class="form-label">{{ __('Content') }}</label>
            <textarea name="content" id="summernote-content">{{ old('content', $page->content ?? '') }}</textarea>
            @error('content') <p class="form-error">{{ $message }}</p> @enderror
        </div>
    </div>

    <div class="space-y-6">
        <div class="card">
            <h3 class="section-title mb-4">{{ __('Settings') }}</h3>

            <div class="mb-4">
                <label class="form-label">{{ __('Slug') }}</label>
                <div class="flex items-center gap-1">
                    <span class="text-xs text-[var(--text-muted)]">/page/</span>
                    <input type="text" name="slug" class="form-input" placeholder="{{ __('auto-generated') }}"
                           value="{{ old('slug', $page->slug ?? '') }}">
                </div>
                @error('slug') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="form-label">{{ __('Status') }}</label>
                <select name="status" class="form-input">
                    <option value="draft" {{ old('status', $page->status ?? 'draft') === 'draft' ? 'selected' : '' }}>{{ __('Draft') }}</option>
                    <option value="published" {{ old('status', $page->status ?? '') === 'published' ? 'selected' : '' }}>{{ __('Published') }}</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="form-label">{{ __('Sort Order') }}</label>
                <input type="number" name="sort_order" class="form-input" value="{{ old('sort_order', $page->sort_order ?? 0) }}" min="0">
            </div>

            <div class="mb-4">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="hidden" name="show_in_footer" value="0">
                    <input type="checkbox" name="show_in_footer" value="1"
                           class="w-4 h-4 rounded"
                           {{ old('show_in_footer', $page->show_in_footer ?? false) ? 'checked' : '' }}>
                    <span class="text-sm font-medium text-[var(--text-primary)]">{{ __('Show in footer') }}</span>
                </label>
            </div>
        </div>

        <div class="card">
            <h3 class="section-title mb-4">{{ __('SEO') }}</h3>

            <div class="mb-4">
                <label class="form-label">{{ __('Meta Title') }}</label>
                <input type="text" name="meta_title" class="form-input" placeholder="{{ __('Page title for search engines') }}"
                       value="{{ old('meta_title', $page->meta_title ?? '') }}">
            </div>

            <div class="mb-4">
                <label class="form-label">{{ __('Meta Description') }}</label>
                <textarea name="meta_description" class="form-input" rows="3" placeholder="{{ __('Brief description for search results') }}">{{ old('meta_description', $page->meta_description ?? '') }}</textarea>
            </div>

            <div>
                <label class="form-label">{{ __('Meta Keywords') }}</label>
                <input type="text" name="meta_keywords" class="form-input" placeholder="{{ __('keyword1, keyword2, keyword3') }}"
                       value="{{ old('meta_keywords', $page->meta_keywords ?? '') }}">
                <p class="text-xs mt-1 text-[var(--text-muted)]">{{ __('Comma-separated keywords for search engines') }}</p>
            </div>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="btn btn-primary flex-1">
                <i data-lucide="save" class="w-4 h-4"></i>
                {{ $isEdit ? __('Update Page') : __('Create Page') }}
            </button>
            <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
        </div>
    </div>
</div>

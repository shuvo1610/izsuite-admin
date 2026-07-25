@extends('layouts.admin')
@section('title', __('Translation Editor'))

@section('content')
    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <a href="{{ route('admin.languages.index') }}" class="text-sm text-[var(--primary)]">{{ __('Languages') }}</a>
                <span class="text-sm text-[var(--text-muted)]">/</span>
                <span class="text-sm text-[var(--text-muted)]">{{ __('Translate') }}</span>
            </div>
            <h1 class="page-title">{{ __('Translate :name', ['name' => $language->name]) }}</h1>
            <p class="page-subtitle">{{ $language->native_name ?? $language->name }} ({{ $language->code }})</p>
        </div>
        <a href="{{ route('admin.languages.index') }}" class="btn btn-secondary">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> {{ __('Back') }}
        </a>
    </div>
    {{-- Search --}}
    <div class="mb-4">
        <div class="search-input-wrapper">
            <i data-lucide="search" class="search-icon"></i>
            <input type="text" id="translation-search" placeholder="{{ __('Search translations...') }}" class="form-input search-input">
        </div>
    </div>

    {{-- Progress --}}
    @php
        $totalKeys = count($sourceStrings);
        $translatedKeys = 0;
        foreach ($sourceStrings as $key => $value) {
            if (!empty($translations[$key])) $translatedKeys++;
        }
        $percentage = $totalKeys > 0 ? round(($translatedKeys / $totalKeys) * 100) : 0;
    @endphp
    <div class="card mb-4 p-4">
        <div class="flex items-center justify-between mb-2">
            <span class="text-sm font-medium text-[var(--text-primary)]">{{ __('Translation Progress') }}</span>
            <span class="text-sm font-semibold text-[var(--primary)]">{{ $translatedKeys }}/{{ $totalKeys }} ({{ $percentage }}%)</span>
        </div>
        <div class="bg-[var(--content-bg)] h-[8px]">
            <div class="bg-[var(--primary)]"></div>
        </div>
    </div>

    {{-- Translation Form --}}
    <form action="{{ route('admin.languages.save-translations', $language->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="card overflow-hidden">
            <div class="overflow-x-auto">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th class="w-[40px]">#</th>
                            <th style="width: 45%;">{{ __('English (Source)') }}</th>
                            <th style="width: 45%;">{{ __('Translation') }} ({{ $language->code }})</th>
                        </tr>
                    </thead>
                    <tbody id="translation-body">
                        @foreach($sourceStrings as $key => $value)
                            <tr class="translation-row" data-key="{{ strtolower($key) }}">
                                <td class="text-sm text-[var(--text-muted)]">{{ $loop->iteration }}</td>
                                <td style="vertical-align: top; padding-top: 14px;">
                                    <div class="text-sm font-medium text-[var(--text-primary)]">{{ $key }}</div>
                                </td>
                                <td>
                                    <input type="text"
                                           name="translations[{{ $key }}]"
                                           value="{{ $translations[$key] ?? '' }}"
                                           class="form-input w-full text-sm"
                                           placeholder="{{ $value }}" class="w-[200px]"
                                           {{ $language->direction === 'rtl' ? 'dir=rtl' : '' }}>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4 flex items-center justify-between">
            <span class="text-sm text-[var(--text-muted)]" id="visible-count">{{ $totalKeys }} {{ __('keys') }}</span>
            <div class="flex items-center gap-4">
                {{-- Pagination Controls --}}
                <div class="flex items-center gap-2" id="pagination-controls">
                    <button type="button" id="prev-page" class="btn btn-xs btn-secondary" disabled>
                        <i data-lucide="chevron-left" class="w-4 h-4"></i>
                    </button>
                    <span class="text-sm font-medium text-[var(--text-primary)]" id="page-info">1 / 1</span>
                    <button type="button" id="next-page" class="btn btn-xs btn-secondary">
                        <i data-lucide="chevron-right" class="w-4 h-4"></i>
                    </button>
                </div>
                <button type="submit" class="btn btn-primary">
                    <i data-lucide="save" class="w-4 h-4"></i> {{ __('Save Translations') }}
                </button>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
<script>
    (function() {
        var perPage = 20;
        var currentPage = 1;
        var allRows = Array.from(document.querySelectorAll('.translation-row'));
        var filteredRows = allRows.slice();
        var searchInput = document.getElementById('translation-search');
        var prevBtn = document.getElementById('prev-page');
        var nextBtn = document.getElementById('next-page');
        var pageInfo = document.getElementById('page-info');
        var visibleCount = document.getElementById('visible-count');

        function getTotalPages() {
            return Math.max(1, Math.ceil(filteredRows.length / perPage));
        }

        function renderPage() {
            var totalPages = getTotalPages();
            if (currentPage > totalPages) currentPage = totalPages;

            // Hide all rows first
            allRows.forEach(function(row) { row.style.display = 'none'; });

            // Show only current page rows
            var start = (currentPage - 1) * perPage;
            var end = start + perPage;
            for (var i = start; i < end && i < filteredRows.length; i++) {
                filteredRows[i].style.display = '';
            }

            // Update controls
            pageInfo.textContent = currentPage + ' / ' + totalPages;
            prevBtn.disabled = currentPage <= 1;
            nextBtn.disabled = currentPage >= totalPages;
            visibleCount.textContent = filteredRows.length + ' {{ __("keys") }}';
        }

        prevBtn.addEventListener('click', function() {
            if (currentPage > 1) { currentPage--; renderPage(); }
        });

        nextBtn.addEventListener('click', function() {
            if (currentPage < getTotalPages()) { currentPage++; renderPage(); }
        });

        searchInput.addEventListener('input', function() {
            var query = this.value.toLowerCase();
            currentPage = 1;

            if (query === '') {
                filteredRows = allRows.slice();
            } else {
                filteredRows = allRows.filter(function(row) {
                    var key = row.dataset.key;
                    var input = row.querySelector('input');
                    var val = input ? input.value.toLowerCase() : '';
                    return key.includes(query) || val.includes(query);
                });
            }
            renderPage();
        });

        // Initial render
        renderPage();
    })();
</script>
@endpush






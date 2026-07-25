@extends('layouts.admin')
@section('title', __('Edit Page') . ' - ' . $page->title)

@push('head')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css" rel="stylesheet">
@endpush

@section('content')
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary btn-sm">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
        </a>
        <div>
            <h1 class="page-title">{{ __('Edit Page') }}</h1>
            <p class="page-subtitle">{{ $page->title }}</p>
        </div>
    </div>

    <form action="{{ route('admin.pages.update', $page->id) }}" method="POST" id="page-form">
        @csrf @method('PUT')
        @include('admin.pages.partials.form', ['page' => $page])
    </form>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>
    <script>
        $(function() {
            $('#summernote-content').summernote({
                height: 260,
                placeholder: '{{ __("Start writing your page content...") }}',
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'strikethrough']],
                    ['font', ['superscript', 'subscript']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link', 'picture', 'table', 'hr']],
                    ['misc', ['fullscreen', 'codeview', 'undo', 'redo']],
                ],
            });
        });
    </script>
@endpush

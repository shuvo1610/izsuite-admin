@extends('layouts.admin')
@section('title', __('Edit FAQ') . ' - ' . $faq->question)

@push('head')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css" rel="stylesheet">
@endpush

@section('content')
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.faqs.index') }}" class="btn btn-secondary btn-sm">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
        </a>
        <div>
            <h1 class="page-title">{{ __('Edit FAQ') }}</h1>
            <p class="page-subtitle">{{ $faq->question }}</p>
        </div>
    </div>

    <form action="{{ route('admin.faqs.update', $faq->id) }}" method="POST" id="faq-form">
        @csrf
        @method('PUT')
        @include('admin.faqs._form', ['faq' => $faq])
    </form>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>
    <script>
        $(function() {
            $('#summernote-answer').summernote({
                height: 200,
                placeholder: '{{ __("Write the answer for this FAQ...") }}',
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

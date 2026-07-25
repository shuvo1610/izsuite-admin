@extends('layouts.admin')
@section('title', __('Create Language'))

@section('content')
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="page-title">{{ __('Create Language') }}</h1>
            <p class="page-subtitle">{{ __('Add a new supported locale') }}</p>
        </div>
        <a href="{{ route('admin.languages.index') }}" class="btn btn-secondary">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> {{ __('Back') }}
        </a>
    </div>

    <div class="card p-6">
        <form action="{{ route('admin.languages.store') }}" method="POST">
            @csrf
            @include('admin.languages._form')
            <div class="mt-6">
                <button type="submit" class="btn btn-primary">{{ __('Create Language') }}</button>
            </div>
        </form>
    </div>
@endsection

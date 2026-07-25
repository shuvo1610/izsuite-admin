@extends('layouts.admin')
@section('title', __('Edit Offline Method'))

@section('content')
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="page-title">{{ __('Edit Offline Method') }}</h1>
            <p class="page-subtitle">{{ __('Update') }} "{{ $method->name }}"</p>
        </div>
        <a href="{{ route('admin.payment-methods.index', ['tab' => 'offline']) }}" class="btn btn-secondary">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> {{ __('Back') }}
        </a>
    </div>

    <div class="card p-6">
        <form action="{{ route('admin.payment-methods.update', $method->id) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            @include('admin.payment-methods._form-offline')
            <div class="mt-6">
                <button type="submit" class="btn btn-primary">{{ __('Update Method') }}</button>
            </div>
        </form>
    </div>
@endsection

@extends('layouts.admin')
@section('title', __('Edit Currency'))

@section('content')
    <div class="mb-6">
        <h1 class="page-title">{{ __('Edit Currency') }}</h1>
        <p class="page-subtitle">{{ __('Update') }} "{{ $currency->name }}"</p>
    </div>

    @if($errors->any())
        <div class="p-3 rounded-xl mb-4 text-sm font-medium bg-[var(--danger-light)] text-[var(--danger)]">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('admin.currencies.update', $currency->id) }}" method="POST">
        @csrf @method('PUT')
        @include('admin.currencies._form')
    </form>
@endsection

@extends('layouts.admin')
@section('title', __('Edit Department'))

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.departments.index') }}" class="btn btn-secondary mb-4">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> {{ __('Back to Departments') }}
        </a>
        <h1 class="page-title">{{ __('Edit Department') }}</h1>
    </div>

    <div class="max-w-2xl">
        <form action="{{ route('admin.departments.update', $department->id) }}" method="POST" class="card">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name" class="form-label">{{ __('Department Name') }}</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $department->name) }}" required>
                @error('name') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div class="form-group">
                <label for="created_by" class="form-label">{{ __('Recruiter (Creator)') }}</label>
                <select name="created_by" id="created_by" class="form-control" required>
                    <option value="">{{ __('Select Recruiter') }}</option>
                    @foreach($recruiters as $recruiter)
                        <option value="{{ $recruiter->id }}" {{ old('created_by', $department->created_by) == $recruiter->id ? 'selected' : '' }}>
                            {{ $recruiter->name }} ({{ $recruiter->email }})
                        </option>
                    @endforeach
                </select>
                @error('created_by') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-end gap-3 mt-6">
                <button type="submit" class="btn btn-primary">{{ __('Update Department') }}</button>
            </div>
        </form>
    </div>
@endsection

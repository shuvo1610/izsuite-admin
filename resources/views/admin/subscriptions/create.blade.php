@extends('layouts.admin')
@section('title', __('Subscribe User'))

@section('content')
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="page-title">{{ __('Subscribe User') }}</h1>
            <p class="page-subtitle">{{ __('Assign a user to an active subscription plan') }}</p>
        </div>
        <a href="{{ route('admin.subscriptions.index') }}" class="btn btn-secondary">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            {{ __('Back') }}
        </a>
    </div>

    <div class="card p-6">
        <form action="{{ route('admin.subscriptions.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="form-group">
                    <label for="recruiter_id" class="form-label">{{ __('User') }} <span class="text-red-400">*</span></label>
                    <select name="recruiter_id" id="recruiter_id" class="form-select" required>
                        <option value="">{{ __('Select user') }}</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ (string) old('recruiter_id') === (string) $user->id ? 'selected' : '' }}>
                                {{ $user->name }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('recruiter_id') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="plan_id" class="form-label">{{ __('Plan') }} <span class="text-red-400">*</span></label>
                    <select name="plan_id" id="plan_id" class="form-select" required>
                        <option value="">{{ __('Select plan') }}</option>
                        @foreach($plans as $plan)
                            <option
                                value="{{ $plan->id }}"
                                {{ (string) old('plan_id') === (string) $plan->id ? 'selected' : '' }}
                            >
                                {{ $plan->name }} ({{ ucfirst($plan->billing_type ?? 'monthly') }})
                            </option>
                        @endforeach
                    </select>
                    @error('plan_id') <span class="form-error">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="form-group">
                    <label for="amount" class="form-label">{{ __('Amount') }}</label>
                    <input type="number" step="0.01" min="0" name="amount" id="amount" class="form-input" value="{{ old('amount') }}" placeholder="{{ __('Leave blank for free access') }}">
                    <p class="text-xs text-[var(--text-muted)] mt-1">{{ __('Optional. Blank means the user gets this plan in free mode.') }}</p>
                    @error('amount') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="status" class="form-label">{{ __('Status') }}</label>
                    <select name="status" id="status" class="form-select">
                        @php $selectedStatus = old('status', 'active'); @endphp
                        @foreach(['active', 'trial', 'pending', 'cancelled'] as $status)
                            <option value="{{ $status }}" {{ $selectedStatus === $status ? 'selected' : '' }}>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>
                    @error('status') <span class="form-error">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="form-group">
                    <label for="start_date" class="form-label">{{ __('Start Date') }}</label>
                    <input type="date" name="start_date" id="start_date" class="form-input" value="{{ old('start_date', now()->toDateString()) }}">
                    @error('start_date') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="next_renewal_date" class="form-label">{{ __('Next Renewal Date') }}</label>
                    <input type="date" name="next_renewal_date" id="next_renewal_date" class="form-input" value="{{ old('next_renewal_date') }}">
                    <p class="text-xs text-[var(--text-muted)] mt-1">{{ __('Optional. Auto-calculated from plan cycle if empty.') }}</p>
                    @error('next_renewal_date') <span class="form-error">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="flex items-center gap-3">
                <button type="submit" class="btn btn-primary">
                    <i data-lucide="check" class="w-4 h-4"></i>
                    {{ __('Subscribe User') }}
                </button>
                <a href="{{ route('admin.subscriptions.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
            </div>
        </form>
    </div>

@endsection

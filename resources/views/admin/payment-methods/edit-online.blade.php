@extends('layouts.admin')
@section('title', __('Configure') . ' ' . $method->name)

@section('content')
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="page-title">{{ __('Configure') }} {{ $method->name }}</h1>
            <p class="page-subtitle">{{ __('Manage API keys and gateway settings') }}</p>
        </div>
        <a href="{{ route('admin.payment-methods.index', ['tab' => 'online']) }}" class="btn btn-secondary">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> {{ __('Back') }}
        </a>
    </div>
    <form action="{{ route('admin.payment-methods.update', $method->id) }}" method="POST">
        @csrf @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- API Keys --}}
            <div class="lg:col-span-2">
                <div class="card p-6">
                    <h2 class="text-lg font-semibold mb-4 text-[var(--text-primary)]">
                        <i data-lucide="key" class="w-5 h-5 inline-block me-1"></i> {{ __('API Credentials') }}
                    </h2>

                    @php $fields = $method->credential_fields; @endphp

                    @if(count($fields) > 0)
                        <div class="space-y-4">
                            @foreach($fields as $key => $label)
                                <div class="form-group">
                                    <label for="cred_{{ $key }}" class="form-label">{{ $label }}</label>
                                    <input
                                        type="{{ str_contains($key, 'secret') || str_contains($key, 'password') ? 'password' : 'text' }}"
                                        name="credentials[{{ $key }}]"
                                        id="cred_{{ $key }}"
                                        class="form-input font-mono text-sm"
                                        value="{{ $method->credential($key) }}"
                                        placeholder="{{ __('Enter') }} {{ strtolower($label) }}..."
                                    >
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-[var(--text-muted)]">{{ __('No credential fields defined for this gateway.') }}</p>
                    @endif
                </div>
            </div>

            {{-- Status & Mode --}}
            <div>
                <div class="card p-6">
                    <h2 class="text-lg font-semibold mb-4 text-[var(--text-primary)]">
                        <i data-lucide="settings" class="w-5 h-5 inline-block me-1"></i> {{ __('Status') }}
                    </h2>

                    <div class="space-y-4">
                        <label class="flex items-center gap-3 p-3 rounded-lg cursor-pointer bg-[var(--body-bg)]">
                            <input type="checkbox" name="is_active" value="1" class="form-checkbox" {{ $method->is_active ? 'checked' : '' }}>
                            <div>
                                <span class="text-sm font-medium block text-[var(--text-primary)]">{{ __('Activate Gateway') }}</span>
                                <span class="text-xs text-[var(--text-muted)]">{{ __('Enable this payment method for users') }}</span>
                            </div>
                        </label>

                        <label class="flex items-center gap-3 p-3 rounded-lg cursor-pointer bg-[var(--body-bg)]">
                            <input type="checkbox" name="is_sandbox" value="1" class="form-checkbox" {{ $method->is_sandbox ? 'checked' : '' }}>
                            <div>
                                <span class="text-sm font-medium block text-[var(--text-primary)]">{{ __('Sandbox Mode') }}</span>
                                <span class="text-xs text-[var(--text-muted)]">{{ __('Use test/sandbox API keys') }}</span>
                            </div>
                        </label>
                    </div>

                    @if($method->is_sandbox)
                        <div class="mt-4 p-3 rounded-lg text-xs bg-[var(--warning-light)] text-[var(--warning-dark)]">
                            <i data-lucide="alert-triangle" class="w-3.5 h-3.5 inline-block me-1"></i>
                            <strong>{{ __('Sandbox mode is ON.') }}</strong> {{ __('No real charges will be processed. Turn this off before going live.') }}
                        </div>
                    @endif
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary w-full">
                        <i data-lucide="save" class="w-4 h-4"></i> {{ __('Save Configuration') }}
                    </button>
                </div>
            </div>
        </div>
    </form>
@endsection


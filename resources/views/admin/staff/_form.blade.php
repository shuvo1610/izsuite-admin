{{-- Shared Staff form partial — used by create.blade.php and edit.blade.php --}}
@php
    $isEdit = isset($staffUser);
@endphp

{{-- Name --}}
<div class="mb-4">
    <label class="form-label" for="name">{{ __('Full Name') }}</label>
    <input type="text" id="name" name="name" value="{{ old('name', $isEdit ? $staffUser->name : '') }}" class="form-input" placeholder="John Doe" required>
    @error('name')
        <p class="text-xs mt-1 text-[var(--danger)]">{{ $message }}</p>
    @enderror
</div>

{{-- Email --}}
<div class="mb-4">
    <label class="form-label" for="email">{{ __('Email Address') }}</label>
    <input type="email" id="email" name="email" value="{{ old('email', $isEdit ? $staffUser->email : '') }}" class="form-input" placeholder="john@example.com" required>
    @error('email')
        <p class="text-xs mt-1 text-[var(--danger)]">{{ $message }}</p>
    @enderror
</div>

{{-- Role --}}
<div class="mb-4">
    <label class="form-label" for="role_id">{{ __('Role') }}</label>
    <select id="role_id" name="role_id" class="form-input" required>
        @unless($isEdit)
            <option value="">{{ __('Select a role') }}</option>
        @endunless
        @foreach($roles as $role)
            <option value="{{ $role->id }}" {{ old('role_id', $isEdit ? $staffUser->role_id : '') == $role->id ? 'selected' : '' }}>
                {{ $role->name }}
            </option>
        @endforeach
    </select>
    @error('role_id')
        <p class="text-xs mt-1 text-[var(--danger)]">{{ $message }}</p>
    @enderror
</div>

<div class="divider"></div>

{{-- Password --}}
<div class="mb-4">
    <label class="form-label" for="password">{{ $isEdit ? __('New Password') : __('Password') }}</label>
    <input type="password" id="password" name="password" class="form-input"
        placeholder="{{ $isEdit ? __('Leave blank to keep current') : __('Minimum 8 characters') }}"
        {{ $isEdit ? '' : 'required' }}>
    @if($isEdit)
        <p class="text-xs mt-1 text-[var(--text-muted)]">{{ __('Only fill this if you want to change the password.') }}</p>
    @endif
    @error('password')
        <p class="text-xs mt-1 text-[var(--danger)]">{{ $message }}</p>
    @enderror
</div>

{{-- Confirm Password --}}
<div class="mb-4">
    <label class="form-label" for="password_confirmation">{{ $isEdit ? __('Confirm New Password') : __('Confirm Password') }}</label>
    <input type="password" id="password_confirmation" name="password_confirmation" class="form-input"
        placeholder="{{ $isEdit ? __('Re-enter new password') : __('Re-enter password') }}"
        {{ $isEdit ? '' : 'required' }}>
</div>

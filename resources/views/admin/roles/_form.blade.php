{{-- Shared Role form partial — used by create.blade.php and edit.blade.php --}}
@php
    $isEdit = isset($role);
    $currentPerms = old('permissions', $isEdit ? ($role->permissions ?? []) : []);
@endphp





{{-- Role Name --}}
<div class="card mb-6">
    <div class="mb-4">
        <label class="form-label" for="name">{{ __('Role Name') }}</label>
        <input type="text" id="name" name="name" value="{{ old('name', $isEdit ? $role->name : '') }}" class="form-input" placeholder="{{ __('e.g. Editor, Support Agent') }}" required>
        @error('name')
            <p class="text-xs mt-1 text-[var(--danger)]">{{ $message }}</p>
        @enderror
    </div>
</div>

{{-- Permissions Grid --}}
<div class="card mb-6">
    <div class="flex items-center justify-between mb-4">
        <div>
            <h3 class="section-title">{{ __('Permissions') }}</h3>
            <p class="text-sm text-[var(--text-muted)]">{{ __('Enable access to specific modules.') }}</p>
        </div>
        <div class="text-sm">
            <button type="button" class="text-primary hover:underline" onclick="toggleAllPerms(true)">{{ __('Enable All') }}</button>
            <span class="mx-1 text-muted">/</span>
            <button type="button" class="text-danger hover:underline" onclick="toggleAllPerms(false)">{{ __('Disable All') }}</button>
        </div>
    </div>

    @foreach($permissionGroups as $module => $permissions)
        <div class="mb-6 p-4 rounded-lg" style="background: var(--bg-secondary, #f8fafc); border: 1px solid var(--border-color, #e2e8f0);">
            <div class="flex items-center gap-3 mb-3 pb-3 border-b border-gray-100 dark:border-gray-700">
                <input type="checkbox" class="module-toggle toggle-switch" data-module="{{ $module }}"
                    onchange="toggleModule(this, '{{ $module }}')">
                <span class="font-bold text-base text-[var(--text-primary)]">{{ $module }}</span>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-3">
                @foreach($permissions as $perm)
                    <label class="flex items-center gap-3 cursor-pointer p-2 rounded hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                        <input type="checkbox" name="permissions[]" value="{{ $perm['name'] }}"
                            class="toggle-switch module-perm-{{ $module }}"
                            {{ in_array($perm['name'], $currentPerms) ? 'checked' : '' }}>
                        <span class="text-sm font-medium text-[var(--text-secondary)]">{{ $perm['label'] }}</span>
                    </label>
                @endforeach
            </div>
        </div>
    @endforeach
</div>

{{-- Submit --}}
<div class="flex items-center gap-3">
    <button type="submit" class="btn btn-primary">
        <i data-lucide="{{ $isEdit ? 'save' : 'plus' }}" class="w-4 h-4"></i>
        {{ $isEdit ? __('Save Changes') : __('Create Role') }}
    </button>
    <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
</div>

@push('scripts')
<script>
    function toggleAllPerms(state) {
        document.querySelectorAll('input[type="checkbox"]').forEach(el => {
            el.checked = state;
        });
        initModuleToggles();
    }

    function toggleModule(checkbox, module) {
        var checks = document.querySelectorAll('.module-perm-' + module);
        checks.forEach(function(c) { c.checked = checkbox.checked; });
    }

    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('toggle-switch') && !e.target.classList.contains('module-toggle')) {
            initModuleToggles();
        }
    });

    function initModuleToggles() {
        document.querySelectorAll('.module-toggle').forEach(function(toggle) {
            var module = toggle.getAttribute('data-module');
            var all = document.querySelectorAll('.module-perm-' + module);
            var checked = document.querySelectorAll('.module-perm-' + module + ':checked');
            
            if (all.length > 0) {
                toggle.checked = all.length === checked.length;
                toggle.indeterminate = checked.length > 0 && checked.length < all.length;
            }
        });
    }
    
    // Initialize on load
    initModuleToggles();
</script>
@endpush

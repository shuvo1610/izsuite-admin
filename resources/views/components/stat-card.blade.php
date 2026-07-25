{{-- Stat Card Component --}}
{{-- Usage: @include('components.stat-card', ['label' => '...', 'value' => '...', 'trend' => '...', 'trendType' => 'positive|negative|neutral', 'icon' => 'lucide-icon-name', 'iconColor' => 'green|blue|yellow|red']) --}}

<div class="stat-card animate-fade-in-up {{ $stagger ?? '' }}">
    <div>
        <p class="stat-label">{{ $label }}</p>
        <p class="stat-value">{{ $value }}</p>
        @if(!empty($trend))
            <p class="stat-trend {{ $trendType ?? 'neutral' }}">{{ $trend }}</p>
        @endif
    </div>
    <div class="stat-icon {{ $iconColor ?? 'green' }}">
        <i data-lucide="{{ $icon ?? 'activity' }}" class="w-5 h-5"></i>
    </div>
</div>

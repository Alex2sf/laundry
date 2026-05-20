@props(['title', 'value', 'icon', 'from', 'to', 'trend' => null, 'trendUp' => true, 'prefix' => ''])

<div class="stat-card" style="--from: {{ $from }}; --to: {{ $to }};">
    <div class="relative z-10">
        <div class="flex items-center justify-between mb-3">
            <span class="text-sm font-medium text-white/80">{{ $title }}</span>
            <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center">
                {!! $icon !!}
            </div>
        </div>
        <div class="text-2xl lg:text-3xl font-extrabold">{{ $prefix }}{{ $value }}</div>
        @if($trend)
            <div class="flex items-center gap-1 mt-2 text-sm text-white/80">
                @if($trendUp)
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                @else
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"/></svg>
                @endif
                <span>{{ $trend }}</span>
            </div>
        @endif
    </div>
</div>

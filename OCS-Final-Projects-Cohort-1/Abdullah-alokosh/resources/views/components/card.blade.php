@props(['padding' => 'p-6', 'hover' => false, 'gradient' => false])

<div {{ $attributes->merge(['class' => 'bg-white rounded-2xl shadow-sm border border-slate-200/50 ' . $padding]) }}>
    @if($gradient)
        <div class="absolute inset-0 bg-gradient-to-br from-indigo-500/5 to-purple-500/5 rounded-2xl pointer-events-none"></div>
    @endif
    {{ $slot }}
</div>

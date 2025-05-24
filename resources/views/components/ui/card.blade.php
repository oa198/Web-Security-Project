@props([
    'title' => null,
    'subtitle' => null,
    'actions' => null,
    'class' => '',
])

<div {{ $attributes->merge(['class' => 'bg-white p-5 rounded-lg shadow-sm border border-gray-200 ' . $class]) }}>
    @if($title || $subtitle || $actions)
        <div class="flex justify-between items-center mb-4">
            <div>
                @if($title)
                    <h3 class="text-lg font-semibold text-gray-900">{{ $title }}</h3>
                @endif
                
                @if($subtitle)
                    <p class="text-sm text-gray-500">{{ $subtitle }}</p>
                @endif
            </div>
            
            @if($actions)
                <div>
                    {{ $actions }}
                </div>
            @endif
        </div>
    @endif
    
    {{ $slot }}
</div>

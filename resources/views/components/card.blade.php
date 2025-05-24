<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
    @if(isset($title))
    <div class="bg-gray-50 px-4 py-3 border-b">
        <h3 class="text-lg font-medium text-gray-900">{{ $title }}</h3>
    </div>
    @endif
    <div class="p-6">
        {{ $slot }}
    </div>
</div>

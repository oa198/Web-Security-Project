<x-ui.card 
    title="Weekly Schedule" 
    subtitle="Current semester classes"
    class="h-full"
>
    <x-slot name="actions">
        <a href="{{ route('schedule.index') }}" class="text-sm text-purple-600 hover:underline">Full Calendar</a>
    </x-slot>
    
    @if(isset($schedule) && count($schedule) > 0)
        <div class="overflow-x-auto">
            <table class="w-full min-w-full">
                <thead>
                    <tr>
                        <th class="w-16 py-2 text-left text-xs font-semibold text-gray-500">Time</th>
                        <th class="py-2 text-center text-xs font-semibold text-gray-500">Mon</th>
                        <th class="py-2 text-center text-xs font-semibold text-gray-500">Tue</th>
                        <th class="py-2 text-center text-xs font-semibold text-gray-500">Wed</th>
                        <th class="py-2 text-center text-xs font-semibold text-gray-500">Thu</th>
                        <th class="py-2 text-center text-xs font-semibold text-gray-500">Fri</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($timeSlots as $time)
                        <tr class="border-t border-gray-100">
                            <td class="py-2 align-top text-xs text-gray-500">{{ $time }}</td>
                            
                            @foreach(['Mon', 'Tue', 'Wed', 'Thu', 'Fri'] as $day)
                                <td class="p-1 align-top">
                                    @if(isset($schedule[$day][$time]))
                                        @php 
                                            $class = $schedule[$day][$time];
                                            $bgColor = isset($class['color']) ? $class['color'] : 'bg-purple-100 border-purple-200 text-purple-800';
                                        @endphp
                                        <div class="p-1.5 text-xs rounded border {{ $bgColor }}">
                                            <div class="font-medium">{{ $class['code'] }}</div>
                                            <div class="text-[10px] truncate">{{ $class['location'] }}</div>
                                        </div>
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="p-4 flex flex-col items-center justify-center text-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <h3 class="text-sm font-medium text-gray-900">No schedule data available</h3>
            <p class="text-xs text-gray-500 mt-1">Your class schedule will appear here once available.</p>
        </div>
    @endif
</x-ui.card>

<x-ui.card 
    title="Grade Distribution" 
    subtitle="Current semester performance"
    class="h-full"
>
    <x-slot name="actions">
        <a href="{{ route('grades.index') }}" class="text-sm text-purple-600 hover:underline">Details</a>
    </x-slot>
    
    @if(isset($gradeDistribution) && count($gradeDistribution) > 0)
        <div class="space-y-2">
            @foreach($gradeDistribution as $grade => $count)
                @php
                    $percentage = $totalGrades > 0 ? ($count / $totalGrades) * 100 : 0;
                    $color = in_array($grade, ['A', 'A-']) ? 'bg-green-500' : 
                            (in_array($grade, ['B+', 'B', 'B-']) ? 'bg-blue-500' : 
                            (in_array($grade, ['C+', 'C', 'C-']) ? 'bg-yellow-500' : 'bg-red-500'));
                @endphp
                <div class="flex items-center">
                    <div class="w-8 text-sm font-medium text-gray-700">{{ $grade }}</div>
                    <div class="flex-1 h-6 bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full {{ $color }} rounded-full transition-all duration-700" style="width: {{ $percentage }}%"></div>
                    </div>
                    <div class="w-8 text-right text-sm text-gray-500 ml-2">{{ $count }}</div>
                </div>
            @endforeach
        </div>
        
        <div class="mt-4 pt-4 border-t border-gray-100">
            <div class="flex justify-between text-sm">
                <div class="font-medium text-gray-700">Current GPA</div>
                <div class="font-semibold text-gray-900">{{ number_format($currentGPA ?? 0, 2) }}</div>
            </div>
            
            <div class="mt-2 h-2 bg-gray-100 rounded-full overflow-hidden">
                <div class="h-full bg-purple-600 rounded-full" style="width: {{ ($currentGPA ?? 0) / 4 * 100 }}%"></div>
            </div>
            
            <div class="mt-1 flex justify-between text-xs text-gray-500">
                <div>0.0</div>
                <div>4.0</div>
            </div>
        </div>
    @else
        <div class="p-4 flex flex-col items-center justify-center text-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
            </svg>
            <h3 class="text-sm font-medium text-gray-900">No grades data available</h3>
            <p class="text-xs text-gray-500 mt-1">Grade information will appear here once available.</p>
        </div>
    @endif
</x-ui.card>

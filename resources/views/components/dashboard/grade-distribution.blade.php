<x-ui.card 
    title="Grade Distribution" 
    subtitle="Current semester performance"
    class="h-full"
>
    <x-slot name="actions">
        <a href="{{ route('grades.index') }}" class="text-sm text-purple-600 hover:underline">Details</a>
    </x-slot>
    
    <div class="space-y-2">
        <!-- Grade A -->
        <div class="flex items-center">
            <div class="w-8 text-sm font-medium text-gray-700">A</div>
            <div class="flex-1 h-6 bg-gray-100 rounded-full overflow-hidden">
                <div class="h-full bg-green-500 rounded-full transition-all duration-700" style="width: 100%"></div>
            </div>
            <div class="w-8 text-right text-sm text-gray-500 ml-2">2</div>
        </div>
        
        <!-- Grade A- -->
        <div class="flex items-center">
            <div class="w-8 text-sm font-medium text-gray-700">A-</div>
            <div class="flex-1 h-6 bg-gray-100 rounded-full overflow-hidden">
                <div class="h-full bg-green-500 rounded-full transition-all duration-700" style="width: 50%"></div>
            </div>
            <div class="w-8 text-right text-sm text-gray-500 ml-2">1</div>
        </div>
        
        <!-- Grade B+ -->
        <div class="flex items-center">
            <div class="w-8 text-sm font-medium text-gray-700">B+</div>
            <div class="flex-1 h-6 bg-gray-100 rounded-full overflow-hidden">
                <div class="h-full bg-blue-500 rounded-full transition-all duration-700" style="width: 50%"></div>
            </div>
            <div class="w-8 text-right text-sm text-gray-500 ml-2">1</div>
        </div>
        
        <!-- Grade B -->
        <div class="flex items-center">
            <div class="w-8 text-sm font-medium text-gray-700">B</div>
            <div class="flex-1 h-6 bg-gray-100 rounded-full overflow-hidden">
                <div class="h-full bg-blue-500 rounded-full transition-all duration-700" style="width: 50%"></div>
            </div>
            <div class="w-8 text-right text-sm text-gray-500 ml-2">1</div>
        </div>
    </div>
    
    <div class="mt-4 pt-4 border-t border-gray-100">
        <div class="flex justify-between text-sm">
            <div class="font-medium text-gray-700">Current GPA</div>
            <div class="font-semibold text-gray-900">3.75</div>
        </div>
        
        <div class="mt-2 h-2 bg-gray-100 rounded-full overflow-hidden">
            <div class="h-full bg-purple-600 rounded-full" style="width: 75%"></div>
        </div>
        
        <div class="mt-1 flex justify-between text-xs text-gray-500">
            <div>0.0</div>
            <div>4.0</div>
        </div>
    </div>
</x-ui.card>

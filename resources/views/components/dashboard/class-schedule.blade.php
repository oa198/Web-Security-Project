<x-ui.card 
    title="Weekly Schedule" 
    subtitle="Current semester classes"
    class="h-full"
>
    <x-slot name="actions">
        <a href="{{ route('schedule.index') }}" class="text-sm text-purple-600 hover:underline">Full Calendar</a>
    </x-slot>
    
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
                <!-- 8am Time Slot -->
                <tr class="border-t border-gray-100">
                    <td class="py-2 align-top text-xs text-gray-500">8am</td>
                    <td class="p-1 align-top"></td>
                    <td class="p-1 align-top"></td>
                    <td class="p-1 align-top"></td>
                    <td class="p-1 align-top"></td>
                    <td class="p-1 align-top"></td>
                </tr>
                
                <!-- 9am Time Slot -->
                <tr class="border-t border-gray-100">
                    <td class="py-2 align-top text-xs text-gray-500">9am</td>
                    <td class="p-1 align-top">
                        <div class="p-1.5 text-xs rounded border bg-blue-100 border-blue-200 text-blue-800">
                            <div class="font-medium">MATH201</div>
                            <div class="text-[10px] truncate">Math Building 201</div>
                        </div>
                    </td>
                    <td class="p-1 align-top"></td>
                    <td class="p-1 align-top">
                        <div class="p-1.5 text-xs rounded border bg-blue-100 border-blue-200 text-blue-800">
                            <div class="font-medium">MATH201</div>
                            <div class="text-[10px] truncate">Math Building 201</div>
                        </div>
                    </td>
                    <td class="p-1 align-top"></td>
                    <td class="p-1 align-top">
                        <div class="p-1.5 text-xs rounded border bg-blue-100 border-blue-200 text-blue-800">
                            <div class="font-medium">MATH201</div>
                            <div class="text-[10px] truncate">Math Building 201</div>
                        </div>
                    </td>
                </tr>
                
                <!-- 10am Time Slot -->
                <tr class="border-t border-gray-100">
                    <td class="py-2 align-top text-xs text-gray-500">10am</td>
                    <td class="p-1 align-top">
                        <div class="p-1.5 text-xs rounded border bg-purple-100 border-purple-200 text-purple-800">
                            <div class="font-medium">CS101</div>
                            <div class="text-[10px] truncate">Science Building 305</div>
                        </div>
                    </td>
                    <td class="p-1 align-top"></td>
                    <td class="p-1 align-top">
                        <div class="p-1.5 text-xs rounded border bg-purple-100 border-purple-200 text-purple-800">
                            <div class="font-medium">CS101</div>
                            <div class="text-[10px] truncate">Science Building 305</div>
                        </div>
                    </td>
                    <td class="p-1 align-top"></td>
                    <td class="p-1 align-top"></td>
                </tr>
                
                <!-- 11am Time Slot -->
                <tr class="border-t border-gray-100">
                    <td class="py-2 align-top text-xs text-gray-500">11am</td>
                    <td class="p-1 align-top"></td>
                    <td class="p-1 align-top"></td>
                    <td class="p-1 align-top"></td>
                    <td class="p-1 align-top"></td>
                    <td class="p-1 align-top"></td>
                </tr>
                
                <!-- 12pm Time Slot -->
                <tr class="border-t border-gray-100">
                    <td class="py-2 align-top text-xs text-gray-500">12pm</td>
                    <td class="p-1 align-top"></td>
                    <td class="p-1 align-top"></td>
                    <td class="p-1 align-top"></td>
                    <td class="p-1 align-top"></td>
                    <td class="p-1 align-top"></td>
                </tr>
                
                <!-- 1pm Time Slot -->
                <tr class="border-t border-gray-100">
                    <td class="py-2 align-top text-xs text-gray-500">1pm</td>
                    <td class="p-1 align-top"></td>
                    <td class="p-1 align-top">
                        <div class="p-1.5 text-xs rounded border bg-purple-100 border-purple-200 text-purple-800">
                            <div class="font-medium">CS202</div>
                            <div class="text-[10px] truncate">Tech Building 405</div>
                        </div>
                    </td>
                    <td class="p-1 align-top"></td>
                    <td class="p-1 align-top">
                        <div class="p-1.5 text-xs rounded border bg-purple-100 border-purple-200 text-purple-800">
                            <div class="font-medium">CS202</div>
                            <div class="text-[10px] truncate">Tech Building 405</div>
                        </div>
                    </td>
                    <td class="p-1 align-top"></td>
                </tr>
                
                <!-- 2pm Time Slot -->
                <tr class="border-t border-gray-100">
                    <td class="py-2 align-top text-xs text-gray-500">2pm</td>
                    <td class="p-1 align-top"></td>
                    <td class="p-1 align-top"></td>
                    <td class="p-1 align-top"></td>
                    <td class="p-1 align-top"></td>
                    <td class="p-1 align-top"></td>
                </tr>
                
                <!-- 3pm Time Slot -->
                <tr class="border-t border-gray-100">
                    <td class="py-2 align-top text-xs text-gray-500">3pm</td>
                    <td class="p-1 align-top"></td>
                    <td class="p-1 align-top">
                        <div class="p-1.5 text-xs rounded border bg-green-100 border-green-200 text-green-800">
                            <div class="font-medium">ENG105</div>
                            <div class="text-[10px] truncate">Humanities 102</div>
                        </div>
                    </td>
                    <td class="p-1 align-top"></td>
                    <td class="p-1 align-top">
                        <div class="p-1.5 text-xs rounded border bg-green-100 border-green-200 text-green-800">
                            <div class="font-medium">ENG105</div>
                            <div class="text-[10px] truncate">Humanities 102</div>
                        </div>
                    </td>
                    <td class="p-1 align-top"></td>
                </tr>
                
                <!-- 4pm Time Slot -->
                <tr class="border-t border-gray-100">
                    <td class="py-2 align-top text-xs text-gray-500">4pm</td>
                    <td class="p-1 align-top"></td>
                    <td class="p-1 align-top"></td>
                    <td class="p-1 align-top"></td>
                    <td class="p-1 align-top"></td>
                    <td class="p-1 align-top"></td>
                </tr>
            </tbody>
        </table>
    </div>
</x-ui.card>

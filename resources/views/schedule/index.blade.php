@extends('layouts.app')

@section('title', 'Class Schedule - Student Portal')

@section('page_title', 'Class Schedule')

@section('content')
<div class="space-y-6">
    <!-- View Toggle -->
    <div class="flex gap-2">
        <button
            id="week-view-btn"
            class="px-4 py-2 rounded-lg bg-primary-100 text-primary-800"
            onclick="toggleView('week')"
        >
            Week View
        </button>
        <button
            id="list-view-btn"
            class="px-4 py-2 rounded-lg bg-gray-100 text-gray-600"
            onclick="toggleView('list')"
        >
            List View
        </button>
    </div>

    <!-- Week View -->
    <div id="week-view" class="bg-white rounded-lg shadow-sm border p-5">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[800px]">
                <thead>
                    <tr>
                        <th class="w-20 py-2 text-left text-xs font-semibold text-gray-500">Time</th>
                        <th class="py-2 text-center text-xs font-semibold text-gray-500">Monday</th>
                        <th class="py-2 text-center text-xs font-semibold text-gray-500">Tuesday</th>
                        <th class="py-2 text-center text-xs font-semibold text-gray-500">Wednesday</th>
                        <th class="py-2 text-center text-xs font-semibold text-gray-500">Thursday</th>
                        <th class="py-2 text-center text-xs font-semibold text-gray-500">Friday</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach(['8:00 AM', '9:00 AM', '10:00 AM', '11:00 AM', '12:00 PM', '1:00 PM', '2:00 PM', '3:00 PM', '4:00 PM', '5:00 PM', '6:00 PM', '7:00 PM', '8:00 PM'] as $timeSlot)
                    <tr class="border-t border-gray-100">
                        <td class="py-2 align-top text-xs text-gray-500">{{ $timeSlot }}</td>
                        
                        <!-- Monday -->
                        <td class="p-1 align-top">
                            @if($timeSlot == '9:00 AM')
                            <div class="p-1.5 text-xs rounded border bg-purple-100 text-purple-800 border-purple-200">
                                <div class="font-medium">CS 101</div>
                                <div class="text-[10px] truncate">Room 305</div>
                            </div>
                            @elseif($timeSlot == '2:00 PM')
                            <div class="p-1.5 text-xs rounded border bg-green-100 text-green-800 border-green-200">
                                <div class="font-medium">ENG 205</div>
                                <div class="text-[10px] truncate">Library 201</div>
                            </div>
                            @endif
                        </td>
                        
                        <!-- Tuesday -->
                        <td class="p-1 align-top">
                            @if($timeSlot == '11:00 AM')
                            <div class="p-1.5 text-xs rounded border bg-blue-100 text-blue-800 border-blue-200">
                                <div class="font-medium">MATH 201</div>
                                <div class="text-[10px] truncate">Room 401</div>
                            </div>
                            @elseif($timeSlot == '3:00 PM')
                            <div class="p-1.5 text-xs rounded border bg-yellow-100 text-yellow-800 border-yellow-200">
                                <div class="font-medium">PHYS 102</div>
                                <div class="text-[10px] truncate">Lab 305</div>
                            </div>
                            @endif
                        </td>
                        
                        <!-- Wednesday -->
                        <td class="p-1 align-top">
                            @if($timeSlot == '9:00 AM')
                            <div class="p-1.5 text-xs rounded border bg-purple-100 text-purple-800 border-purple-200">
                                <div class="font-medium">CS 101</div>
                                <div class="text-[10px] truncate">Room 305</div>
                            </div>
                            @elseif($timeSlot == '1:00 PM')
                            <div class="p-1.5 text-xs rounded border bg-green-100 text-green-800 border-green-200">
                                <div class="font-medium">ENG 205</div>
                                <div class="text-[10px] truncate">Library 201</div>
                            </div>
                            @endif
                        </td>
                        
                        <!-- Thursday -->
                        <td class="p-1 align-top">
                            @if($timeSlot == '11:00 AM')
                            <div class="p-1.5 text-xs rounded border bg-blue-100 text-blue-800 border-blue-200">
                                <div class="font-medium">MATH 201</div>
                                <div class="text-[10px] truncate">Room 401</div>
                            </div>
                            @elseif($timeSlot == '3:00 PM')
                            <div class="p-1.5 text-xs rounded border bg-yellow-100 text-yellow-800 border-yellow-200">
                                <div class="font-medium">PHYS 102</div>
                                <div class="text-[10px] truncate">Lab 305</div>
                            </div>
                            @endif
                        </td>
                        
                        <!-- Friday -->
                        <td class="p-1 align-top">
                            @if($timeSlot == '10:00 AM')
                            <div class="p-1.5 text-xs rounded border bg-purple-100 text-purple-800 border-purple-200">
                                <div class="font-medium">CS 201</div>
                                <div class="text-[10px] truncate">Room 305</div>
                            </div>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- List View -->
    <div id="list-view" class="space-y-4 hidden">
        <!-- Monday -->
        <div class="bg-white rounded-lg shadow-sm border p-5">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Monday</h3>
            <div class="space-y-3">
                <div class="p-3 rounded-lg bg-purple-100 text-purple-800 border-purple-200">
                    <div class="flex justify-between items-start">
                        <div>
                            <h4 class="font-medium">Introduction to Computer Science</h4>
                            <p class="text-sm">CS 101</p>
                        </div>
                        <div class="text-sm">
                            9:00 AM - 10:30 AM
                        </div>
                    </div>
                    <div class="mt-2 text-sm">
                        <p>Prof. Alan Turing</p>
                        <p>Room 305</p>
                    </div>
                </div>
                <div class="p-3 rounded-lg bg-green-100 text-green-800 border-green-200">
                    <div class="flex justify-between items-start">
                        <div>
                            <h4 class="font-medium">English Composition</h4>
                            <p class="text-sm">ENG 205</p>
                        </div>
                        <div class="text-sm">
                            2:00 PM - 3:30 PM
                        </div>
                    </div>
                    <div class="mt-2 text-sm">
                        <p>Dr. Jane Austin</p>
                        <p>Library 201</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tuesday -->
        <div class="bg-white rounded-lg shadow-sm border p-5">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Tuesday</h3>
            <div class="space-y-3">
                <div class="p-3 rounded-lg bg-blue-100 text-blue-800 border-blue-200">
                    <div class="flex justify-between items-start">
                        <div>
                            <h4 class="font-medium">Calculus II</h4>
                            <p class="text-sm">MATH 201</p>
                        </div>
                        <div class="text-sm">
                            11:00 AM - 12:30 PM
                        </div>
                    </div>
                    <div class="mt-2 text-sm">
                        <p>Dr. Katherine Johnson</p>
                        <p>Room 401</p>
                    </div>
                </div>
                <div class="p-3 rounded-lg bg-yellow-100 text-yellow-800 border-yellow-200">
                    <div class="flex justify-between items-start">
                        <div>
                            <h4 class="font-medium">Physics Lab</h4>
                            <p class="text-sm">PHYS 102</p>
                        </div>
                        <div class="text-sm">
                            3:00 PM - 5:00 PM
                        </div>
                    </div>
                    <div class="mt-2 text-sm">
                        <p>Dr. Richard Feynman</p>
                        <p>Lab 305</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Wednesday -->
        <div class="bg-white rounded-lg shadow-sm border p-5">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Wednesday</h3>
            <div class="space-y-3">
                <div class="p-3 rounded-lg bg-purple-100 text-purple-800 border-purple-200">
                    <div class="flex justify-between items-start">
                        <div>
                            <h4 class="font-medium">Introduction to Computer Science</h4>
                            <p class="text-sm">CS 101</p>
                        </div>
                        <div class="text-sm">
                            9:00 AM - 10:30 AM
                        </div>
                    </div>
                    <div class="mt-2 text-sm">
                        <p>Prof. Alan Turing</p>
                        <p>Room 305</p>
                    </div>
                </div>
                <div class="p-3 rounded-lg bg-green-100 text-green-800 border-green-200">
                    <div class="flex justify-between items-start">
                        <div>
                            <h4 class="font-medium">English Composition</h4>
                            <p class="text-sm">ENG 205</p>
                        </div>
                        <div class="text-sm">
                            1:00 PM - 2:30 PM
                        </div>
                    </div>
                    <div class="mt-2 text-sm">
                        <p>Dr. Jane Austin</p>
                        <p>Library 201</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Thursday -->
        <div class="bg-white rounded-lg shadow-sm border p-5">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Thursday</h3>
            <div class="space-y-3">
                <div class="p-3 rounded-lg bg-blue-100 text-blue-800 border-blue-200">
                    <div class="flex justify-between items-start">
                        <div>
                            <h4 class="font-medium">Calculus II</h4>
                            <p class="text-sm">MATH 201</p>
                        </div>
                        <div class="text-sm">
                            11:00 AM - 12:30 PM
                        </div>
                    </div>
                    <div class="mt-2 text-sm">
                        <p>Dr. Katherine Johnson</p>
                        <p>Room 401</p>
                    </div>
                </div>
                <div class="p-3 rounded-lg bg-yellow-100 text-yellow-800 border-yellow-200">
                    <div class="flex justify-between items-start">
                        <div>
                            <h4 class="font-medium">Physics Lab</h4>
                            <p class="text-sm">PHYS 102</p>
                        </div>
                        <div class="text-sm">
                            3:00 PM - 5:00 PM
                        </div>
                    </div>
                    <div class="mt-2 text-sm">
                        <p>Dr. Richard Feynman</p>
                        <p>Lab 305</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Friday -->
        <div class="bg-white rounded-lg shadow-sm border p-5">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Friday</h3>
            <div class="space-y-3">
                <div class="p-3 rounded-lg bg-purple-100 text-purple-800 border-purple-200">
                    <div class="flex justify-between items-start">
                        <div>
                            <h4 class="font-medium">Data Structures</h4>
                            <p class="text-sm">CS 201</p>
                        </div>
                        <div class="text-sm">
                            10:00 AM - 11:30 AM
                        </div>
                    </div>
                    <div class="mt-2 text-sm">
                        <p>Dr. Ada Lovelace</p>
                        <p>Room 305</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleView(view) {
        if (view === 'week') {
            document.getElementById('week-view').classList.remove('hidden');
            document.getElementById('list-view').classList.add('hidden');
            document.getElementById('week-view-btn').classList.add('bg-primary-100', 'text-primary-800');
            document.getElementById('week-view-btn').classList.remove('bg-gray-100', 'text-gray-600');
            document.getElementById('list-view-btn').classList.remove('bg-primary-100', 'text-primary-800');
            document.getElementById('list-view-btn').classList.add('bg-gray-100', 'text-gray-600');
        } else {
            document.getElementById('week-view').classList.add('hidden');
            document.getElementById('list-view').classList.remove('hidden');
            document.getElementById('week-view-btn').classList.remove('bg-primary-100', 'text-primary-800');
            document.getElementById('week-view-btn').classList.add('bg-gray-100', 'text-gray-600');
            document.getElementById('list-view-btn').classList.add('bg-primary-100', 'text-primary-800');
            document.getElementById('list-view-btn').classList.remove('bg-gray-100', 'text-gray-600');
        }
    }
</script>
@endsection 
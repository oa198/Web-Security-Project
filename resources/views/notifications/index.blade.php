@extends('layouts.app')

@section('title', 'Notifications - Admissions Portal')

@section('page_title', 'Notifications')

@section('content')
<div class="space-y-6">
    <div class="bg-white shadow overflow-hidden sm:rounded-md">
        <ul class="divide-y divide-gray-200">
            @forelse(auth()->user()->notifications as $notification)
                <li class="px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ $notification->data['course_name'] }}</p>
                            <p class="text-sm text-gray-500">Student: {{ $notification->data['student_name'] }}</p>
                        </div>
                        <div class="text-sm text-gray-500">
                            {{ $notification->created_at->diffForHumans() }}
                        </div>
                    </div>
                </li>
            @empty
                <li class="px-6 py-4 text-center text-gray-500">
                    No notifications found.
                </li>
            @endforelse
        </ul>
    </div>
</div>
@endsection 
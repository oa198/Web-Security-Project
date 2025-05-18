@extends('layouts.main')

@section('title', 'Exam Preparation - Student Portal')

@section('page-title', 'Exam Preparation')

@section('content')
<div class="mb-6">
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">{{ $exam['title'] ?? 'Midterm Examination' }}</h2>
            <p class="text-gray-600 mt-1">{{ $exam['course_name'] ?? 'Database Systems' }} ({{ $exam['course_code'] ?? 'CS3200' }})</p>
        </div>
        
        <div class="flex items-center">
            <div class="text-right mr-4">
                <p class="text-sm text-gray-500">Time Remaining</p>
                <p class="text-lg font-semibold text-gray-800" id="countdown">
                    @php
                        $examDate = $exam['date'] ?? '2023-06-15';
                        $examTime = $exam['time'] ?? '10:00:00';
                        $datetime = $examDate . ' ' . $examTime;
                        $timestamp = strtotime($datetime) - time();
                        $days = floor($timestamp / (60 * 60 * 24));
                        $hours = floor(($timestamp % (60 * 60 * 24)) / (60 * 60));
                        $minutes = floor(($timestamp % (60 * 60)) / 60);
                    @endphp
                    {{ $days }}d {{ $hours }}h {{ $minutes }}m
                </p>
            </div>
            <a href="{{ route('exams.show', $exam['id'] ?? 1) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                Back to Details
            </a>
        </div>
    </div>
</div>

<!-- Study Progress -->
<div class="bg-white rounded-lg shadow-sm border p-5 mb-6">
    <h3 class="text-lg font-semibold text-gray-900 mb-4">Study Progress</h3>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <div class="flex justify-between items-center mb-2">
                <span class="text-sm font-medium text-gray-700">Overall Progress</span>
                <span class="text-sm font-medium text-gray-700">{{ $progress['overall'] ?? '65' }}%</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2.5">
                <div class="bg-primary-600 h-2.5 rounded-full" style="width: {{ $progress['overall'] ?? '65' }}%"></div>
            </div>
            
            <div class="mt-4 grid grid-cols-1 gap-3">
                @foreach($progress['topics'] ?? [
                    ['name' => 'Database Design', 'percent' => 80],
                    ['name' => 'Normalization', 'percent' => 75],
                    ['name' => 'SQL Queries', 'percent' => 60],
                    ['name' => 'Transaction Management', 'percent' => 45],
                    ['name' => 'Indexing', 'percent' => 70],
                    ['name' => 'Query Optimization', 'percent' => 50]
                ] as $topic)
                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <span class="text-xs font-medium text-gray-700">{{ $topic['name'] }}</span>
                            <span class="text-xs font-medium text-gray-700">{{ $topic['percent'] }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-1.5">
                            <div class="bg-primary-600 h-1.5 rounded-full" style="width: {{ $topic['percent'] }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        
        <div>
            <h4 class="text-sm font-medium text-gray-700 mb-2">Study Time</h4>
            <div class="flex items-end">
                <div class="text-3xl font-bold text-gray-900">{{ $progress['hours'] ?? '12' }}</div>
                <div class="text-lg text-gray-700 ml-1 mb-0.5">hours</div>
            </div>
            <p class="text-sm text-gray-500 mb-4">Tracked over {{ $progress['days'] ?? '7' }} days</p>
            
            <div class="flex space-x-2 mb-2">
                @foreach($progress['daily'] ?? [2, 1.5, 3, 2.5, 1, 0, 2] as $index => $hours)
                    <div class="flex flex-col items-center">
                        <div class="w-8 bg-primary-100 rounded-t-md" style="height: {{ $hours * 15 }}px;">
                            <div class="w-full bg-primary-500 rounded-t-md" style="height: {{ $hours * 10 }}px;"></div>
                        </div>
                        <div class="text-xs text-gray-500 mt-1">{{ ['M', 'T', 'W', 'T', 'F', 'S', 'S'][$index] }}</div>
                    </div>
                @endforeach
            </div>
            
            <button type="button" class="mt-4 inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Start Study Session
            </button>
        </div>
    </div>
</div>

<!-- Study Plan -->
<div class="bg-white rounded-lg shadow-sm border overflow-hidden mb-6">
    <div class="px-6 py-4 border-b flex justify-between items-center">
        <h3 class="text-lg font-semibold text-gray-900">Study Plan</h3>
        <button type="button" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            Add Task
        </button>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Task
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Topic
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Priority
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Due Date
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Status
                    </th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($studyPlan ?? [
                    ['id' => 1, 'task' => 'Review lecture notes on database design', 'topic' => 'Database Design', 'priority' => 'High', 'due_date' => '2023-06-10', 'status' => 'Completed'],
                    ['id' => 2, 'task' => 'Practice normalization exercises', 'topic' => 'Normalization', 'priority' => 'High', 'due_date' => '2023-06-11', 'status' => 'Completed'],
                    ['id' => 3, 'task' => 'Complete SQL query practice problems', 'topic' => 'SQL Queries', 'priority' => 'Medium', 'due_date' => '2023-06-12', 'status' => 'In Progress'],
                    ['id' => 4, 'task' => 'Review transaction management concepts', 'topic' => 'Transaction Management', 'priority' => 'Medium', 'due_date' => '2023-06-13', 'status' => 'Not Started'],
                    ['id' => 5, 'task' => 'Study indexing techniques', 'topic' => 'Indexing', 'priority' => 'Low', 'due_date' => '2023-06-14', 'status' => 'Not Started']
                ] as $task)
                    <tr>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <input type="checkbox" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded" {{ $task['status'] === 'Completed' ? 'checked' : '' }}>
                                <span class="ml-3 text-sm {{ $task['status'] === 'Completed' ? 'line-through text-gray-400' : 'text-gray-900' }}">
                                    {{ $task['task'] }}
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary-100 text-primary-800">
                                {{ $task['topic'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($task['priority'] === 'High')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    High
                                </span>
                            @elseif($task['priority'] === 'Medium')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                                    Medium
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    Low
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ \Carbon\Carbon::parse($task['due_date'])->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($task['status'] === 'Completed')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Completed
                                </span>
                            @elseif($task['status'] === 'In Progress')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    In Progress
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    Not Started
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="#" class="text-primary-600 hover:text-primary-900 mr-3">Edit</a>
                            <a href="#" class="text-red-600 hover:text-red-900">Delete</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Practice Quizzes -->
<div class="bg-white rounded-lg shadow-sm border overflow-hidden mb-6">
    <div class="px-6 py-4 border-b">
        <h3 class="text-lg font-semibold text-gray-900">Practice Quizzes</h3>
    </div>
    
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($quizzes ?? [
                ['id' => 1, 'title' => 'Database Design Quiz', 'questions' => 10, 'time' => 15, 'attempts' => 2, 'best_score' => '8/10'],
                ['id' => 2, 'title' => 'Normalization Quiz', 'questions' => 8, 'time' => 12, 'attempts' => 1, 'best_score' => '7/8'],
                ['id' => 3, 'title' => 'SQL Queries Quiz', 'questions' => 12, 'time' => 20, 'attempts' => 0, 'best_score' => null],
                ['id' => 4, 'title' => 'Transaction Management Quiz', 'questions' => 10, 'time' => 15, 'attempts' => 0, 'best_score' => null],
                ['id' => 5, 'title' => 'Indexing Quiz', 'questions' => 8, 'time' => 10, 'attempts' => 0, 'best_score' => null],
                ['id' => 6, 'title' => 'Query Optimization Quiz', 'questions' => 10, 'time' => 15, 'attempts' => 0, 'best_score' => null]
            ] as $quiz)
                <div class="border rounded-lg overflow-hidden">
                    <div class="px-4 py-3 bg-gray-50 border-b">
                        <h4 class="font-medium text-gray-900">{{ $quiz['title'] }}</h4>
                    </div>
                    <div class="p-4">
                        <div class="flex justify-between mb-3">
                            <div class="text-sm text-gray-500">Questions: {{ $quiz['questions'] }}</div>
                            <div class="text-sm text-gray-500">Time: {{ $quiz['time'] }} min</div>
                        </div>
                        
                        <div class="flex justify-between mb-4">
                            <div class="text-sm text-gray-500">Attempts: {{ $quiz['attempts'] }}</div>
                            @if($quiz['best_score'])
                                <div class="text-sm text-gray-900 font-medium">Best Score: {{ $quiz['best_score'] }}</div>
                            @else
                                <div class="text-sm text-gray-500">Not attempted</div>
                            @endif
                        </div>
                        
                        <a href="{{ route('exams.quiz', $quiz['id']) }}" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                            {{ $quiz['attempts'] > 0 ? 'Retake Quiz' : 'Start Quiz' }}
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Flashcards -->
<div class="bg-white rounded-lg shadow-sm border overflow-hidden">
    <div class="px-6 py-4 border-b flex justify-between items-center">
        <h3 class="text-lg font-semibold text-gray-900">Flashcards</h3>
        <div>
            <select class="text-sm border-gray-300 rounded-md">
                <option>All Topics</option>
                <option>Database Design</option>
                <option>Normalization</option>
                <option>SQL Queries</option>
                <option>Transaction Management</option>
                <option>Indexing</option>
                <option>Query Optimization</option>
            </select>
        </div>
    </div>
    
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($flashcards ?? [
                ['id' => 1, 'front' => 'What is a primary key?', 'back' => 'A column or set of columns that uniquely identifies each row in a table.'],
                ['id' => 2, 'front' => 'What is normalization?', 'back' => 'The process of organizing data to minimize redundancy and dependency by dividing large tables into smaller ones and defining relationships between them.'],
                ['id' => 3, 'front' => 'What is a foreign key?', 'back' => 'A column or set of columns that creates a link between data in two tables.'],
                ['id' => 4, 'front' => 'What is ACID in database transactions?', 'back' => 'ACID stands for Atomicity, Consistency, Isolation, and Durability, which are properties that guarantee reliable processing of database transactions.'],
                ['id' => 5, 'front' => 'What is an index in a database?', 'back' => 'A data structure that improves the speed of data retrieval operations on a database table.'],
                ['id' => 6, 'front' => 'What is a JOIN in SQL?', 'back' => 'A SQL operation that combines rows from two or more tables based on a related column between them.']
            ] as $index => $card)
                <div class="flashcard-container h-48">
                    <div class="flashcard w-full h-full relative" id="flashcard-{{ $index }}">
                        <div class="flashcard-front absolute w-full h-full bg-white border rounded-lg p-4 flex items-center justify-center cursor-pointer">
                            <p class="text-center text-gray-900">{{ $card['front'] }}</p>
                        </div>
                        <div class="flashcard-back absolute w-full h-full bg-primary-50 border rounded-lg p-4 flex items-center justify-center cursor-pointer" style="transform: rotateY(180deg); backface-visibility: hidden;">
                            <p class="text-center text-gray-900">{{ $card['back'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="mt-6 text-center">
            <button type="button" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                Load More Flashcards
            </button>
        </div>
    </div>
</div>

<style>
    .flashcard-container {
        perspective: 1000px;
    }
    
    .flashcard {
        transition: transform 0.6s;
        transform-style: preserve-3d;
    }
    
    .flashcard-front, .flashcard-back {
        backface-visibility: hidden;
    }
    
    .flashcard-back {
        transform: rotateY(180deg);
    }
    
    .flashcard.flipped {
        transform: rotateY(180deg);
    }
</style>

<script>
    // Simple countdown timer
    function updateCountdown() {
        const examDate = '{{ $exam['date'] ?? '2023-06-15' }}';
        const examTime = '{{ $exam['time'] ?? '10:00:00' }}';
        const examDateTime = new Date(`${examDate}T${examTime}`);
        const now = new Date();
        
        const diff = examDateTime - now;
        
        if (diff <= 0) {
            document.getElementById('countdown').textContent = 'Exam in progress';
            return;
        }
        
        const days = Math.floor(diff / (1000 * 60 * 60 * 24));
        const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
        
        document.getElementById('countdown').textContent = `${days}d ${hours}h ${minutes}m`;
    }
    
    // Update countdown every minute
    updateCountdown();
    setInterval(updateCountdown, 60000);
    
    // Flashcard flip functionality
    document.addEventListener('DOMContentLoaded', function() {
        const flashcards = document.querySelectorAll('.flashcard');
        flashcards.forEach(card => {
            card.addEventListener('click', function() {
                this.classList.toggle('flipped');
            });
        });
    });
</script>
@endsection 
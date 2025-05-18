@extends('layouts.main')

@section('title', 'Grades - Student Portal')

@section('page-title', 'Grades')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-900">My Academic Performance</h2>
    <p class="text-gray-600 mt-1">
        Track your grades and progress across all courses.
    </p>
</div>

<!-- Term Selector and Stats -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <div class="lg:col-span-1">
        <div class="bg-white p-5 rounded-lg shadow-sm border">
            <h3 class="font-semibold text-gray-900 mb-4">Select Term</h3>
            <div class="space-y-3">
                <label class="flex items-center space-x-3">
                    <input type="radio" name="term" class="h-4 w-4 text-primary-600 border-gray-300 focus:ring-primary-500" checked>
                    <span class="text-sm text-gray-700">Spring 2023 (Current)</span>
                </label>
                <label class="flex items-center space-x-3">
                    <input type="radio" name="term" class="h-4 w-4 text-primary-600 border-gray-300 focus:ring-primary-500">
                    <span class="text-sm text-gray-700">Fall 2022</span>
                </label>
                <label class="flex items-center space-x-3">
                    <input type="radio" name="term" class="h-4 w-4 text-primary-600 border-gray-300 focus:ring-primary-500">
                    <span class="text-sm text-gray-700">Spring 2022</span>
                </label>
                <label class="flex items-center space-x-3">
                    <input type="radio" name="term" class="h-4 w-4 text-primary-600 border-gray-300 focus:ring-primary-500">
                    <span class="text-sm text-gray-700">Fall 2021</span>
                </label>
            </div>
            
            <hr class="my-4 border-gray-200">
            
            <h3 class="font-semibold text-gray-900 mb-4">Term Statistics</h3>
            <div class="space-y-4">
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-gray-600">GPA</span>
                        <span class="font-medium text-gray-900">3.85</span>
                    </div>
                    <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                        <div class="h-full bg-green-500 rounded-full" style="width: 95%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-gray-600">Credits</span>
                        <span class="font-medium text-gray-900">16/18</span>
                    </div>
                    <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                        <div class="h-full bg-blue-500 rounded-full" style="width: 88%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-gray-600">Completion</span>
                        <span class="font-medium text-gray-900">90%</span>
                    </div>
                    <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                        <div class="h-full bg-amber-500 rounded-full" style="width: 90%"></div>
                    </div>
                </div>
            </div>
            
            <hr class="my-4 border-gray-200">
            
            <h3 class="font-semibold text-gray-900 mb-4">Cumulative</h3>
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-gray-50 p-3 rounded-lg">
                    <p class="text-xs text-gray-500">Cumulative GPA</p>
                    <p class="text-xl font-semibold text-gray-900">3.78</p>
                </div>
                <div class="bg-gray-50 p-3 rounded-lg">
                    <p class="text-xs text-gray-500">Total Credits</p>
                    <p class="text-xl font-semibold text-gray-900">86</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="lg:col-span-2">
        <div class="bg-white p-5 rounded-lg shadow-sm border h-full">
            <h3 class="font-semibold text-gray-900 mb-4">Grade Distribution</h3>
            <div class="relative h-64 mb-4">
                <!-- This is a placeholder for a chart. In a real application, you'd use a chart library. -->
                <div class="flex items-end justify-between h-full px-2">
                    <div class="w-1/6 flex flex-col items-center">
                        <div class="w-full bg-green-500 rounded-t-md" style="height: 60%"></div>
                        <span class="text-xs mt-1 text-gray-600">A</span>
                    </div>
                    <div class="w-1/6 flex flex-col items-center">
                        <div class="w-full bg-green-400 rounded-t-md" style="height: 20%"></div>
                        <span class="text-xs mt-1 text-gray-600">B+</span>
                    </div>
                    <div class="w-1/6 flex flex-col items-center">
                        <div class="w-full bg-green-300 rounded-t-md" style="height: 10%"></div>
                        <span class="text-xs mt-1 text-gray-600">B</span>
                    </div>
                    <div class="w-1/6 flex flex-col items-center">
                        <div class="w-full bg-amber-300 rounded-t-md" style="height: 5%"></div>
                        <span class="text-xs mt-1 text-gray-600">C+</span>
                    </div>
                    <div class="w-1/6 flex flex-col items-center">
                        <div class="w-full bg-amber-400 rounded-t-md" style="height: 5%"></div>
                        <span class="text-xs mt-1 text-gray-600">C</span>
                    </div>
                    <div class="w-1/6 flex flex-col items-center">
                        <div class="w-full bg-gray-300 rounded-t-md" style="height: 0%"></div>
                        <span class="text-xs mt-1 text-gray-600">D/F</span>
                    </div>
                </div>
                <!-- Y-axis labels -->
                <div class="absolute top-0 left-0 h-full flex flex-col justify-between text-xs text-gray-500 py-2">
                    <span>100%</span>
                    <span>75%</span>
                    <span>50%</span>
                    <span>25%</span>
                    <span>0%</span>
                </div>
            </div>
            
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 mb-4">
                <div class="bg-gray-50 p-3 rounded-lg">
                    <p class="text-xs text-gray-500">A Range</p>
                    <p class="text-xl font-semibold text-gray-900">60%</p>
                </div>
                <div class="bg-gray-50 p-3 rounded-lg">
                    <p class="text-xs text-gray-500">B Range</p>
                    <p class="text-xl font-semibold text-gray-900">30%</p>
                </div>
                <div class="bg-gray-50 p-3 rounded-lg">
                    <p class="text-xs text-gray-500">C Range</p>
                    <p class="text-xl font-semibold text-gray-900">10%</p>
                </div>
            </div>
            
            <p class="text-sm text-gray-600">
                Your grade distribution shows strong performance, with 60% of your grades in the A range. This is above the class average of 45%.
            </p>
        </div>
    </div>
</div>

<!-- Current Courses and Grades -->
<div class="bg-white rounded-lg shadow-sm border p-5 mb-6">
    <h3 class="font-semibold text-gray-900 mb-4">Current Semester Grades</h3>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead>
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Course</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Code</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Instructor</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Credits</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Current Grade</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Progress</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <tr>
                    <td class="px-4 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-8 w-8 rounded bg-blue-100 flex items-center justify-center">
                                <span class="text-blue-600 font-medium">DB</span>
                            </div>
                            <div class="ml-3">
                                <div class="text-sm font-medium text-gray-900">Database Systems</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">CS 340</td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">Prof. Johnson</td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">4</td>
                    <td class="px-4 py-3 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">A (95%)</span>
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-blue-600 h-2 rounded-full" style="width: 80%"></div>
                        </div>
                        <span class="text-xs text-gray-500">80% Complete</span>
                    </td>
                </tr>
                <tr>
                    <td class="px-4 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-8 w-8 rounded bg-indigo-100 flex items-center justify-center">
                                <span class="text-indigo-600 font-medium">WD</span>
                            </div>
                            <div class="ml-3">
                                <div class="text-sm font-medium text-gray-900">Web Development</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">CS 290</td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">Prof. Smith</td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">3</td>
                    <td class="px-4 py-3 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">A- (91%)</span>
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-blue-600 h-2 rounded-full" style="width: 85%"></div>
                        </div>
                        <span class="text-xs text-gray-500">85% Complete</span>
                    </td>
                </tr>
                <tr>
                    <td class="px-4 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-8 w-8 rounded bg-purple-100 flex items-center justify-center">
                                <span class="text-purple-600 font-medium">CN</span>
                            </div>
                            <div class="ml-3">
                                <div class="text-sm font-medium text-gray-900">Computer Networks</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">CS 372</td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">Prof. Williams</td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">3</td>
                    <td class="px-4 py-3 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">B+ (88%)</span>
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-blue-600 h-2 rounded-full" style="width: 90%"></div>
                        </div>
                        <span class="text-xs text-gray-500">90% Complete</span>
                    </td>
                </tr>
                <tr>
                    <td class="px-4 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-8 w-8 rounded bg-green-100 flex items-center justify-center">
                                <span class="text-green-600 font-medium">SE</span>
                            </div>
                            <div class="ml-3">
                                <div class="text-sm font-medium text-gray-900">Software Engineering</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">CS 361</td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">Prof. Davis</td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">4</td>
                    <td class="px-4 py-3 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">A (93%)</span>
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-blue-600 h-2 rounded-full" style="width: 75%"></div>
                        </div>
                        <span class="text-xs text-gray-500">75% Complete</span>
                    </td>
                </tr>
                <tr>
                    <td class="px-4 py-3 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-8 w-8 rounded bg-pink-100 flex items-center justify-center">
                                <span class="text-pink-600 font-medium">DS</span>
                            </div>
                            <div class="ml-3">
                                <div class="text-sm font-medium text-gray-900">Data Science</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">CS 434</td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">Prof. Miller</td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">3</td>
                    <td class="px-4 py-3 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-amber-100 text-amber-800">B (85%)</span>
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-blue-600 h-2 rounded-full" style="width: 70%"></div>
                        </div>
                        <span class="text-xs text-gray-500">70% Complete</span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Grade History -->
<div class="bg-white rounded-lg shadow-sm border p-5 mb-6">
    <div class="flex justify-between items-center mb-4">
        <h3 class="font-semibold text-gray-900">Grade History</h3>
        <button class="text-primary-600 hover:text-primary-700 text-sm font-medium">View Full Transcript</button>
    </div>
    <div class="relative">
        <!-- This is a placeholder for a chart. In a real application, you'd use a chart library. -->
        <div class="h-64 flex items-end space-x-2">
            <div class="flex-1 flex flex-col items-center">
                <div class="w-full bg-gray-200 rounded-t-md relative" style="height: 100%">
                    <div class="absolute bottom-0 w-full bg-blue-500 rounded-t-md" style="height: 75%"></div>
                </div>
                <span class="text-xs mt-1 text-gray-600">Fall '21</span>
            </div>
            <div class="flex-1 flex flex-col items-center">
                <div class="w-full bg-gray-200 rounded-t-md relative" style="height: 100%">
                    <div class="absolute bottom-0 w-full bg-blue-500 rounded-t-md" style="height: 80%"></div>
                </div>
                <span class="text-xs mt-1 text-gray-600">Spring '22</span>
            </div>
            <div class="flex-1 flex flex-col items-center">
                <div class="w-full bg-gray-200 rounded-t-md relative" style="height: 100%">
                    <div class="absolute bottom-0 w-full bg-blue-500 rounded-t-md" style="height: 85%"></div>
                </div>
                <span class="text-xs mt-1 text-gray-600">Fall '22</span>
            </div>
            <div class="flex-1 flex flex-col items-center">
                <div class="w-full bg-gray-200 rounded-t-md relative" style="height: 100%">
                    <div class="absolute bottom-0 w-full bg-blue-600 rounded-t-md" style="height: 90%"></div>
                </div>
                <span class="text-xs mt-1 text-gray-600">Spring '23</span>
            </div>
        </div>
        <!-- Y-axis labels -->
        <div class="absolute top-0 left-0 h-64 flex flex-col justify-between text-xs text-gray-500 py-2">
            <span>4.0</span>
            <span>3.0</span>
            <span>2.0</span>
            <span>1.0</span>
            <span>0.0</span>
        </div>
    </div>
    
    <div class="mt-4">
        <p class="text-sm text-gray-600">
            Your GPA has been steadily improving over the past terms, with a current term GPA of 3.85, your highest yet. 
            You've shown consistent improvement in all subject areas.
        </p>
    </div>
</div>

<!-- Academic Advisor Notes -->
<div class="bg-white rounded-lg shadow-sm border p-5">
    <h3 class="font-semibold text-gray-900 mb-4">Academic Advisor Notes</h3>
    <div class="bg-blue-50 border border-blue-200 rounded-md p-4 mb-4">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-blue-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <h4 class="text-sm font-medium text-blue-800">Spring 2023 Academic Review</h4>
                <div class="mt-2 text-sm text-blue-700">
                    <p>
                        Excellent progress this term! You're on track for graduating with honors. Your strong performance in Database Systems 
                        and Software Engineering is particularly noteworthy. Consider taking CS 450 (Operating Systems) next term to build on your skills.
                    </p>
                </div>
                <div class="mt-2">
                    <span class="text-xs text-blue-600">Dr. Thompson • May 12, 2023</span>
                </div>
            </div>
        </div>
    </div>
    
    <div class="border-t border-gray-200 pt-4">
        <h4 class="text-sm font-medium text-gray-900 mb-2">Schedule an Advisor Meeting</h4>
        <p class="text-sm text-gray-600 mb-3">
            Discuss your academic progress and future course selections with your advisor.
        </p>
        <button class="inline-flex items-center px-4 py-2 border border-primary-300 text-sm font-medium rounded-md text-primary-700 bg-white hover:bg-primary-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
            <svg class="mr-2 -ml-1 h-5 w-5 text-primary-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            Schedule Meeting
        </button>
    </div>
</div>
@endsection 
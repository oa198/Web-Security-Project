@extends('layouts.main')

@section('title', 'Grades - Student Portal')

@section('page-title', 'Grades')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-900">My Grades</h2>
    <p class="text-gray-600 mt-1">
        View your academic performance across all courses.
    </p>
</div>

<!-- Overall Stats -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-lg p-5 shadow-sm border">
        <h3 class="text-sm font-medium text-gray-500">Overall GPA</h3>
        <div class="mt-2 flex items-baseline">
            <p class="text-3xl font-bold text-gray-900">3.8</p>
            <p class="ml-2 text-sm text-green-600 font-medium">+0.2</p>
        </div>
        <p class="mt-1 text-xs text-gray-500">From previous semester</p>
    </div>
    
    <div class="bg-white rounded-lg p-5 shadow-sm border">
        <h3 class="text-sm font-medium text-gray-500">Total Credits</h3>
        <div class="mt-2 flex items-baseline">
            <p class="text-3xl font-bold text-gray-900">72</p>
            <p class="ml-2 text-sm text-green-600 font-medium">+18</p>
        </div>
        <p class="mt-1 text-xs text-gray-500">Current semester</p>
    </div>
    
    <div class="bg-white rounded-lg p-5 shadow-sm border">
        <h3 class="text-sm font-medium text-gray-500">Credits Remaining</h3>
        <div class="mt-2 flex items-baseline">
            <p class="text-3xl font-bold text-gray-900">48</p>
            <p class="ml-2 text-sm text-gray-600 font-medium">to graduate</p>
        </div>
        <p class="mt-1 text-xs text-gray-500">For degree completion</p>
    </div>
</div>

<!-- Grade Distribution -->
<div class="bg-white rounded-lg shadow-sm border p-5 mb-6">
    <h3 class="text-lg font-semibold text-gray-900 mb-4">Grade Distribution</h3>
    <div class="grid grid-cols-5 gap-2">
        <div class="flex flex-col items-center">
            <div class="h-32 w-full bg-gray-100 rounded-t-lg relative">
                <div class="absolute bottom-0 w-full bg-green-500 rounded-t-lg" style="height: 75%"></div>
            </div>
            <div class="mt-2 text-sm font-medium text-gray-700">A</div>
            <div class="text-xs text-gray-500">9 courses</div>
        </div>
        <div class="flex flex-col items-center">
            <div class="h-32 w-full bg-gray-100 rounded-t-lg relative">
                <div class="absolute bottom-0 w-full bg-green-400 rounded-t-lg" style="height: 60%"></div>
            </div>
            <div class="mt-2 text-sm font-medium text-gray-700">B</div>
            <div class="text-xs text-gray-500">6 courses</div>
        </div>
        <div class="flex flex-col items-center">
            <div class="h-32 w-full bg-gray-100 rounded-t-lg relative">
                <div class="absolute bottom-0 w-full bg-yellow-400 rounded-t-lg" style="height: 35%"></div>
            </div>
            <div class="mt-2 text-sm font-medium text-gray-700">C</div>
            <div class="text-xs text-gray-500">4 courses</div>
        </div>
        <div class="flex flex-col items-center">
            <div class="h-32 w-full bg-gray-100 rounded-t-lg relative">
                <div class="absolute bottom-0 w-full bg-orange-400 rounded-t-lg" style="height: 15%"></div>
            </div>
            <div class="mt-2 text-sm font-medium text-gray-700">D</div>
            <div class="text-xs text-gray-500">2 courses</div>
        </div>
        <div class="flex flex-col items-center">
            <div class="h-32 w-full bg-gray-100 rounded-t-lg relative">
                <div class="absolute bottom-0 w-full bg-red-500 rounded-t-lg" style="height: 5%"></div>
            </div>
            <div class="mt-2 text-sm font-medium text-gray-700">F</div>
            <div class="text-xs text-gray-500">1 course</div>
        </div>
    </div>
</div>

<!-- Current Semester Grades -->
<div class="bg-white rounded-lg shadow-sm border p-5 mb-6">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold text-gray-900">Current Semester</h3>
        <div>
            <select class="text-sm border-gray-200 rounded-md">
                <option>Spring 2023</option>
                <option>Fall 2022</option>
                <option>Spring 2022</option>
            </select>
        </div>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Course</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Code</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Credits</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Grade</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">Database Systems</div>
                        <div class="text-xs text-gray-500">Prof. Johnson</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">CS 3200</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">4</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-green-600">A (92.4%)</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Completed</span>
                    </td>
                </tr>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">Web Development</div>
                        <div class="text-xs text-gray-500">Prof. Smith</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">CS 4550</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">3</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-green-600">B+ (87.2%)</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Completed</span>
                    </td>
                </tr>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">Computer Networks</div>
                        <div class="text-xs text-gray-500">Prof. Williams</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">CS 3700</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">4</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-yellow-600">C (74.8%)</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Completed</span>
                    </td>
                </tr>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">Software Engineering</div>
                        <div class="text-xs text-gray-500">Prof. Davis</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">CS 4500</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">4</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-400">--</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">In Progress</span>
                    </td>
                </tr>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">Data Science</div>
                        <div class="text-xs text-gray-500">Prof. Miller</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">DS 3000</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">3</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-400">--</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">In Progress</span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- GPA Trend -->
<div class="bg-white rounded-lg shadow-sm border p-5">
    <h3 class="text-lg font-semibold text-gray-900 mb-4">GPA Trend</h3>
    <div class="h-64 w-full">
        <div class="flex items-end h-48 w-full justify-between px-4">
            <div class="w-1/5 flex flex-col items-center">
                <div class="h-24 w-12 bg-primary-500 rounded-t-lg"></div>
                <div class="mt-2 text-xs text-gray-500">Fall 2021</div>
                <div class="text-sm font-medium text-gray-700">3.4</div>
            </div>
            <div class="w-1/5 flex flex-col items-center">
                <div class="h-28 w-12 bg-primary-500 rounded-t-lg"></div>
                <div class="mt-2 text-xs text-gray-500">Spring 2022</div>
                <div class="text-sm font-medium text-gray-700">3.5</div>
            </div>
            <div class="w-1/5 flex flex-col items-center">
                <div class="h-32 w-12 bg-primary-500 rounded-t-lg"></div>
                <div class="mt-2 text-xs text-gray-500">Fall 2022</div>
                <div class="text-sm font-medium text-gray-700">3.6</div>
            </div>
            <div class="w-1/5 flex flex-col items-center">
                <div class="h-36 w-12 bg-primary-500 rounded-t-lg"></div>
                <div class="mt-2 text-xs text-gray-500">Spring 2023</div>
                <div class="text-sm font-medium text-gray-700">3.8</div>
            </div>
            <div class="w-1/5 flex flex-col items-center">
                <div class="h-36 w-12 bg-gray-300 rounded-t-lg opacity-50"></div>
                <div class="mt-2 text-xs text-gray-500">Fall 2023</div>
                <div class="text-sm font-medium text-gray-400">--</div>
            </div>
        </div>
    </div>
</div>
@endsection 
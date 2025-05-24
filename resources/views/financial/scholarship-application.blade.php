@extends('layouts.app')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="flex mb-5" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
                        Home
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <a href="{{ route('financial.index') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2">Financial Records</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Scholarship Application</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Page Title -->
        <div class="mb-6">
            <h1 class="text-3xl font-semibold text-gray-900">Scholarship Application</h1>
            <p class="mt-2 text-sm text-gray-600">Submit an application for financial aid or scholarship</p>
        </div>

        <!-- Alert for Application Period -->
        <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-blue-700">
                        <span class="font-medium">Current Application Period:</span> {{ $applicationPeriod->start_date->format('M d, Y') }} to {{ $applicationPeriod->end_date->format('M d, Y') }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Available Scholarships Section -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
            <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
                <div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Available Scholarships
                    </h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">
                        Select a scholarship to apply for
                    </p>
                </div>
            </div>
            <div class="border-t border-gray-200">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Eligibility</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deadline</th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($availableScholarships as $scholarship)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $scholarship->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $scholarship->type == 'merit' ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800' }}">
                                        {{ ucfirst($scholarship->type) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    @if($scholarship->amount_type == 'fixed')
                                        ${{ number_format($scholarship->amount, 2) }}
                                    @else
                                        {{ $scholarship->amount }}% of tuition
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate">
                                    {{ $scholarship->eligibility_criteria }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $scholarship->deadline->format('M d, Y') }}
                                    @if($scholarship->deadline->isPast())
                                        <span class="ml-2 text-xs bg-red-100 text-red-800 px-2 py-0.5 rounded-full">Closed</span>
                                    @elseif($scholarship->deadline->diffInDays(now()) <= 7)
                                        <span class="ml-2 text-xs bg-yellow-100 text-yellow-800 px-2 py-0.5 rounded-full">Closing Soon</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    @if(!$scholarship->deadline->isPast() && !$userApplications->contains('scholarship_id', $scholarship->id))
                                        <button type="button" onclick="selectScholarship({{ $scholarship->id }}, '{{ $scholarship->name }}')" class="text-blue-600 hover:text-blue-900 bg-blue-50 hover:bg-blue-100 rounded-md px-3 py-1">
                                            Apply Now
                                        </button>
                                    @elseif($userApplications->contains('scholarship_id', $scholarship->id))
                                        <span class="text-gray-500 bg-gray-100 rounded-md px-3 py-1">
                                            Already Applied
                                        </span>
                                    @else
                                        <span class="text-gray-500 bg-gray-100 rounded-md px-3 py-1">
                                            Closed
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Application Form -->
        <div id="application-form" class="hidden bg-white shadow overflow-hidden sm:rounded-lg mb-6">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900" id="scholarship-form-title">
                    Scholarship Application Form
                </h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                    Please complete all required fields
                </p>
            </div>
            <div class="border-t border-gray-200 p-6">
                <form action="{{ route('financial.scholarship.apply') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="scholarship_id" id="scholarship_id" value="">

                    <!-- Personal Information -->
                    <div class="mb-6">
                        <h4 class="text-md font-medium text-gray-700 mb-4 pb-2 border-b">Personal Information</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                                <input type="text" name="name" id="name" value="{{ $student->user->name }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" readonly>
                            </div>
                            <div>
                                <label for="student_id" class="block text-sm font-medium text-gray-700">Student ID</label>
                                <input type="text" name="student_id" id="student_id" value="{{ $student->student_id }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" readonly>
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                                <input type="email" name="email" id="email" value="{{ $student->user->email }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" readonly>
                            </div>
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                                <input type="text" name="phone" id="phone" value="{{ $student->phone }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                            </div>
                        </div>
                    </div>

                    <!-- Academic Information -->
                    <div class="mb-6">
                        <h4 class="text-md font-medium text-gray-700 mb-4 pb-2 border-b">Academic Information</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="program" class="block text-sm font-medium text-gray-700">Program/Major</label>
                                <input type="text" name="program" id="program" value="{{ $student->program->name ?? '' }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                            </div>
                            <div>
                                <label for="year_level" class="block text-sm font-medium text-gray-700">Year Level</label>
                                <select name="year_level" id="year_level" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                    <option value="1" {{ $student->year_level == 1 ? 'selected' : '' }}>First Year</option>
                                    <option value="2" {{ $student->year_level == 2 ? 'selected' : '' }}>Second Year</option>
                                    <option value="3" {{ $student->year_level == 3 ? 'selected' : '' }}>Third Year</option>
                                    <option value="4" {{ $student->year_level == 4 ? 'selected' : '' }}>Fourth Year</option>
                                    <option value="5" {{ $student->year_level == 5 ? 'selected' : '' }}>Fifth Year</option>
                                    <option value="graduate" {{ $student->year_level == 'graduate' ? 'selected' : '' }}>Graduate</option>
                                </select>
                            </div>
                            <div>
                                <label for="gpa" class="block text-sm font-medium text-gray-700">Current GPA</label>
                                <input type="number" step="0.01" min="0" max="4.0" name="gpa" id="gpa" value="{{ $student->gpa ?? '' }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                            </div>
                            <div>
                                <label for="expected_graduation" class="block text-sm font-medium text-gray-700">Expected Graduation Date</label>
                                <input type="month" name="expected_graduation" id="expected_graduation" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                            </div>
                        </div>
                    </div>

                    <!-- Financial Information -->
                    <div class="mb-6">
                        <h4 class="text-md font-medium text-gray-700 mb-4 pb-2 border-b">Financial Information</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="financial_need" class="block text-sm font-medium text-gray-700">Do you have financial need?</label>
                                <select name="financial_need" id="financial_need" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                    <option value="yes">Yes</option>
                                    <option value="no">No</option>
                                </select>
                            </div>
                            <div>
                                <label for="other_scholarships" class="block text-sm font-medium text-gray-700">Are you receiving any other scholarships?</label>
                                <select name="other_scholarships" id="other_scholarships" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" onchange="toggleOtherScholarshipsDetails()">
                                    <option value="no">No</option>
                                    <option value="yes">Yes</option>
                                </select>
                            </div>
                            <div id="other_scholarships_details_container" class="hidden md:col-span-2">
                                <label for="other_scholarships_details" class="block text-sm font-medium text-gray-700">Please provide details of other scholarships</label>
                                <textarea name="other_scholarships_details" id="other_scholarships_details" rows="3" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></textarea>
                            </div>
                            <div class="md:col-span-2">
                                <label for="financial_statement" class="block text-sm font-medium text-gray-700">Brief Statement of Financial Need (if applicable)</label>
                                <textarea name="financial_statement" id="financial_statement" rows="4" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="Please explain your financial situation and why you need this scholarship..."></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Essay/Statement -->
                    <div class="mb-6">
                        <h4 class="text-md font-medium text-gray-700 mb-4 pb-2 border-b">Personal Statement</h4>
                        <div>
                            <label for="personal_statement" class="block text-sm font-medium text-gray-700">Why do you deserve this scholarship? (500-1000 words)</label>
                            <p class="text-xs text-gray-500 mb-2">Explain your academic achievements, career goals, and how this scholarship will help you achieve them.</p>
                            <textarea name="personal_statement" id="personal_statement" rows="8" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required></textarea>
                        </div>
                    </div>

                    <!-- Required Documents -->
                    <div class="mb-6">
                        <h4 class="text-md font-medium text-gray-700 mb-4 pb-2 border-b">Required Documents</h4>
                        <div class="space-y-4">
                            <div>
                                <label for="transcript" class="block text-sm font-medium text-gray-700">Official Transcript (PDF only)</label>
                                <input type="file" name="transcript" id="transcript" accept=".pdf" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" required>
                            </div>
                            <div>
                                <label for="recommendation_letter" class="block text-sm font-medium text-gray-700">Letter of Recommendation (PDF only)</label>
                                <input type="file" name="recommendation_letter" id="recommendation_letter" accept=".pdf" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" required>
                            </div>
                            <div>
                                <label for="financial_documents" class="block text-sm font-medium text-gray-700">Financial Documents (if applying for need-based scholarship)</label>
                                <input type="file" name="financial_documents" id="financial_documents" accept=".pdf" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            </div>
                        </div>
                    </div>

                    <!-- Terms and Conditions -->
                    <div class="mb-6">
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="terms" name="terms" type="checkbox" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded" required>
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="terms" class="font-medium text-gray-700">I certify that all information provided is accurate and complete</label>
                                <p class="text-gray-500">I understand that providing false information may result in the denial of my application and potential disciplinary action.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="hideApplicationForm()" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Cancel
                        </button>
                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Submit Application
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- My Applications -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    My Applications
                </h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                    Scholarship applications you have submitted
                </p>
            </div>
            <div class="border-t border-gray-200">
                @if(count($userApplications) > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Scholarship</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Applied On</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Award Amount</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($userApplications as $application)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $application->scholarship->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $application->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    @php
                                        $statusColors = [
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            'under_review' => 'bg-blue-100 text-blue-800',
                                            'approved' => 'bg-green-100 text-green-800',
                                            'rejected' => 'bg-red-100 text-red-800',
                                        ];
                                        $statusColor = $statusColors[$application->status] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColor }}">
                                        {{ ucwords(str_replace('_', ' ', $application->status)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    @if($application->status == 'approved' && $application->awarded_amount)
                                        ${{ number_format($application->awarded_amount, 2) }}
                                    @else
                                        --
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('financial.scholarship.view', $application->id) }}" class="text-blue-600 hover:text-blue-900">View Details</a>
                                    @if($application->status == 'pending')
                                        <a href="{{ route('financial.scholarship.withdraw', $application->id) }}" class="text-red-600 hover:text-red-900 ml-3" onclick="return confirm('Are you sure you want to withdraw this application?')">Withdraw</a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="px-6 py-4 text-sm text-gray-500 text-center">
                    <p>You haven't submitted any scholarship applications yet.</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Back Button -->
        <div class="mt-6">
            <a href="{{ route('financial.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Financial Records
            </a>
        </div>
    </div>
</div>

<!-- JavaScript for form interactions -->
<script>
    function selectScholarship(id, name) {
        document.getElementById('scholarship_id').value = id;
        document.getElementById('scholarship-form-title').innerText = 'Application for ' + name;
        document.getElementById('application-form').classList.remove('hidden');
        // Scroll to form
        document.getElementById('application-form').scrollIntoView({behavior: 'smooth'});
    }

    function hideApplicationForm() {
        document.getElementById('application-form').classList.add('hidden');
    }

    function toggleOtherScholarshipsDetails() {
        const otherScholarships = document.getElementById('other_scholarships').value;
        const detailsContainer = document.getElementById('other_scholarships_details_container');
        
        if (otherScholarships === 'yes') {
            detailsContainer.classList.remove('hidden');
        } else {
            detailsContainer.classList.add('hidden');
        }
    }
</script>
@endsection

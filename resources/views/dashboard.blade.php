@extends('layouts.app')

@section('title', 'Dashboard - Student Portal')

@section('page_title', 'Dashboard')

@section('content')
<div x-data="{ showCustomization: false, widgets: JSON.parse(localStorage.getItem('dashboard_widgets') || JSON.stringify([
    { id: 'courses', title: 'Course Overview', visible: true, order: 1 },
    { id: 'grades', title: 'Grade Distribution', visible: true, order: 2 },
    { id: 'schedule', title: 'Weekly Schedule', visible: true, order: 3 },
    { id: 'notifications', title: 'Recent Notifications', visible: true, order: 4 },
    { id: 'financial', title: 'Financial Summary', visible: true, order: 5 }
])) }" 
    x-init="$watch('widgets', value => localStorage.setItem('dashboard_widgets', JSON.stringify(value)))">
    
    <!-- Dashboard Header -->
    <div class="mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">
                    Welcome back, {{ explode(' ', auth()->user()->name)[0] }}!
                </h2>
                <p class="text-gray-600 mt-1">
                    Here's an overview of your academic performance and upcoming tasks.
                </p>
            </div>
            <button
                @click="showCustomization = !showCustomization"
                class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-purple-600 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                Customize Dashboard
            </button>
        </div>
    </div>
    
    <!-- Dashboard Customization -->
    <div x-show="showCustomization" x-transition class="mb-6 p-4 bg-white rounded-xl shadow-sm border border-purple-100">
        <h3 class="text-lg font-semibold mb-4">Dashboard Customization</h3>
        <p class="text-sm text-gray-600 mb-4">
            Drag and drop widgets to reorder them, or toggle their visibility using the checkboxes.
        </p>
        <div class="space-y-2">
            <template x-for="widget in widgets.sort((a, b) => a.order - b.order)" :key="widget.id">
                <div class="flex items-center gap-3 p-2 bg-gray-50 rounded-lg">
                    <input
                        type="checkbox"
                        x-model="widget.visible"
                        class="rounded border-gray-300 text-purple-600 focus:ring-purple-500"
                    >
                    <div class="cursor-move text-gray-400 hover:text-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5v-4m0 0h-4m4 0l-5-5" />
                        </svg>
                    </div>
                    <span class="text-sm font-medium" x-text="widget.title"></span>
                    <div class="flex items-center ml-auto space-x-2">
                        <button @click="
                            const index = widgets.findIndex(w => w.id === widget.id);
                            if (index > 0) {
                                const prevWidget = widgets[index - 1];
                                const currentOrder = widget.order;
                                widget.order = prevWidget.order;
                                prevWidget.order = currentOrder;
                            }
                        " class="text-gray-400 hover:text-gray-600 p-1" :class="{ 'opacity-50 cursor-not-allowed': widgets.indexOf(widget) === 0 }">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                            </svg>
                        </button>
                        <button @click="
                            const index = widgets.findIndex(w => w.id === widget.id);
                            if (index < widgets.length - 1) {
                                const nextWidget = widgets[index + 1];
                                const currentOrder = widget.order;
                                widget.order = nextWidget.order;
                                nextWidget.order = currentOrder;
                            }
                        " class="text-gray-400 hover:text-gray-600 p-1" :class="{ 'opacity-50 cursor-not-allowed': widgets.indexOf(widget) === widgets.length - 1 }">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                    </div>
                </div>
            </template>
        </div>
    </div>
    

    <!-- Widgets Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Course Overview Widget -->
            <template x-for="widget in widgets.filter(w => w.visible).sort((a, b) => a.order - b.order)" :key="widget.id">
                <div x-show="widget.visible" x-transition class="relative group">
                    <div class="absolute -left-4 top-1/2 -translate-y-1/2 p-2 cursor-grab opacity-0 group-hover:opacity-100 transition-opacity">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5v-4m0 0h-4m4 0l-5-5" />
                        </svg>
                    </div>
                    <div x-show="widget.id === 'courses'" x-transition>
                        @include('components.dashboard.course-overview')
                    </div>
                    <div x-show="widget.id === 'grades'" x-transition>
                        @include('components.dashboard.grade-distribution')
                    </div>
                    <div x-show="widget.id === 'notifications'" x-transition>
                        @include('components.dashboard.recent-notifications')
                    </div>
                    <div x-show="widget.id === 'schedule'" x-transition>
                        @include('components.dashboard.class-schedule')
                    </div>
                    <div x-show="widget.id === 'financial'" x-transition>
                        @include('components.dashboard.financial-summary')
                    </div>
                </div>
            </template>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>
<script>
    document.addEventListener('alpine:init', () => {
        // Initialize SortableJS for dashboard widgets when Alpine loads
        if (document.querySelector('.dashboard-widgets')) {
            new Sortable(document.querySelector('.dashboard-widgets'), {
                animation: 150,
                ghostClass: 'bg-purple-50',
                onEnd: function(evt) {
                    // Update widget order in Alpine.js store
                    const widgets = Alpine.store('dashboard').widgets;
                    const movedWidget = widgets[evt.oldIndex];
                    
                    // Remove the widget from its old position
                    widgets.splice(evt.oldIndex, 1);
                    
                    // Insert it at the new position
                    widgets.splice(evt.newIndex, 0, movedWidget);
                    
                    // Update order values
                    widgets.forEach((widget, index) => {
                        widget.order = index + 1;
                    });
                    
                    // Update the store
                    Alpine.store('dashboard').widgets = [...widgets];
                }
            });
        }
    });
</script>
@endsection
import React, { useState } from 'react';
import { DndContext, DragEndEvent, closestCenter } from '@dnd-kit/core';
import { SortableContext, arrayMove, verticalListSortingStrategy } from '@dnd-kit/sortable';
import PageLayout from '../components/layout/PageLayout';
import QuickStats from '../components/dashboard/QuickStats';
import UpcomingAssignments from '../components/dashboard/UpcomingAssignments';
import CourseOverview from '../components/dashboard/CourseOverview';
import GradeDistribution from '../components/dashboard/GradeDistribution';
import RecentNotifications from '../components/dashboard/RecentNotifications';
import ClassSchedule from '../components/dashboard/ClassSchedule';
import FinancialSummary from '../components/dashboard/FinancialSummary';
import { currentStudent } from '../data/mockData';
import { Settings } from 'lucide-react';
import DraggableWidget from '../components/dashboard/DraggableWidget';

interface Widget {
  id: string;
  title: string;
  visible: boolean;
  component: React.ReactNode;
}

const Dashboard: React.FC = () => {
  const [showCustomization, setShowCustomization] = useState(false);
  const [widgets, setWidgets] = useState<Widget[]>([
    { id: 'upcoming', title: 'Upcoming Assignments', visible: true, component: <UpcomingAssignments /> },
    { id: 'courses', title: 'Course Overview', visible: true, component: <CourseOverview /> },
    { id: 'grades', title: 'Grade Distribution', visible: true, component: <GradeDistribution /> },
    { id: 'notifications', title: 'Recent Notifications', visible: true, component: <RecentNotifications /> },
    { id: 'schedule', title: 'Class Schedule', visible: true, component: <ClassSchedule /> },
    { id: 'financial', title: 'Financial Summary', visible: true, component: <FinancialSummary /> },
  ]);

  const handleDragEnd = (event: DragEndEvent) => {
    const { active, over } = event;
    
    if (over && active.id !== over.id) {
      setWidgets((items) => {
        const oldIndex = items.findIndex((item) => item.id === active.id);
        const newIndex = items.findIndex((item) => item.id === over.id);
        return arrayMove(items, oldIndex, newIndex);
      });
    }
  };

  const toggleWidgetVisibility = (widgetId: string) => {
    setWidgets(widgets.map(widget => 
      widget.id === widgetId 
        ? { ...widget, visible: !widget.visible }
        : widget
    ));
  };

  return (
    <PageLayout title="Dashboard">
      <div className="mb-6">
        <div className="flex justify-between items-center">
          <div>
            <h2 className="text-2xl font-bold text-gray-900">
              Welcome back, {currentStudent.name.split(' ')[0]}!
            </h2>
            <p className="text-gray-600 mt-1">
              Here's an overview of your academic performance and upcoming tasks.
            </p>
          </div>
          <button
            onClick={() => setShowCustomization(!showCustomization)}
            className="flex items-center gap-2 px-4 py-2 text-sm font-medium text-purple-600 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors"
          >
            <Settings size={16} />
            Customize Dashboard
          </button>
        </div>
      </div>
      
      {showCustomization && (
        <div className="mb-6 p-4 bg-white rounded-xl shadow-sm border border-purple-100">
          <h3 className="text-lg font-semibold mb-4">Dashboard Customization</h3>
          <p className="text-sm text-gray-600 mb-4">
            Drag and drop widgets to reorder them, or toggle their visibility using the checkboxes.
          </p>
          <div className="space-y-2">
            {widgets.map((widget) => (
              <div key={widget.id} className="flex items-center gap-3 p-2 bg-gray-50 rounded-lg">
                <input
                  type="checkbox"
                  checked={widget.visible}
                  onChange={() => toggleWidgetVisibility(widget.id)}
                  className="rounded border-gray-300 text-purple-600 focus:ring-purple-500"
                />
                <span className="text-sm font-medium">{widget.title}</span>
              </div>
            ))}
          </div>
        </div>
      )}
      
      <div className="space-y-6">
        <QuickStats />
        
        <DndContext
          collisionDetection={closestCenter}
          onDragEnd={handleDragEnd}
        >
          <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <SortableContext items={widgets} strategy={verticalListSortingStrategy}>
              {widgets.map((widget) => (
                widget.visible && (
                  <DraggableWidget key={widget.id} id={widget.id}>
                    {widget.component}
                  </DraggableWidget>
                )
              ))}
            </SortableContext>
          </div>
        </DndContext>
      </div>
    </PageLayout>
  );
};

export default Dashboard;
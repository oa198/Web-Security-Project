import React from 'react';
import PageLayout from '../components/layout/PageLayout';
import QuickStats from '../components/dashboard/QuickStats';
import UpcomingAssignments from '../components/dashboard/UpcomingAssignments';
import CourseOverview from '../components/dashboard/CourseOverview';
import GradeDistribution from '../components/dashboard/GradeDistribution';
import RecentNotifications from '../components/dashboard/RecentNotifications';
import ClassSchedule from '../components/dashboard/ClassSchedule';
import FinancialSummary from '../components/dashboard/FinancialSummary';
import { currentStudent } from '../data/mockData';

const Dashboard: React.FC = () => {
  return (
    <PageLayout title="Dashboard">
      <div className="mb-6">
        <h2 className="text-2xl font-bold text-gray-900">
          Welcome back, {currentStudent.name.split(' ')[0]}!
        </h2>
        <p className="text-gray-600 mt-1">
          Here's an overview of your academic performance and upcoming tasks.
        </p>
      </div>
      
      <div className="space-y-6">
        {/* Quick Stats */}
        <QuickStats />
        
        {/* Main Grid */}
        <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
          {/* Left Column */}
          <div className="space-y-6">
            <UpcomingAssignments />
            <CourseOverview />
            <GradeDistribution />
          </div>
          
          {/* Right Column */}
          <div className="space-y-6">
            <RecentNotifications />
            <ClassSchedule />
            <FinancialSummary />
          </div>
        </div>
      </div>
    </PageLayout>
  );
};

export default Dashboard;
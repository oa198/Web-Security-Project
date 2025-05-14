import React from 'react';
import PageLayout from '../../components/layout/PageLayout';
import { Tabs, TabsContent, TabsList, TabsTrigger } from '../../components/ui/Tabs';
import CourseManagement from './CourseManagement';
import StudentManagement from './StudentManagement';
import FinancialManagement from './FinancialManagement';

const AdminDashboard: React.FC = () => {
  return (
    <PageLayout title="Administrator Dashboard">
      <Tabs defaultValue="courses" className="space-y-6">
        <TabsList>
          <TabsTrigger value="courses">Course Management</TabsTrigger>
          <TabsTrigger value="students">Student Management</TabsTrigger>
          <TabsTrigger value="financial">Financial Administration</TabsTrigger>
        </TabsList>

        <TabsContent value="courses">
          <CourseManagement />
        </TabsContent>

        <TabsContent value="students">
          <StudentManagement />
        </TabsContent>

        <TabsContent value="financial">
          <FinancialManagement />
        </TabsContent>
      </Tabs>
    </PageLayout>
  );
};

export default AdminDashboard;
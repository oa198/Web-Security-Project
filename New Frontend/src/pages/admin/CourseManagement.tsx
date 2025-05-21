import React, { useState } from 'react';
import Card from '../../components/ui/Card';
import Button from '../../components/ui/Button';
import { Plus, Edit2, Eye, EyeOff, Trash2 } from 'lucide-react';
import { Course } from '../../types';
import { courses } from '../../data/mockData';

const CourseManagement: React.FC = () => {
  const [courseList, setCourseList] = useState<Course[]>(courses);

  const toggleVisibility = (courseId: string) => {
    setCourseList(courses.map(course => 
      course.id === courseId 
        ? { ...course, visible: !course.visible }
        : course
    ));
  };

  return (
    <div className="space-y-6">
      <div className="flex justify-between items-center">
        <h2 className="text-2xl font-bold">Course Management</h2>
        <Button>
          <Plus size={16} className="mr-2" />
          Add New Course
        </Button>
      </div>

      <Card>
        <div className="overflow-x-auto">
          <table className="w-full">
            <thead>
              <tr className="border-b border-gray-200">
                <th className="text-left py-3 px-4">Course Code</th>
                <th className="text-left py-3 px-4">Title</th>
                <th className="text-left py-3 px-4">Instructor</th>
                <th className="text-left py-3 px-4">Units</th>
                <th className="text-left py-3 px-4">Capacity</th>
                <th className="text-left py-3 px-4">Prerequisites</th>
                <th className="text-left py-3 px-4">Visibility</th>
                <th className="text-left py-3 px-4">Actions</th>
              </tr>
            </thead>
            <tbody>
              {courseList.map((course) => (
                <tr key={course.id} className="border-b border-gray-100">
                  <td className="py-3 px-4">{course.code}</td>
                  <td className="py-3 px-4">{course.name}</td>
                  <td className="py-3 px-4">{course.instructor}</td>
                  <td className="py-3 px-4">{course.credits}</td>
                  <td className="py-3 px-4">{course.capacity || 30}</td>
                  <td className="py-3 px-4">
                    {course.prerequisites?.join(', ') || 'None'}
                  </td>
                  <td className="py-3 px-4">
                    <button
                      onClick={() => toggleVisibility(course.id)}
                      className={`p-1 rounded-full ${
                        course.visible 
                          ? 'text-green-600 hover:bg-green-50' 
                          : 'text-gray-400 hover:bg-gray-50'
                      }`}
                    >
                      {course.visible ? <Eye size={16} /> : <EyeOff size={16} />}
                    </button>
                  </td>
                  <td className="py-3 px-4">
                    <div className="flex space-x-2">
                      <button className="p-1 text-blue-600 hover:bg-blue-50 rounded-full">
                        <Edit2 size={16} />
                      </button>
                      <button className="p-1 text-red-600 hover:bg-red-50 rounded-full">
                        <Trash2 size={16} />
                      </button>
                    </div>
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      </Card>
    </div>
  );
};

export default CourseManagement;
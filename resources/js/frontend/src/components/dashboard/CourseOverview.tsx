import React from 'react';
import { BookOpen } from 'lucide-react';
import Card from '../ui/Card';
import Badge from '../ui/Badge';
import { courses } from '../../data/mockData';

const CourseOverview: React.FC = () => {
  // Get only enrolled courses
  const enrolledCourses = courses.filter(course => course.enrolled);
  
  return (
    <Card
      title="Current Courses"
      subtitle={`${enrolledCourses.length} courses this semester`}
      actions={
        <a href="/courses" className="text-sm text-purple-600 hover:underline">
          View All
        </a>
      }
      className="h-full"
    >
      <div className="space-y-4">
        {enrolledCourses.map((course) => (
          <div key={course.id} className="flex items-start">
            <div className="p-2 bg-purple-100 rounded-lg mr-3">
              <BookOpen size={20} className="text-purple-700" />
            </div>
            <div className="flex-1">
              <div className="flex items-start justify-between">
                <div>
                  <h4 className="font-medium text-gray-900">{course.name}</h4>
                  <p className="text-xs text-gray-500 mt-0.5">
                    {course.code} • {course.credits} Credits
                  </p>
                </div>
                <Badge variant="secondary" size="sm">
                  {course.department}
                </Badge>
              </div>
              <p className="text-sm text-gray-700 mt-1">
                Instructor: {course.instructor}
              </p>
              <p className="text-xs text-gray-500 mt-2">
                {course.schedule.days.join(', ')} • {course.schedule.startTime} - {course.schedule.endTime} • {course.schedule.location}
              </p>
            </div>
          </div>
        ))}
      </div>
    </Card>
  );
};

export default CourseOverview;
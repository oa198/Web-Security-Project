import React, { useState } from 'react';
import PageLayout from '../components/layout/PageLayout';
import Card from '../components/ui/Card';
import { courses } from '../data/mockData';

const Schedule: React.FC = () => {
  const [currentView, setCurrentView] = useState<'week' | 'list'>('week');
  
  // Time slots from 8 AM to 8 PM
  const timeSlots = Array.from({ length: 13 }, (_, i) => {
    const hour = i + 8;
    return `${hour > 12 ? hour - 12 : hour}:00 ${hour >= 12 ? 'PM' : 'AM'}`;
  });

  const days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
  const dayMap: Record<string, string> = {
    'Mon': 'Monday',
    'Tue': 'Tuesday',
    'Wed': 'Wednesday',
    'Thu': 'Thursday',
    'Fri': 'Friday'
  };

  const enrolledCourses = courses.filter(course => course.enrolled);

  const getCoursesForTimeSlot = (day: string, time: string) => {
    return enrolledCourses.filter(course => {
      const shortDay = Object.entries(dayMap).find(([_, value]) => value === day)?.[0];
      if (!course.schedule.days.includes(shortDay as any)) return false;

      const [timeHour] = time.split(':');
      const [startHour] = course.schedule.startTime.split(':');
      const [endHour] = course.schedule.endTime.split(':');

      const timeHour24 = parseInt(timeHour) + (time.includes('PM') && parseInt(timeHour) !== 12 ? 12 : 0);
      const startHour24 = parseInt(startHour);
      const endHour24 = parseInt(endHour);

      return timeHour24 >= startHour24 && timeHour24 < endHour24;
    });
  };

  const getColorForCourse = (department: string) => {
    const colors: Record<string, string> = {
      'Computer Science': 'bg-purple-100 text-purple-800 border-purple-200',
      'Mathematics': 'bg-blue-100 text-blue-800 border-blue-200',
      'English': 'bg-green-100 text-green-800 border-green-200',
      'Physics': 'bg-yellow-100 text-yellow-800 border-yellow-200'
    };
    return colors[department] || 'bg-gray-100 text-gray-800 border-gray-200';
  };

  return (
    <PageLayout title="Class Schedule">
      <div className="space-y-6">
        {/* View Toggle */}
        <div className="flex gap-2">
          <button
            className={`px-4 py-2 rounded-lg ${
              currentView === 'week' 
                ? 'bg-purple-100 text-purple-800' 
                : 'bg-gray-100 text-gray-600'
            }`}
            onClick={() => setCurrentView('week')}
          >
            Week View
          </button>
          <button
            className={`px-4 py-2 rounded-lg ${
              currentView === 'list' 
                ? 'bg-purple-100 text-purple-800' 
                : 'bg-gray-100 text-gray-600'
            }`}
            onClick={() => setCurrentView('list')}
          >
            List View
          </button>
        </div>

        {currentView === 'week' ? (
          <Card>
            <div className="overflow-x-auto">
              <table className="w-full min-w-[800px]">
                <thead>
                  <tr>
                    <th className="w-20 py-2 text-left text-xs font-semibold text-gray-500">Time</th>
                    {days.map(day => (
                      <th key={day} className="py-2 text-center text-xs font-semibold text-gray-500">
                        {day}
                      </th>
                    ))}
                  </tr>
                </thead>
                <tbody>
                  {timeSlots.map(timeSlot => (
                    <tr key={timeSlot} className="border-t border-gray-100">
                      <td className="py-2 align-top text-xs text-gray-500">{timeSlot}</td>
                      {days.map(day => {
                        const coursesAtTime = getCoursesForTimeSlot(day, timeSlot);
                        return (
                          <td key={`${day}-${timeSlot}`} className="p-1 align-top">
                            {coursesAtTime.map(course => (
                              <div 
                                key={course.id}
                                className={`p-1.5 text-xs rounded border ${getColorForCourse(course.department)}`}
                              >
                                <div className="font-medium">{course.code}</div>
                                <div className="text-[10px] truncate">{course.schedule.location}</div>
                              </div>
                            ))}
                          </td>
                        );
                      })}
                    </tr>
                  ))}
                </tbody>
              </table>
            </div>
          </Card>
        ) : (
          <div className="space-y-4">
            {days.map(day => {
              const daysCourses = enrolledCourses.filter(course => 
                course.schedule.days.includes(Object.entries(dayMap)
                  .find(([_, value]) => value === day)?.[0] as any)
              );

              if (daysCourses.length === 0) return null;

              return (
                <Card key={day} title={day}>
                  <div className="space-y-3">
                    {daysCourses
                      .sort((a, b) => a.schedule.startTime.localeCompare(b.schedule.startTime))
                      .map(course => (
                        <div 
                          key={course.id}
                          className={`p-3 rounded-lg ${getColorForCourse(course.department)}`}
                        >
                          <div className="flex justify-between items-start">
                            <div>
                              <h4 className="font-medium">{course.name}</h4>
                              <p className="text-sm">{course.code}</p>
                            </div>
                            <div className="text-sm">
                              {course.schedule.startTime} - {course.schedule.endTime}
                            </div>
                          </div>
                          <div className="mt-2 text-sm">
                            <p>{course.instructor}</p>
                            <p>{course.schedule.location}</p>
                          </div>
                        </div>
                    ))}
                  </div>
                </Card>
              );
            })}
          </div>
        )}
      </div>
    </PageLayout>
  );
};

export default Schedule;
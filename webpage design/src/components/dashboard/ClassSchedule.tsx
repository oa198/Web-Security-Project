import React from 'react';
import Card from '../ui/Card';
import { courses } from '../../data/mockData';

// Days of the week
const days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri'];

// Available time slots (8am to 6pm in 1-hour increments)
const timeSlots = Array.from({ length: 11 }, (_, i) => {
  const hour = i + 8;
  return `${hour > 12 ? hour - 12 : hour}${hour >= 12 ? 'pm' : 'am'}`;
});

const ClassSchedule: React.FC = () => {
  // Get only enrolled courses
  const enrolledCourses = courses.filter(course => course.enrolled);
  
  // Function to get course at specific day and time
  const getCourseAtTime = (day: string, timeSlot: string) => {
    const hour = parseInt(timeSlot.replace('am', '').replace('pm', ''));
    const is24Hour = timeSlot.includes('pm') && hour !== 12;
    const hour24 = is24Hour ? hour + 12 : hour;
    
    return enrolledCourses.find(course => {
      if (!course.schedule.days.includes(day as any)) return false;
      
      const startHour = parseInt(course.schedule.startTime.split(':')[0]);
      const endHour = parseInt(course.schedule.endTime.split(':')[0]);
      
      return hour24 >= startHour && hour24 < endHour;
    });
  };
  
  const colorMap: Record<string, string> = {
    'Computer Science': 'bg-purple-100 text-purple-800 border-purple-200',
    'Mathematics': 'bg-blue-100 text-blue-800 border-blue-200',
    'English': 'bg-green-100 text-green-800 border-green-200',
    'Physics': 'bg-yellow-100 text-yellow-800 border-yellow-200',
    'Chemistry': 'bg-red-100 text-red-800 border-red-200',
    'Biology': 'bg-teal-100 text-teal-800 border-teal-200',
  };
  
  return (
    <Card 
      title="Weekly Schedule" 
      subtitle="Current semester classes"
      actions={
        <a href="/schedule" className="text-sm text-purple-600 hover:underline">
          Full Calendar
        </a>
      }
      className="h-full"
    >
      <div className="overflow-x-auto">
        <table className="w-full min-w-full">
          <thead>
            <tr>
              <th className="w-16 py-2 text-left text-xs font-semibold text-gray-500">Time</th>
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
                  const course = getCourseAtTime(day, timeSlot);
                  return (
                    <td key={`${day}-${timeSlot}`} className="p-1 align-top">
                      {course && (
                        <div 
                          className={`p-1.5 text-xs rounded border ${colorMap[course.department] || 'bg-gray-100 border-gray-200 text-gray-800'}`}
                        >
                          <div className="font-medium">{course.code}</div>
                          <div className="text-[10px] truncate">{course.schedule.location}</div>
                        </div>
                      )}
                    </td>
                  );
                })}
              </tr>
            ))}
          </tbody>
        </table>
      </div>
    </Card>
  );
};

export default ClassSchedule;
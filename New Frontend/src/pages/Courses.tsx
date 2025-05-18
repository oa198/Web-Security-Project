import React, { useState } from 'react';
import PageLayout from '../components/layout/PageLayout';
import Card from '../components/ui/Card';
import Badge from '../components/ui/Badge';
import Button from '../components/ui/Button';
import { BookOpen, Users, Clock, MapPin } from 'lucide-react';
import { courses } from '../data/mockData';

const Courses: React.FC = () => {
  const [filter, setFilter] = useState<'all' | 'enrolled' | 'available'>('all');
  const [searchTerm, setSearchTerm] = useState('');

  const filteredCourses = courses.filter(course => {
    const matchesFilter = 
      filter === 'all' || 
      (filter === 'enrolled' && course.enrolled) ||
      (filter === 'available' && !course.enrolled);

    const matchesSearch = 
      course.name.toLowerCase().includes(searchTerm.toLowerCase()) ||
      course.code.toLowerCase().includes(searchTerm.toLowerCase()) ||
      course.instructor.toLowerCase().includes(searchTerm.toLowerCase());

    return matchesFilter && matchesSearch;
  });

  return (
    <PageLayout title="Courses">
      <div className="space-y-6">
        {/* Filters and Search */}
        <div className="flex flex-col sm:flex-row gap-4 items-center justify-between">
          <div className="flex gap-2">
            <Button 
              variant={filter === 'all' ? 'primary' : 'ghost'}
              onClick={() => setFilter('all')}
            >
              All Courses
            </Button>
            <Button 
              variant={filter === 'enrolled' ? 'primary' : 'ghost'}
              onClick={() => setFilter('enrolled')}
            >
              Enrolled
            </Button>
            <Button 
              variant={filter === 'available' ? 'primary' : 'ghost'}
              onClick={() => setFilter('available')}
            >
              Available
            </Button>
          </div>
          <div className="w-full sm:w-64">
            <input
              type="text"
              placeholder="Search courses..."
              className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
              value={searchTerm}
              onChange={(e) => setSearchTerm(e.target.value)}
            />
          </div>
        </div>

        {/* Course Grid */}
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          {filteredCourses.map((course) => (
            <Card key={course.id} hoverable>
              <div className="flex items-start justify-between mb-4">
                <div>
                  <h3 className="text-lg font-semibold text-gray-900">{course.name}</h3>
                  <p className="text-sm text-gray-500">{course.code}</p>
                </div>
                <Badge variant={course.enrolled ? 'success' : 'secondary'}>
                  {course.enrolled ? 'Enrolled' : 'Available'}
                </Badge>
              </div>

              <div className="space-y-3">
                <div className="flex items-center text-gray-600">
                  <Users size={18} className="mr-2" />
                  <span className="text-sm">{course.instructor}</span>
                </div>
                <div className="flex items-center text-gray-600">
                  <BookOpen size={18} className="mr-2" />
                  <span className="text-sm">{course.credits} Credits</span>
                </div>
                <div className="flex items-center text-gray-600">
                  <Clock size={18} className="mr-2" />
                  <span className="text-sm">
                    {course.schedule.days.join(', ')} • {course.schedule.startTime} - {course.schedule.endTime}
                  </span>
                </div>
                <div className="flex items-center text-gray-600">
                  <MapPin size={18} className="mr-2" />
                  <span className="text-sm">{course.schedule.location}</span>
                </div>
              </div>

              <div className="mt-4 pt-4 border-t border-gray-100">
                <Button 
                  variant={course.enrolled ? 'danger' : 'primary'}
                  fullWidth
                >
                  {course.enrolled ? 'Drop Course' : 'Enroll'}
                </Button>
              </div>
            </Card>
          ))}
        </div>
      </div>
    </PageLayout>
  );
};

export default Courses;
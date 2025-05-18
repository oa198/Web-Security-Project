import React, { useState } from 'react';
import PageLayout from '../components/layout/PageLayout';
import Card from '../components/ui/Card';
import Badge from '../components/ui/Badge';
import Button from '../components/ui/Button';
import { Clock, CheckCircle2, AlertTriangle, Upload } from 'lucide-react';
import { assignments } from '../data/mockData';

const Assignments: React.FC = () => {
  const [filter, setFilter] = useState<'all' | 'pending' | 'submitted' | 'graded'>('all');

  const filteredAssignments = assignments.filter(assignment => {
    if (filter === 'all') return true;
    return assignment.status.toLowerCase() === filter;
  });

  const getStatusColor = (status: string) => {
    switch (status.toLowerCase()) {
      case 'submitted': return 'success';
      case 'pending': return 'warning';
      case 'late': return 'danger';
      case 'graded': return 'primary';
      default: return 'secondary';
    }
  };

  const getStatusIcon = (status: string) => {
    switch (status.toLowerCase()) {
      case 'submitted': return <CheckCircle2 size={16} />;
      case 'pending': return <Clock size={16} />;
      case 'late': return <AlertTriangle size={16} />;
      default: return null;
    }
  };

  return (
    <PageLayout title="Assignments">
      <div className="space-y-6">
        {/* Filters */}
        <div className="flex gap-2">
          <Button 
            variant={filter === 'all' ? 'primary' : 'ghost'}
            onClick={() => setFilter('all')}
          >
            All
          </Button>
          <Button 
            variant={filter === 'pending' ? 'primary' : 'ghost'}
            onClick={() => setFilter('pending')}
          >
            Pending
          </Button>
          <Button 
            variant={filter === 'submitted' ? 'primary' : 'ghost'}
            onClick={() => setFilter('submitted')}
          >
            Submitted
          </Button>
          <Button 
            variant={filter === 'graded' ? 'primary' : 'ghost'}
            onClick={() => setFilter('graded')}
          >
            Graded
          </Button>
        </div>

        {/* Assignments List */}
        <div className="space-y-4">
          {filteredAssignments.map((assignment) => (
            <Card key={assignment.id}>
              <div className="flex items-start justify-between">
                <div className="space-y-1">
                  <div className="flex items-center gap-2">
                    <h3 className="text-lg font-semibold">{assignment.title}</h3>
                    <Badge variant={getStatusColor(assignment.status)}>
                      <div className="flex items-center gap-1">
                        {getStatusIcon(assignment.status)}
                        {assignment.status}
                      </div>
                    </Badge>
                  </div>
                  <p className="text-sm text-gray-500">{assignment.courseName}</p>
                  <p className="text-sm text-gray-700">{assignment.description}</p>
                  <p className="text-sm text-gray-600">
                    Due: {new Date(assignment.dueDate).toLocaleString()}
                  </p>
                  {assignment.grade && (
                    <p className="text-sm font-medium text-gray-900">
                      Grade: {assignment.grade}%
                    </p>
                  )}
                </div>
                {assignment.status === 'Pending' && (
                  <Button>
                    <Upload size={16} className="mr-2" />
                    Submit
                  </Button>
                )}
              </div>
            </Card>
          ))}
        </div>
      </div>
    </PageLayout>
  );
};

export default Assignments;
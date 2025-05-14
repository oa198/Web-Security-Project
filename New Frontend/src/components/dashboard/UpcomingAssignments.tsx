import React from 'react';
import { CheckCircle2, AlertCircle, Clock } from 'lucide-react';
import Card from '../ui/Card';
import Badge from '../ui/Badge';
import { Assignment } from '../../types';
import { assignments } from '../../data/mockData';

const AssignmentItem: React.FC<{ assignment: Assignment }> = ({ assignment }) => {
  const dueDate = new Date(assignment.dueDate);
  const isToday = new Date().toDateString() === dueDate.toDateString();
  const isPastDue = new Date() > dueDate;
  
  const statusIcon = () => {
    switch (assignment.status) {
      case 'Submitted':
        return <CheckCircle2 className="text-green-500" size={16} />;
      case 'Late':
        return <AlertCircle className="text-red-500" size={16} />;
      default:
        return <Clock className="text-yellow-500" size={16} />;
    }
  };
  
  const statusColor = () => {
    switch (assignment.status) {
      case 'Submitted':
        return 'success';
      case 'Graded':
        return 'primary';
      case 'Late':
        return 'danger';
      default:
        return isPastDue ? 'danger' : 'warning';
    }
  };
  
  return (
    <div className="py-3 border-b border-gray-100 last:border-0">
      <div className="flex items-start">
        <div className="mt-1 mr-3">{statusIcon()}</div>
        <div className="flex-1">
          <div className="flex items-start justify-between">
            <div>
              <h4 className="font-medium text-gray-900">{assignment.title}</h4>
              <p className="text-xs text-gray-500 mt-0.5">{assignment.courseName}</p>
            </div>
            <Badge variant={statusColor()}>
              {assignment.status}
            </Badge>
          </div>
          <p className="text-sm text-gray-700 mt-1">{assignment.description}</p>
          <p className="text-xs text-gray-500 mt-2">
            {isToday ? 'Due Today' : `Due ${dueDate.toLocaleDateString()}`} at {dueDate.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}
          </p>
        </div>
      </div>
    </div>
  );
};

const UpcomingAssignments: React.FC = () => {
  // Sort assignments by due date (closest first)
  const sortedAssignments = [...assignments]
    .sort((a, b) => new Date(a.dueDate).getTime() - new Date(b.dueDate).getTime())
    .slice(0, 4);
  
  return (
    <Card 
      title="Upcoming Assignments" 
      subtitle="Your most urgent tasks"
      actions={
        <a href="/assignments" className="text-sm text-purple-600 hover:underline">
          View All
        </a>
      }
      className="h-full"
    >
      <div className="space-y-1">
        {sortedAssignments.map((assignment) => (
          <AssignmentItem key={assignment.id} assignment={assignment} />
        ))}
      </div>
    </Card>
  );
};

export default UpcomingAssignments;
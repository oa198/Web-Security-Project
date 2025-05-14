import React from 'react';
import Card from '../ui/Card';
import { grades } from '../../data/mockData';

const GradeDistribution: React.FC = () => {
  // Count of each grade
  const gradeCounts: Record<string, number> = {};
  grades.forEach(grade => {
    gradeCounts[grade.grade] = (gradeCounts[grade.grade] || 0) + 1;
  });
  
  // Order grades from A to F
  const gradeOrder = ['A+', 'A', 'A-', 'B+', 'B', 'B-', 'C+', 'C', 'C-', 'D+', 'D', 'D-', 'F'];
  const sortedGrades = Object.entries(gradeCounts)
    .sort(([a], [b]) => gradeOrder.indexOf(a) - gradeOrder.indexOf(b));
  
  // Colors for different grade ranges
  const getGradeColor = (grade: string) => {
    if (grade.startsWith('A')) return 'bg-green-500';
    if (grade.startsWith('B')) return 'bg-blue-500';
    if (grade.startsWith('C')) return 'bg-yellow-500';
    if (grade.startsWith('D')) return 'bg-orange-500';
    return 'bg-red-500';
  };
  
  const maxCount = Math.max(...Object.values(gradeCounts));
  
  return (
    <Card 
      title="Grade Distribution" 
      subtitle="Current semester performance"
      actions={
        <a href="/grades" className="text-sm text-purple-600 hover:underline">
          Details
        </a>
      }
      className="h-full"
    >
      <div className="space-y-2">
        {sortedGrades.map(([grade, count]) => (
          <div key={grade} className="flex items-center">
            <div className="w-8 text-sm font-medium text-gray-700">{grade}</div>
            <div className="flex-1 h-6 bg-gray-100 rounded-full overflow-hidden">
              <div 
                className={`h-full ${getGradeColor(grade)} rounded-full transition-all duration-700`}
                style={{ width: `${(count / maxCount) * 100}%` }}
              />
            </div>
            <div className="w-8 text-right text-sm text-gray-500 ml-2">{count}</div>
          </div>
        ))}
      </div>
      
      <div className="mt-4 pt-4 border-t border-gray-100">
        <div className="flex justify-between text-sm">
          <div className="font-medium text-gray-700">Current GPA</div>
          <div className="font-semibold text-gray-900">3.75</div>
        </div>
        
        <div className="mt-2 h-2 bg-gray-100 rounded-full overflow-hidden">
          <div className="h-full bg-purple-600 rounded-full" style={{ width: '75%' }} />
        </div>
        
        <div className="mt-1 flex justify-between text-xs text-gray-500">
          <div>0.0</div>
          <div>4.0</div>
        </div>
      </div>
    </Card>
  );
};

export default GradeDistribution;
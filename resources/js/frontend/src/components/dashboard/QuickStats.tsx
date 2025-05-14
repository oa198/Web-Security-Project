import React from 'react';
import { GraduationCap, BookOpen, Calendar, AlertTriangle } from 'lucide-react';
import Card from '../ui/Card';

interface QuickStatProps {
  title: string;
  value: string;
  icon: React.ReactNode;
  trend?: {
    value: string;
    positive: boolean;
  };
  color: string;
}

const QuickStat: React.FC<QuickStatProps> = ({ title, value, icon, trend, color }) => {
  return (
    <Card className="h-full">
      <div className="flex items-start">
        <div className={`p-3 rounded-lg ${color} mr-4`}>{icon}</div>
        <div>
          <p className="text-sm font-medium text-gray-500">{title}</p>
          <h3 className="text-2xl font-bold mt-1">{value}</h3>
          {trend && (
            <p className={`text-xs mt-1 flex items-center ${trend.positive ? 'text-green-600' : 'text-red-600'}`}>
              {trend.positive ? '+' : ''}{trend.value}
              {trend.positive ? (
                <svg className="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 15l7-7 7 7" />
                </svg>
              ) : (
                <svg className="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M19 9l-7 7-7-7" />
                </svg>
              )}
            </p>
          )}
        </div>
      </div>
    </Card>
  );
};

const QuickStats: React.FC = () => {
  const stats = [
    {
      title: 'Current GPA',
      value: '3.75',
      icon: <GraduationCap size={24} className="text-purple-800" />,
      trend: {
        value: '0.2',
        positive: true,
      },
      color: 'bg-purple-100',
    },
    {
      title: 'Credits Completed',
      value: '45',
      icon: <BookOpen size={24} className="text-blue-800" />,
      trend: {
        value: '12 this semester',
        positive: true,
      },
      color: 'bg-blue-100',
    },
    {
      title: 'Classes Today',
      value: '2',
      icon: <Calendar size={24} className="text-green-800" />,
      color: 'bg-green-100',
    },
    {
      title: 'Due Assignments',
      value: '3',
      icon: <AlertTriangle size={24} className="text-yellow-800" />,
      trend: {
        value: '1 overdue',
        positive: false,
      },
      color: 'bg-yellow-100',
    },
  ];

  return (
    <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
      {stats.map((stat, index) => (
        <QuickStat
          key={index}
          title={stat.title}
          value={stat.value}
          icon={stat.icon}
          trend={stat.trend}
          color={stat.color}
        />
      ))}
    </div>
  );
};

export default QuickStats;
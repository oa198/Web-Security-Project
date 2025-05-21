import React from 'react';
import Card from '../ui/Card';
import Badge from '../ui/Badge';
import { BellRing, Info, AlertTriangle, CheckCircle2, XCircle } from 'lucide-react';
import { Notification } from '../../types';
import { notifications } from '../../data/mockData';

interface NotificationItemProps {
  notification: Notification;
}

const NotificationItem: React.FC<NotificationItemProps> = ({ notification }) => {
  const getIcon = () => {
    switch (notification.type) {
      case 'success':
        return <CheckCircle2 size={16} className="text-green-500" />;
      case 'warning':
        return <AlertTriangle size={16} className="text-yellow-500" />;
      case 'error':
        return <XCircle size={16} className="text-red-500" />;
      default:
        return <Info size={16} className="text-blue-500" />;
    }
  };
  
  const getBadgeVariant = () => {
    switch (notification.type) {
      case 'success':
        return 'success';
      case 'warning':
        return 'warning';
      case 'error':
        return 'danger';
      default:
        return 'info';
    }
  };
  
  return (
    <div className={`py-3 flex items-start ${!notification.read ? 'bg-purple-50' : ''}`}>
      <div className="mt-0.5 mr-3">{getIcon()}</div>
      <div className="flex-1">
        <div className="flex items-start justify-between">
          <h4 className="font-medium text-gray-900">{notification.title}</h4>
          <Badge variant={getBadgeVariant()} size="sm">{notification.type}</Badge>
        </div>
        <p className="text-sm text-gray-700 mt-1">{notification.message}</p>
        <p className="text-xs text-gray-500 mt-1">
          {new Date(notification.date).toLocaleString()}
        </p>
      </div>
    </div>
  );
};

const RecentNotifications: React.FC = () => {
  // Get the recent notifications, limit to 3
  const recentNotifications = notifications.slice(0, 3);
  
  return (
    <Card
      title="Recent Notifications"
      subtitle="Latest updates and alerts"
      actions={
        <a href="/notifications" className="text-sm text-purple-600 hover:underline">
          View All
        </a>
      }
      className="h-full"
    >
      <div className="divide-y divide-gray-100">
        {recentNotifications.map(notification => (
          <NotificationItem key={notification.id} notification={notification} />
        ))}
      </div>
      
      {recentNotifications.length === 0 && (
        <div className="py-6 flex flex-col items-center justify-center text-center">
          <BellRing size={40} className="text-gray-300 mb-2" />
          <p className="text-gray-500">No new notifications</p>
        </div>
      )}
    </Card>
  );
};

export default RecentNotifications;
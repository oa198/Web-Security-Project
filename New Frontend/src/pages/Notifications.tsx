import React, { useState } from 'react';
import PageLayout from '../components/layout/PageLayout';
import Card from '../components/ui/Card';
import Badge from '../components/ui/Badge';
import { Bell, Info, AlertTriangle, CheckCircle2, XCircle } from 'lucide-react';
import { notifications } from '../data/mockData';

const Notifications: React.FC = () => {
  const [filter, setFilter] = useState<'all' | 'unread'>('all');

  const filteredNotifications = notifications.filter(notification => 
    filter === 'all' || (filter === 'unread' && !notification.read)
  );

  const getIcon = (type: string) => {
    switch (type) {
      case 'success': return <CheckCircle2 size={20} className="text-green-500" />;
      case 'warning': return <AlertTriangle size={20} className="text-yellow-500" />;
      case 'error': return <XCircle size={20} className="text-red-500" />;
      default: return <Info size={20} className="text-blue-500" />;
    }
  };

  const getBadgeVariant = (type: string) => {
    switch (type) {
      case 'success': return 'success';
      case 'warning': return 'warning';
      case 'error': return 'danger';
      default: return 'info';
    }
  };

  return (
    <PageLayout title="Notifications">
      <div className="space-y-6">
        {/* Header with filters */}
        <div className="flex items-center justify-between">
          <div className="flex gap-4">
            <button
              className={`px-4 py-2 rounded-lg ${
                filter === 'all' 
                  ? 'bg-purple-100 text-purple-800' 
                  : 'bg-gray-100 text-gray-600'
              }`}
              onClick={() => setFilter('all')}
            >
              All Notifications
            </button>
            <button
              className={`px-4 py-2 rounded-lg ${
                filter === 'unread' 
                  ? 'bg-purple-100 text-purple-800' 
                  : 'bg-gray-100 text-gray-600'
              }`}
              onClick={() => setFilter('unread')}
            >
              Unread
            </button>
          </div>
          <button className="text-purple-600 hover:text-purple-700">
            Mark all as read
          </button>
        </div>

        {/* Notifications List */}
        <div className="space-y-4">
          {filteredNotifications.map((notification) => (
            <Card 
              key={notification.id} 
              className={!notification.read ? 'bg-purple-50' : ''}
            >
              <div className="flex items-start gap-4">
                <div className="mt-1">{getIcon(notification.type)}</div>
                <div className="flex-1">
                  <div className="flex items-start justify-between">
                    <div>
                      <h3 className="font-medium text-gray-900">
                        {notification.title}
                      </h3>
                      <p className="text-gray-600 mt-1">{notification.message}</p>
                    </div>
                    <Badge variant={getBadgeVariant(notification.type)}>
                      {notification.type}
                    </Badge>
                  </div>
                  <p className="text-sm text-gray-500 mt-2">
                    {new Date(notification.date).toLocaleString()}
                  </p>
                </div>
              </div>
            </Card>
          ))}
        </div>
      </div>
    </PageLayout>
  );
};

export default Notifications;
import React, { useState } from 'react';
import { Bell, Search, ChevronDown } from 'lucide-react';
import Avatar from '../ui/Avatar';
import Badge from '../ui/Badge';
import { currentStudent, notifications } from '../../data/mockData';

interface HeaderProps {
  title: string;
}

const Header: React.FC<HeaderProps> = ({ title }) => {
  const [isNotificationOpen, setIsNotificationOpen] = useState(false);
  const [isProfileOpen, setIsProfileOpen] = useState(false);
  
  const unreadNotifications = notifications.filter(notification => !notification.read);
  
  const toggleNotification = () => {
    setIsNotificationOpen(!isNotificationOpen);
    if (isProfileOpen) setIsProfileOpen(false);
  };
  
  const toggleProfile = () => {
    setIsProfileOpen(!isProfileOpen);
    if (isNotificationOpen) setIsNotificationOpen(false);
  };
  
  return (
    <header className="h-16 px-4 md:px-6 bg-white border-b border-gray-200 flex items-center justify-between">
      {/* Page Title */}
      <h1 className="text-xl font-semibold text-gray-900">{title}</h1>
      
      {/* Search - Hidden on Mobile */}
      <div className="hidden md:flex items-center bg-gray-100 rounded-lg px-3 py-2 w-72">
        <Search size={18} className="text-gray-500 mr-2" />
        <input
          type="text"
          placeholder="Search..."
          className="bg-transparent outline-none flex-1 text-sm"
        />
      </div>
      
      {/* Right Actions */}
      <div className="flex items-center">
        {/* Notifications */}
        <div className="relative">
          <button
            className="relative p-2 rounded-full hover:bg-gray-100 focus:outline-none"
            onClick={toggleNotification}
          >
            <Bell size={20} className="text-gray-600" />
            {unreadNotifications.length > 0 && (
              <span className="absolute top-1 right-1 flex h-5 w-5 items-center justify-center rounded-full bg-red-500 text-xs text-white">
                {unreadNotifications.length}
              </span>
            )}
          </button>
          
          {/* Notification Dropdown */}
          {isNotificationOpen && (
            <div className="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg py-2 z-50 border border-gray-200">
              <div className="px-4 py-2 border-b border-gray-200">
                <h3 className="text-sm font-semibold text-gray-900">Notifications</h3>
              </div>
              <div className="max-h-80 overflow-y-auto">
                {notifications.slice(0, 5).map(notification => (
                  <div
                    key={notification.id}
                    className={`px-4 py-3 hover:bg-gray-50 border-b border-gray-100 last:border-0 ${
                      !notification.read ? 'bg-purple-50' : ''
                    }`}
                  >
                    <div className="flex justify-between items-start">
                      <div>
                        <p className="text-sm font-medium text-gray-900">{notification.title}</p>
                        <p className="text-xs text-gray-500 mt-1">{notification.message}</p>
                      </div>
                      <Badge 
                        variant={
                          notification.type === 'success' ? 'success' : 
                          notification.type === 'warning' ? 'warning' : 
                          notification.type === 'error' ? 'danger' : 
                          'info'
                        } 
                        size="sm"
                      >
                        {notification.type}
                      </Badge>
                    </div>
                    <p className="text-[10px] text-gray-400 mt-1">
                      {new Date(notification.date).toLocaleDateString()}
                    </p>
                  </div>
                ))}
              </div>
              <div className="px-4 py-2 border-t border-gray-200">
                <a href="/notifications" className="text-xs text-purple-600 hover:underline">
                  View all notifications
                </a>
              </div>
            </div>
          )}
        </div>
        
        {/* Profile */}
        <div className="relative ml-3">
          <button
            className="flex items-center space-x-2 focus:outline-none"
            onClick={toggleProfile}
          >
            <Avatar src={currentStudent.avatar} alt={currentStudent.name} size="sm" />
            <span className="hidden md:inline-block font-medium text-sm text-gray-700">
              {currentStudent.name}
            </span>
            <ChevronDown size={16} className="text-gray-500" />
          </button>
          
          {/* Profile Dropdown */}
          {isProfileOpen && (
            <div className="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 z-50 border border-gray-200">
              <a
                href="/profile"
                className="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
              >
                Profile
              </a>
              <a
                href="/settings"
                className="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
              >
                Settings
              </a>
              <div className="border-t border-gray-100 my-1"></div>
              <a
                href="/logout"
                className="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100"
              >
                Logout
              </a>
            </div>
          )}
        </div>
      </div>
    </header>
  );
};

export default Header;
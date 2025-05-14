import React from 'react';
import { Link, useLocation } from 'react-router-dom';
import { 
  LayoutDashboard, 
  BookOpen, 
  GraduationCap, 
  Calendar, 
  ClipboardList,
  BellRing,
  DollarSign,
  FileText,
  Settings,
  LogOut,
  Menu,
  X,
  Shield
} from 'lucide-react';
import Avatar from '../ui/Avatar';
import { currentStudent } from '../../data/mockData';

interface SidebarProps {
  isOpen: boolean;
  onToggle: () => void;
}

const Sidebar: React.FC<SidebarProps> = ({ isOpen, onToggle }) => {
  const location = useLocation();
  const isAdmin = true; // Add admin check
  
  const menuItems = [
    { name: 'Dashboard', path: '/', icon: <LayoutDashboard size={20} /> },
    { name: 'Courses', path: '/courses', icon: <BookOpen size={20} /> },
    { name: 'Grades', path: '/grades', icon: <GraduationCap size={20} /> },
    { name: 'Schedule', path: '/schedule', icon: <Calendar size={20} /> },
    { name: 'Assignments', path: '/assignments', icon: <ClipboardList size={20} /> },
    { name: 'Notifications', path: '/notifications', icon: <BellRing size={20} /> },
    { name: 'Financial', path: '/financial', icon: <DollarSign size={20} /> },
    { name: 'Documents', path: '/documents', icon: <FileText size={20} /> },
  ];

  const adminItems = [
    { name: 'Admin Dashboard', path: '/admin', icon: <Shield size={20} /> }
  ];

  const sidebarClasses = isOpen 
    ? 'translate-x-0' 
    : '-translate-x-full lg:translate-x-0';

  return (
    <>
      {/* Mobile Overlay */}
      {isOpen && (
        <div 
          className="fixed inset-0 bg-black/50 z-20 lg:hidden"
          onClick={onToggle}
        />
      )}
    
      {/* Sidebar */}
      <aside 
        className={`fixed top-0 left-0 h-full w-64 bg-white border-r border-gray-200 z-30 transform transition-transform duration-300 ease-in-out ${sidebarClasses}`}
      >
        <div className="h-full flex flex-col">
          {/* Logo and Mobile Close Button */}
          <div className="h-16 px-4 border-b border-gray-200 flex items-center justify-between">
            <span className="text-xl font-bold text-purple-600">UniSIS</span>
            <button 
              className="p-1 rounded-full hover:bg-gray-100 lg:hidden"
              onClick={onToggle}
            >
              <X size={20} />
            </button>
          </div>
          
          {/* User Profile */}
          <div className="p-4 border-b border-gray-200">
            <div className="flex items-center space-x-3">
              <Avatar src={currentStudent.avatar} alt={currentStudent.name} size="md" />
              <div>
                <p className="font-medium text-gray-900">{currentStudent.name}</p>
                <p className="text-xs text-gray-500">{currentStudent.studentId}</p>
              </div>
            </div>
          </div>
          
          {/* Navigation */}
          <nav className="flex-1 px-2 py-4 overflow-y-auto">
            <ul className="space-y-1">
              {menuItems.map((item) => {
                const isActive = location.pathname === item.path;
                return (
                  <li key={item.path}>
                    <Link
                      to={item.path}
                      className={`flex items-center space-x-3 px-3 py-2 rounded-lg transition-colors ${
                        isActive
                          ? 'bg-purple-100 text-purple-800'
                          : 'text-gray-700 hover:bg-gray-100'
                      }`}
                    >
                      {item.icon}
                      <span>{item.name}</span>
                    </Link>
                  </li>
                );
              })}

              {isAdmin && (
                <>
                  <div className="my-4 border-t border-gray-200" />
                  {adminItems.map((item) => {
                    const isActive = location.pathname.startsWith(item.path);
                    return (
                      <li key={item.path}>
                        <Link
                          to={item.path}
                          className={`flex items-center space-x-3 px-3 py-2 rounded-lg transition-colors ${
                            isActive
                              ? 'bg-purple-100 text-purple-800'
                              : 'text-gray-700 hover:bg-gray-100'
                          }`}
                        >
                          {item.icon}
                          <span>{item.name}</span>
                        </Link>
                      </li>
                    );
                  })}
                </>
              )}
            </ul>
          </nav>
          
          {/* Footer Menu */}
          <div className="p-4 border-t border-gray-200">
            <ul className="space-y-1">
              <li>
                <Link
                  to="/settings"
                  className="flex items-center space-x-3 px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-100"
                >
                  <Settings size={20} />
                  <span>Settings</span>
                </Link>
              </li>
              <li>
                <Link
                  to="/logout"
                  className="flex items-center space-x-3 px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-100"
                >
                  <LogOut size={20} />
                  <span>Logout</span>
                </Link>
              </li>
            </ul>
          </div>
        </div>
      </aside>
      
      {/* Mobile Toggle Button */}
      <button
        className="fixed bottom-4 right-4 p-3 bg-purple-600 text-white rounded-full shadow-lg lg:hidden z-20"
        onClick={onToggle}
      >
        <Menu size={24} />
      </button>
    </>
  );
};

export default Sidebar;
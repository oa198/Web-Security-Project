import React, { useState } from 'react';
import Sidebar from './Sidebar';
import Header from './Header';

interface PageLayoutProps {
  children: React.ReactNode;
  title: string;
}

const PageLayout: React.FC<PageLayoutProps> = ({ children, title }) => {
  const [isSidebarOpen, setIsSidebarOpen] = useState(false);
  
  const toggleSidebar = () => {
    setIsSidebarOpen(!isSidebarOpen);
  };
  
  return (
    <div className="min-h-screen bg-gray-50">
      <Sidebar isOpen={isSidebarOpen} onToggle={toggleSidebar} />
      
      <div className="lg:pl-64 flex flex-col min-h-screen">
        <Header title={title} />
        
        <main className="flex-1 p-4 md:p-6">
          {children}
        </main>
        
        <footer className="py-4 px-6 text-center text-sm text-gray-500 border-t border-gray-200">
          © {new Date().getFullYear()} University Student Information System
        </footer>
      </div>
    </div>
  );
};

export default PageLayout;
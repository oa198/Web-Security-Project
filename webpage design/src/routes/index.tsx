import React from 'react';
import { BrowserRouter, Routes, Route, Navigate } from 'react-router-dom';
import Dashboard from '../pages/Dashboard';
import Login from '../pages/Login';
import Grades from '../pages/Grades';
import Courses from '../pages/Courses';
import Schedule from '../pages/Schedule';
import Assignments from '../pages/Assignments';
import Notifications from '../pages/Notifications';
import Financial from '../pages/Financial';
import Documents from '../pages/Documents';
import Settings from '../pages/Settings';

const AppRoutes: React.FC = () => {
  // For demo purposes, assume user is authenticated
  const isAuthenticated = true;
  
  return (
    <BrowserRouter>
      <Routes>
        <Route 
          path="/login" 
          element={isAuthenticated ? <Navigate to="/" /> : <Login />} 
        />
        <Route 
          path="/" 
          element={isAuthenticated ? <Dashboard /> : <Navigate to="/login" />} 
        />
        <Route 
          path="/grades" 
          element={isAuthenticated ? <Grades /> : <Navigate to="/login" />} 
        />
        <Route 
          path="/courses" 
          element={isAuthenticated ? <Courses /> : <Navigate to="/login" />} 
        />
        <Route 
          path="/schedule" 
          element={isAuthenticated ? <Schedule /> : <Navigate to="/login" />} 
        />
        <Route 
          path="/assignments" 
          element={isAuthenticated ? <Assignments /> : <Navigate to="/login" />} 
        />
        <Route 
          path="/notifications" 
          element={isAuthenticated ? <Notifications /> : <Navigate to="/login" />} 
        />
        <Route 
          path="/financial" 
          element={isAuthenticated ? <Financial /> : <Navigate to="/login" />} 
        />
        <Route 
          path="/documents" 
          element={isAuthenticated ? <Documents /> : <Navigate to="/login" />} 
        />
        <Route 
          path="/settings" 
          element={isAuthenticated ? <Settings /> : <Navigate to="/login" />} 
        />
        <Route path="*" element={<Navigate to="/" />} />
      </Routes>
    </BrowserRouter>
  );
};

export default AppRoutes;
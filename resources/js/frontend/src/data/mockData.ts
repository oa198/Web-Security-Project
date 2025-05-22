import { 
  Student, 
  Course, 
  Grade, 
  Assignment, 
  Notification, 
  FinancialRecord, 
  Document,
  Attendance 
} from '../types';
import axios from 'axios';

const api = axios.create({
  baseURL: '/api',
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json'
  }
});

// Add auth token to requests
api.interceptors.request.use(config => {
  const token = localStorage.getItem('token');
  if (token) {
    config.headers.Authorization = `Bearer ${token}`;
  }
  return config;
});

export const getStudentProfile = async (): Promise<Student> => {
  const response = await api.get('/student/profile');
  return response.data;
};

export const getStudentCourses = async (): Promise<Course[]> => {
  const response = await api.get('/student/courses');
  return response.data;
};

export const getStudentGrades = async (): Promise<Grade[]> => {
  const response = await api.get('/student/grades');
  return response.data;
};

export const getStudentAttendance = async (): Promise<Attendance[]> => {
  const response = await api.get('/student/attendance');
  return response.data;
};

export const getStudentDocuments = async (): Promise<Document[]> => {
  const response = await api.get('/student/documents');
  return response.data;
};

export const getStudentFinancialRecords = async (): Promise<FinancialRecord[]> => {
  const response = await api.get('/student/financial-records');
  return response.data;
};
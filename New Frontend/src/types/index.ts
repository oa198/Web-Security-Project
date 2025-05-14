export interface Student {
  id: string;
  name: string;
  email: string;
  studentId: string;
  department: string;
  enrollmentYear: number;
  avatar?: string;
  gpa: number;
  credits: number;
  financialStatus: 'Good Standing' | 'Hold' | 'Past Due';
  address?: {
    street: string;
    city: string;
    state: string;
    zip: string;
    country: string;
  };
  phone?: string;
}

export interface Course {
  id: string;
  code: string;
  name: string;
  instructor: string;
  credits: number;
  department: string;
  schedule: {
    days: ('Mon' | 'Tue' | 'Wed' | 'Thu' | 'Fri' | 'Sat' | 'Sun')[];
    startTime: string;
    endTime: string;
    location: string;
  };
  enrolled: boolean;
  capacity: number;
  prerequisites?: string[];
  visible: boolean;
}

export interface Grade {
  courseId: string;
  courseName: string;
  courseCode: string;
  grade: string;
  credits: number;
  semester: string;
  year: number;
}

export interface Assignment {
  id: string;
  courseId: string;
  courseName: string;
  title: string;
  description: string;
  dueDate: string;
  status: 'Pending' | 'Submitted' | 'Graded' | 'Late';
  grade?: number;
}

export interface Notification {
  id: string;
  title: string;
  message: string;
  type: 'info' | 'warning' | 'success' | 'error';
  date: string;
  read: boolean;
}

export interface FinancialRecord {
  id: string;
  type: 'Tuition' | 'Housing' | 'Meal Plan' | 'Books' | 'Financial Aid' | 'Scholarship' | 'Payment';
  amount: number;
  date: string;
  semester: string;
  year: number;
  status: 'Paid' | 'Due' | 'Overdue' | 'Credited';
  description: string;
  dueDate?: string;
  lateFee?: number;
}

export interface Document {
  id: string;
  name: string;
  type: 'Transcript' | 'Form' | 'Letter' | 'ID Card' | 'Certificate' | 'Other';
  uploadDate: string;
  size: string;
  url: string;
}

export interface Attendance {
  courseId: string;
  courseName: string;
  courseCode: string;
  date: string;
  status: 'Present' | 'Absent' | 'Late' | 'Excused';
}

export interface FinancialAid {
  id: string;
  type: 'Scholarship' | 'Grant';
  name: string;
  amount: number;
  status: 'Pending' | 'Approved' | 'Rejected';
  semester: string;
  year: number;
  discountPercentage?: number;
}

export interface AuditLog {
  id: string;
  adminId: string;
  action: string;
  details: string;
  timestamp: string;
  entityType: 'Course' | 'Student' | 'Financial';
  entityId: string;
}

export interface TuitionConfig {
  baseTuition: number;
  paymentDeadline: string;
  lateFeeAmount: number;
  lateFeePercentage: number;
  discounts: {
    id: string;
    name: string;
    percentage: number;
    conditions?: string;
  }[];
}
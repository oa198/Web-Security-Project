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

export const currentStudent: Student = {
  id: '1',
  name: 'Alex Johnson',
  email: 'alex.johnson@university.edu',
  studentId: 'S2023001',
  department: 'Computer Science',
  enrollmentYear: 2022,
  avatar: 'https://images.pexels.com/photos/220453/pexels-photo-220453.jpeg?auto=compress&cs=tinysrgb&w=600',
  gpa: 3.75,
  credits: 45,
  financialStatus: 'Good Standing',
  address: {
    street: '123 Campus Drive',
    city: 'University City',
    state: 'CA',
    zip: '90210',
    country: 'USA'
  },
  phone: '(555) 123-4567'
};

export const courses: Course[] = [
  {
    id: '101',
    code: 'CS101',
    name: 'Introduction to Computer Science',
    instructor: 'Dr. Sarah Miller',
    credits: 3,
    department: 'Computer Science',
    schedule: {
      days: ['Mon', 'Wed'],
      startTime: '10:00',
      endTime: '11:30',
      location: 'Science Building 305'
    },
    enrolled: true
  },
  {
    id: '102',
    code: 'CS202',
    name: 'Data Structures and Algorithms',
    instructor: 'Prof. James Wilson',
    credits: 4,
    department: 'Computer Science',
    schedule: {
      days: ['Tue', 'Thu'],
      startTime: '13:00',
      endTime: '14:30',
      location: 'Tech Building 405'
    },
    enrolled: true
  },
  {
    id: '103',
    code: 'MATH201',
    name: 'Calculus II',
    instructor: 'Dr. Emily Chen',
    credits: 4,
    department: 'Mathematics',
    schedule: {
      days: ['Mon', 'Wed', 'Fri'],
      startTime: '09:00',
      endTime: '10:00',
      location: 'Math Building 201'
    },
    enrolled: true
  },
  {
    id: '104',
    code: 'ENG105',
    name: 'Technical Writing',
    instructor: 'Prof. Robert Brown',
    credits: 3,
    department: 'English',
    schedule: {
      days: ['Tue', 'Thu'],
      startTime: '15:00',
      endTime: '16:30',
      location: 'Humanities 102'
    },
    enrolled: true
  },
  {
    id: '105',
    code: 'PHYS101',
    name: 'Physics for Engineers',
    instructor: 'Dr. Michael Grant',
    credits: 4,
    department: 'Physics',
    schedule: {
      days: ['Mon', 'Wed'],
      startTime: '13:00',
      endTime: '14:30',
      location: 'Science Building 210'
    },
    enrolled: false
  }
];

export const grades: Grade[] = [
  {
    courseId: '101',
    courseName: 'Introduction to Computer Science',
    courseCode: 'CS101',
    grade: 'A',
    credits: 3,
    semester: 'Fall',
    year: 2022
  },
  {
    courseId: '102',
    courseName: 'Data Structures and Algorithms',
    courseCode: 'CS202',
    grade: 'B+',
    credits: 4,
    semester: 'Spring',
    year: 2023
  },
  {
    courseId: '103',
    courseName: 'Calculus II',
    courseCode: 'MATH201',
    grade: 'A-',
    credits: 4,
    semester: 'Fall',
    year: 2022
  },
  {
    courseId: '106',
    courseName: 'Introduction to Programming',
    courseCode: 'CS100',
    grade: 'A',
    credits: 3,
    semester: 'Fall',
    year: 2022
  },
  {
    courseId: '107',
    courseName: 'Digital Logic Design',
    courseCode: 'CS150',
    grade: 'B',
    credits: 3,
    semester: 'Spring',
    year: 2023
  }
];

export const assignments: Assignment[] = [
  {
    id: 'a1',
    courseId: '101',
    courseName: 'Introduction to Computer Science',
    title: 'Programming Assignment 3',
    description: 'Implement a simple scheduling algorithm in Python',
    dueDate: '2023-06-15T23:59:00',
    status: 'Pending'
  },
  {
    id: 'a2',
    courseId: '102',
    courseName: 'Data Structures and Algorithms',
    title: 'Final Project',
    description: 'Implement a graph algorithm to solve a real-world problem',
    dueDate: '2023-06-20T23:59:00',
    status: 'Pending'
  },
  {
    id: 'a3',
    courseId: '103',
    courseName: 'Calculus II',
    title: 'Problem Set 5',
    description: 'Solve problems on integration techniques',
    dueDate: '2023-06-10T23:59:00',
    status: 'Submitted'
  },
  {
    id: 'a4',
    courseId: '104',
    courseName: 'Technical Writing',
    title: 'Research Paper',
    description: 'Write a 10-page research paper on a technical topic',
    dueDate: '2023-06-18T23:59:00',
    status: 'Pending'
  },
  {
    id: 'a5',
    courseId: '101',
    courseName: 'Introduction to Computer Science',
    title: 'Quiz 2',
    description: 'Online quiz covering chapters 4-6',
    dueDate: '2023-06-08T14:30:00',
    status: 'Graded',
    grade: 85
  }
];

export const notifications: Notification[] = [
  {
    id: 'n1',
    title: 'Course Registration Open',
    message: 'Registration for Fall 2023 courses is now open. Please log in to register.',
    type: 'info',
    date: '2023-06-01T09:00:00',
    read: false
  },
  {
    id: 'n2',
    title: 'Assignment Due Soon',
    message: 'Your Programming Assignment 3 for CS101 is due in 2 days.',
    type: 'warning',
    date: '2023-06-13T10:15:00',
    read: false
  },
  {
    id: 'n3',
    title: 'New Grade Posted',
    message: 'A new grade has been posted for your CS101 Quiz 2.',
    type: 'success',
    date: '2023-06-09T15:30:00',
    read: true
  },
  {
    id: 'n4',
    title: 'Financial Aid Update',
    message: 'Your financial aid package for the upcoming semester has been updated.',
    type: 'info',
    date: '2023-06-05T11:45:00',
    read: true
  },
  {
    id: 'n5',
    title: 'Library Book Overdue',
    message: 'Your borrowed book "Algorithms to Live By" is now overdue by 3 days.',
    type: 'error',
    date: '2023-06-12T08:20:00',
    read: false
  }
];

export const financialRecords: FinancialRecord[] = [
  {
    id: 'f1',
    type: 'Tuition',
    amount: 12500,
    date: '2023-01-15',
    semester: 'Spring',
    year: 2023,
    status: 'Paid',
    description: 'Spring 2023 Tuition'
  },
  {
    id: 'f2',
    type: 'Housing',
    amount: 4800,
    date: '2023-01-15',
    semester: 'Spring',
    year: 2023,
    status: 'Paid',
    description: 'On-campus housing for Spring 2023'
  },
  {
    id: 'f3',
    type: 'Meal Plan',
    amount: 2200,
    date: '2023-01-15',
    semester: 'Spring',
    year: 2023,
    status: 'Paid',
    description: 'Standard meal plan for Spring 2023'
  },
  {
    id: 'f4',
    type: 'Financial Aid',
    amount: -8500,
    date: '2023-01-10',
    semester: 'Spring',
    year: 2023,
    status: 'Credited',
    description: 'Federal Student Aid'
  },
  {
    id: 'f5',
    type: 'Scholarship',
    amount: -5000,
    date: '2023-01-10',
    semester: 'Spring',
    year: 2023,
    status: 'Credited',
    description: 'Merit Scholarship'
  },
  {
    id: 'f6',
    type: 'Books',
    amount: 650,
    date: '2023-01-25',
    semester: 'Spring',
    year: 2023,
    status: 'Paid',
    description: 'Textbooks purchased from university bookstore'
  },
  {
    id: 'f7',
    type: 'Tuition',
    amount: 12500,
    date: '2023-08-15',
    semester: 'Fall',
    year: 2023,
    status: 'Due',
    description: 'Fall 2023 Tuition'
  }
];

export const documents: Document[] = [
  {
    id: 'd1',
    name: 'Official Transcript',
    type: 'Transcript',
    uploadDate: '2023-05-30',
    size: '1.2 MB',
    url: '/documents/transcript.pdf'
  },
  {
    id: 'd2',
    name: 'Financial Aid Form',
    type: 'Form',
    uploadDate: '2023-04-15',
    size: '450 KB',
    url: '/documents/financial_aid.pdf'
  },
  {
    id: 'd3',
    name: 'Student ID Card',
    type: 'ID Card',
    uploadDate: '2022-09-01',
    size: '850 KB',
    url: '/documents/student_id.pdf'
  },
  {
    id: 'd4',
    name: 'Housing Agreement',
    type: 'Form',
    uploadDate: '2022-08-15',
    size: '320 KB',
    url: '/documents/housing.pdf'
  },
  {
    id: 'd5',
    name: 'Academic Achievement Certificate',
    type: 'Certificate',
    uploadDate: '2023-01-10',
    size: '780 KB',
    url: '/documents/certificate.pdf'
  }
];

export const attendance: Attendance[] = [
  {
    courseId: '101',
    courseName: 'Introduction to Computer Science',
    courseCode: 'CS101',
    date: '2023-06-01',
    status: 'Present'
  },
  {
    courseId: '101',
    courseName: 'Introduction to Computer Science',
    courseCode: 'CS101',
    date: '2023-06-06',
    status: 'Present'
  },
  {
    courseId: '101',
    courseName: 'Introduction to Computer Science',
    courseCode: 'CS101',
    date: '2023-06-08',
    status: 'Late'
  },
  {
    courseId: '102',
    courseName: 'Data Structures and Algorithms',
    courseCode: 'CS202',
    date: '2023-06-01',
    status: 'Present'
  },
  {
    courseId: '102',
    courseName: 'Data Structures and Algorithms',
    courseCode: 'CS202',
    date: '2023-06-06',
    status: 'Present'
  },
  {
    courseId: '102',
    courseName: 'Data Structures and Algorithms',
    courseCode: 'CS202',
    date: '2023-06-08',
    status: 'Absent'
  },
  {
    courseId: '103',
    courseName: 'Calculus II',
    courseCode: 'MATH201',
    date: '2023-06-02',
    status: 'Present'
  },
  {
    courseId: '103',
    courseName: 'Calculus II',
    courseCode: 'MATH201',
    date: '2023-06-05',
    status: 'Present'
  },
  {
    courseId: '103',
    courseName: 'Calculus II',
    courseCode: 'MATH201',
    date: '2023-06-07',
    status: 'Present'
  },
  {
    courseId: '103',
    courseName: 'Calculus II',
    courseCode: 'MATH201',
    date: '2023-06-09',
    status: 'Excused'
  }
];
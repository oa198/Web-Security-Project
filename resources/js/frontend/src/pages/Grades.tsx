import React from 'react';
import PageLayout from '../components/layout/PageLayout';
import Card from '../components/ui/Card';
import Badge from '../components/ui/Badge';
import { grades } from '../data/mockData';

const Grades: React.FC = () => {
  // Calculate GPA
  const calculateGPA = () => {
    const gradePoints: { [key: string]: number } = {
      'A+': 4.0, 'A': 4.0, 'A-': 3.7,
      'B+': 3.3, 'B': 3.0, 'B-': 2.7,
      'C+': 2.3, 'C': 2.0, 'C-': 1.7,
      'D+': 1.3, 'D': 1.0, 'D-': 0.7,
      'F': 0.0
    };

    const totalPoints = grades.reduce((sum, grade) => 
      sum + (gradePoints[grade.grade] * grade.credits), 0);
    const totalCredits = grades.reduce((sum, grade) => sum + grade.credits, 0);
    
    return (totalPoints / totalCredits).toFixed(2);
  };

  // Group grades by semester
  const gradesBySemester = grades.reduce((acc, grade) => {
    const key = `${grade.semester} ${grade.year}`;
    if (!acc[key]) acc[key] = [];
    acc[key].push(grade);
    return acc;
  }, {} as Record<string, typeof grades>);

  const getGradeColor = (grade: string) => {
    if (grade.startsWith('A')) return 'success';
    if (grade.startsWith('B')) return 'primary';
    if (grade.startsWith('C')) return 'warning';
    return 'danger';
  };

  return (
    <PageLayout title="Grades">
      <div className="space-y-6">
        {/* GPA Overview */}
        <Card className="bg-gradient-to-r from-purple-500 to-purple-700 text-white">
          <div className="flex items-center justify-between">
            <div>
              <h3 className="text-2xl font-bold">Current GPA</h3>
              <p className="text-purple-100">Overall academic performance</p>
            </div>
            <div className="text-4xl font-bold">{calculateGPA()}</div>
          </div>
        </Card>

        {/* Grades by Semester */}
        {Object.entries(gradesBySemester).map(([semester, semesterGrades]) => (
          <Card key={semester} title={semester}>
            <div className="overflow-x-auto">
              <table className="w-full">
                <thead>
                  <tr className="border-b border-gray-200">
                    <th className="text-left py-3 px-4">Course Code</th>
                    <th className="text-left py-3 px-4">Course Name</th>
                    <th className="text-left py-3 px-4">Credits</th>
                    <th className="text-left py-3 px-4">Grade</th>
                  </tr>
                </thead>
                <tbody>
                  {semesterGrades.map((grade) => (
                    <tr key={grade.courseId} className="border-b border-gray-100">
                      <td className="py-3 px-4">{grade.courseCode}</td>
                      <td className="py-3 px-4">{grade.courseName}</td>
                      <td className="py-3 px-4">{grade.credits}</td>
                      <td className="py-3 px-4">
                        <Badge variant={getGradeColor(grade.grade)}>
                          {grade.grade}
                        </Badge>
                      </td>
                    </tr>
                  ))}
                </tbody>
              </table>
            </div>
          </Card>
        ))}
      </div>
    </PageLayout>
  );
};

export default Grades;
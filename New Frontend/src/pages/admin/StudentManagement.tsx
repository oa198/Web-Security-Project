import React from 'react';
import Card from '../../components/ui/Card';
import Button from '../../components/ui/Button';
import Badge from '../../components/ui/Badge';
import { UserX, RefreshCw, Shield, DollarSign } from 'lucide-react';

const StudentManagement: React.FC = () => {
  return (
    <div className="space-y-6">
      <h2 className="text-2xl font-bold">Student Management</h2>

      <Card>
        <div className="overflow-x-auto">
          <table className="w-full">
            <thead>
              <tr className="border-b border-gray-200">
                <th className="text-left py-3 px-4">Student ID</th>
                <th className="text-left py-3 px-4">Name</th>
                <th className="text-left py-3 px-4">Course</th>
                <th className="text-left py-3 px-4">Status</th>
                <th className="text-left py-3 px-4">Payment</th>
                <th className="text-left py-3 px-4">Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr className="border-b border-gray-100">
                <td className="py-3 px-4">S2023001</td>
                <td className="py-3 px-4">Alex Johnson</td>
                <td className="py-3 px-4">CS101</td>
                <td className="py-3 px-4">
                  <Badge variant="success">Active</Badge>
                </td>
                <td className="py-3 px-4">
                  <Badge variant="success">Compliant</Badge>
                </td>
                <td className="py-3 px-4">
                  <div className="flex space-x-2">
                    <Button variant="outline" size="sm">
                      <UserX size={16} className="mr-2" />
                      Drop
                    </Button>
                    <Button variant="outline" size="sm">
                      <RefreshCw size={16} className="mr-2" />
                      Override
                    </Button>
                  </div>
                </td>
              </tr>
              {/* Add more student rows here */}
            </tbody>
          </table>
        </div>
      </Card>

      <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
        <Card title="Withdrawal Requests">
          <div className="space-y-4">
            <div className="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
              <div>
                <p className="font-medium">John Doe (S2023002)</p>
                <p className="text-sm text-gray-600">CS202 - Data Structures</p>
              </div>
              <div className="flex space-x-2">
                <Button variant="ghost" size="sm">Deny</Button>
                <Button size="sm">Approve</Button>
              </div>
            </div>
            {/* Add more withdrawal requests */}
          </div>
        </Card>

        <Card title="Academic Status Changes">
          <div className="space-y-4">
            <div className="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
              <div>
                <p className="font-medium">Emma Wilson (S2023003)</p>
                <p className="text-sm text-gray-600">Academic Probation</p>
              </div>
              <Button variant="outline" size="sm">
                <Shield size={16} className="mr-2" />
                Review
              </Button>
            </div>
            {/* Add more status changes */}
          </div>
        </Card>
      </div>
    </div>
  );
};

export default StudentManagement;
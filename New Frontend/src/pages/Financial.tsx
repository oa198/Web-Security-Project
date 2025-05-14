import React from 'react';
import PageLayout from '../components/layout/PageLayout';
import Card from '../components/ui/Card';
import Badge from '../components/ui/Badge';
import Button from '../components/ui/Button';
import { DollarSign, ArrowDown, ArrowUp, AlertTriangle, Clock, CheckCircle2 } from 'lucide-react';
import { financialRecords } from '../data/mockData';

const Financial: React.FC = () => {
  // Calculate totals
  const totalCharges = financialRecords
    .filter(record => record.amount > 0)
    .reduce((sum, record) => sum + record.amount, 0);
    
  const totalCredits = financialRecords
    .filter(record => record.amount < 0)
    .reduce((sum, record) => sum + Math.abs(record.amount), 0);
    
  const balance = totalCharges - totalCredits;

  const tuitionDetails = {
    baseTuition: 12500,
    paymentDeadline: '2023-08-15',
    lateFee: 250,
    currentBalance: balance,
    status: balance > 0 ? 'Unpaid' : balance === 0 ? 'Paid' : 'Overpaid'
  };

  const financialAid = {
    scholarships: [
      { name: 'Merit Scholarship', amount: 5000 },
      { name: 'Department Grant', amount: 2500 }
    ],
    discounts: [
      { name: 'Early Payment', percentage: 5 },
      { name: 'Need-based Aid', percentage: 10 }
    ],
    totalDeductions: 8500
  };

  const getStatusColor = (status: string) => {
    switch (status.toLowerCase()) {
      case 'paid': return 'success';
      case 'unpaid': return 'danger';
      case 'overpaid': return 'info';
      default: return 'warning';
    }
  };

  const isOverdue = new Date(tuitionDetails.paymentDeadline) < new Date();

  return (
    <PageLayout title="Financial Information">
      <div className="space-y-6">
        {/* Tuition Details */}
        <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
          <Card title="Tuition Details">
            <div className="space-y-4">
              <div className="flex justify-between items-center">
                <span className="text-gray-600">Base Tuition</span>
                <span className="font-semibold">${tuitionDetails.baseTuition.toLocaleString()}</span>
              </div>
              
              <div className="flex justify-between items-center">
                <div className="flex items-center">
                  <span className="text-gray-600">Payment Deadline</span>
                  {isOverdue && (
                    <span className="ml-2 text-red-500 flex items-center">
                      <AlertTriangle size={16} className="mr-1" />
                      Overdue
                    </span>
                  )}
                </div>
                <span className="font-semibold">
                  {new Date(tuitionDetails.paymentDeadline).toLocaleDateString()}
                </span>
              </div>
              
              {isOverdue && (
                <div className="flex justify-between items-center text-red-600">
                  <span>Late Fee</span>
                  <span className="font-semibold">+${tuitionDetails.lateFee.toLocaleString()}</span>
                </div>
              )}
              
              <div className="pt-4 border-t border-gray-200">
                <div className="flex justify-between items-center">
                  <span className="text-lg font-medium">Current Balance</span>
                  <div className="text-right">
                    <span className={`text-xl font-bold ${balance > 0 ? 'text-red-600' : 'text-green-600'}`}>
                      ${Math.abs(balance).toLocaleString()}
                    </span>
                    <div className="mt-1">
                      <Badge variant={getStatusColor(tuitionDetails.status)}>
                        {tuitionDetails.status}
                      </Badge>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </Card>

          <Card title="Financial Aid & Discounts">
            <div className="space-y-4">
              <div>
                <h4 className="font-medium text-gray-700 mb-2">Scholarships & Grants</h4>
                {financialAid.scholarships.map((item, index) => (
                  <div key={index} className="flex justify-between items-center mb-2">
                    <span className="text-gray-600">{item.name}</span>
                    <span className="font-semibold text-green-600">
                      -${item.amount.toLocaleString()}
                    </span>
                  </div>
                ))}
              </div>

              <div>
                <h4 className="font-medium text-gray-700 mb-2">Available Discounts</h4>
                {financialAid.discounts.map((item, index) => (
                  <div key={index} className="flex justify-between items-center mb-2">
                    <span className="text-gray-600">{item.name}</span>
                    <span className="font-semibold">{item.percentage}%</span>
                  </div>
                ))}
              </div>

              <div className="pt-4 border-t border-gray-200">
                <div className="flex justify-between items-center">
                  <span className="text-lg font-medium">Total Deductions</span>
                  <span className="text-xl font-bold text-green-600">
                    -${financialAid.totalDeductions.toLocaleString()}
                  </span>
                </div>
              </div>
            </div>
          </Card>
        </div>

        {/* Payment History */}
        <Card title="Payment History">
          <div className="overflow-x-auto">
            <table className="w-full">
              <thead>
                <tr className="border-b border-gray-200">
                  <th className="text-left py-3 px-4">Date</th>
                  <th className="text-left py-3 px-4">Type</th>
                  <th className="text-left py-3 px-4">Description</th>
                  <th className="text-left py-3 px-4">Amount</th>
                  <th className="text-left py-3 px-4">Status</th>
                </tr>
              </thead>
              <tbody>
                {financialRecords.map((record) => (
                  <tr key={record.id} className="border-b border-gray-100">
                    <td className="py-3 px-4">
                      {new Date(record.date).toLocaleDateString()}
                    </td>
                    <td className="py-3 px-4">{record.type}</td>
                    <td className="py-3 px-4">{record.description}</td>
                    <td className="py-3 px-4">
                      <span className={record.amount < 0 ? 'text-green-600' : 'text-red-600'}>
                        {record.amount < 0 ? '-' : ''}${Math.abs(record.amount).toLocaleString()}
                      </span>
                    </td>
                    <td className="py-3 px-4">
                      <Badge 
                        variant={
                          record.status === 'Paid' ? 'success' :
                          record.status === 'Due' ? 'warning' :
                          record.status === 'Overdue' ? 'danger' :
                          'info'
                        }
                      >
                        {record.status}
                      </Badge>
                    </td>
                  </tr>
                ))}
              </tbody>
            </table>
          </div>
        </Card>

        {/* Payment Actions */}
        <div className="flex justify-end space-x-4">
          <Button variant="outline">Download Statement</Button>
          <Button>Make Payment</Button>
        </div>
      </div>
    </PageLayout>
  );
};

export default Financial;
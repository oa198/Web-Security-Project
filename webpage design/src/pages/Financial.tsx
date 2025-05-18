import React from 'react';
import PageLayout from '../components/layout/PageLayout';
import Card from '../components/ui/Card';
import Badge from '../components/ui/Badge';
import { DollarSign, ArrowDown, ArrowUp, Download } from 'lucide-react';
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

  return (
    <PageLayout title="Financial Information">
      <div className="space-y-6">
        {/* Summary Cards */}
        <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
          <Card>
            <div className="flex items-center gap-4">
              <div className="p-3 bg-purple-100 rounded-lg">
                <DollarSign size={24} className="text-purple-600" />
              </div>
              <div>
                <p className="text-sm text-gray-500">Current Balance</p>
                <p className={`text-2xl font-bold ${balance > 0 ? 'text-red-600' : 'text-green-600'}`}>
                  ${Math.abs(balance).toLocaleString()}
                </p>
              </div>
            </div>
          </Card>

          <Card>
            <div className="flex items-center gap-4">
              <div className="p-3 bg-red-100 rounded-lg">
                <ArrowUp size={24} className="text-red-600" />
              </div>
              <div>
                <p className="text-sm text-gray-500">Total Charges</p>
                <p className="text-2xl font-bold text-gray-900">
                  ${totalCharges.toLocaleString()}
                </p>
              </div>
            </div>
          </Card>

          <Card>
            <div className="flex items-center gap-4">
              <div className="p-3 bg-green-100 rounded-lg">
                <ArrowDown size={24} className="text-green-600" />
              </div>
              <div>
                <p className="text-sm text-gray-500">Total Credits</p>
                <p className="text-2xl font-bold text-gray-900">
                  ${totalCredits.toLocaleString()}
                </p>
              </div>
            </div>
          </Card>
        </div>

        {/* Transactions Table */}
        <Card title="Transaction History">
          <div className="overflow-x-auto">
            <table className="w-full">
              <thead>
                <tr className="border-b border-gray-200">
                  <th className="text-left py-3 px-4">Date</th>
                  <th className="text-left py-3 px-4">Type</th>
                  <th className="text-left py-3 px-4">Description</th>
                  <th className="text-left py-3 px-4">Amount</th>
                  <th className="text-left py-3 px-4">Status</th>
                  <th className="text-left py-3 px-4">Actions</th>
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
                    <td className="py-3 px-4">
                      <button className="text-purple-600 hover:text-purple-700">
                        <Download size={16} />
                      </button>
                    </td>
                  </tr>
                ))}
              </tbody>
            </table>
          </div>
        </Card>
      </div>
    </PageLayout>
  );
};

export default Financial;
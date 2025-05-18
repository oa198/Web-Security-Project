import React, { useState } from 'react';
import Card from '../../components/ui/Card';
import Button from '../../components/ui/Button';
import { Calendar, DollarSign, Percent, Award } from 'lucide-react';
import { TuitionConfig } from '../../types';

const FinancialManagement: React.FC = () => {
  const [tuitionConfig, setTuitionConfig] = useState<TuitionConfig>({
    baseTuition: 12500,
    paymentDeadline: '2023-08-15',
    lateFeeAmount: 250,
    lateFeePercentage: 5,
    discounts: [
      { id: '1', name: 'Early Payment', percentage: 5 },
      { id: '2', name: 'Need-based Aid', percentage: 10 },
      { id: '3', name: 'Academic Excellence', percentage: 15 }
    ]
  });

  return (
    <div className="space-y-6">
      <h2 className="text-2xl font-bold">Financial Administration</h2>

      <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
        <Card title="Tuition Configuration">
          <div className="space-y-4">
            <div>
              <label className="block text-sm font-medium text-gray-700">Base Tuition</label>
              <div className="mt-1 relative rounded-md shadow-sm">
                <div className="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <DollarSign size={16} className="text-gray-400" />
                </div>
                <input
                  type="number"
                  value={tuitionConfig.baseTuition}
                  onChange={(e) => setTuitionConfig({
                    ...tuitionConfig,
                    baseTuition: parseInt(e.target.value)
                  })}
                  className="block w-full pl-10 pr-12 sm:text-sm border-gray-300 rounded-md"
                />
              </div>
            </div>

            <div>
              <label className="block text-sm font-medium text-gray-700">Payment Deadline</label>
              <div className="mt-1 relative rounded-md shadow-sm">
                <div className="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <Calendar size={16} className="text-gray-400" />
                </div>
                <input
                  type="date"
                  value={tuitionConfig.paymentDeadline}
                  onChange={(e) => setTuitionConfig({
                    ...tuitionConfig,
                    paymentDeadline: e.target.value
                  })}
                  className="block w-full pl-10 pr-12 sm:text-sm border-gray-300 rounded-md"
                />
              </div>
            </div>

            <div className="grid grid-cols-2 gap-4">
              <div>
                <label className="block text-sm font-medium text-gray-700">Late Fee Amount</label>
                <div className="mt-1 relative rounded-md shadow-sm">
                  <div className="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <DollarSign size={16} className="text-gray-400" />
                  </div>
                  <input
                    type="number"
                    value={tuitionConfig.lateFeeAmount}
                    onChange={(e) => setTuitionConfig({
                      ...tuitionConfig,
                      lateFeeAmount: parseInt(e.target.value)
                    })}
                    className="block w-full pl-10 pr-12 sm:text-sm border-gray-300 rounded-md"
                  />
                </div>
              </div>

              <div>
                <label className="block text-sm font-medium text-gray-700">Late Fee Percentage</label>
                <div className="mt-1 relative rounded-md shadow-sm">
                  <div className="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <Percent size={16} className="text-gray-400" />
                  </div>
                  <input
                    type="number"
                    value={tuitionConfig.lateFeePercentage}
                    onChange={(e) => setTuitionConfig({
                      ...tuitionConfig,
                      lateFeePercentage: parseInt(e.target.value)
                    })}
                    className="block w-full pl-10 pr-12 sm:text-sm border-gray-300 rounded-md"
                  />
                </div>
              </div>
            </div>
          </div>
        </Card>

        <Card title="Discount Programs">
          <div className="space-y-4">
            {tuitionConfig.discounts.map((discount) => (
              <div key={discount.id} className="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                <div className="flex items-center">
                  <Award size={20} className="text-purple-500 mr-3" />
                  <div>
                    <p className="font-medium">{discount.name}</p>
                    <p className="text-sm text-gray-600">{discount.percentage}% off tuition</p>
                  </div>
                </div>
                <Button variant="outline" size="sm">Edit</Button>
              </div>
            ))}
            <Button variant="outline" fullWidth>
              <Plus size={16} className="mr-2" />
              Add Discount Program
            </Button>
          </div>
        </Card>
      </div>

      <Card title="Audit Log">
        <div className="space-y-4">
          <div className="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
            <div>
              <p className="font-medium">Tuition Rate Updated</p>
              <p className="text-sm text-gray-600">Changed by Admin (A001) on June 15, 2023</p>
            </div>
            <Button variant="ghost" size="sm">View Details</Button>
          </div>
          {/* Add more audit log entries */}
        </div>
      </Card>

      <div className="flex justify-end space-x-4">
        <Button variant="outline">Reset to Defaults</Button>
        <Button>Save Changes</Button>
      </div>
    </div>
  );
};

export default FinancialManagement;
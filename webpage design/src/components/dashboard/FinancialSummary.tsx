import React from 'react';
import Card from '../ui/Card';
import { DollarSign, ArrowDown, ArrowUp } from 'lucide-react';
import { financialRecords } from '../../data/mockData';

const FinancialSummary: React.FC = () => {
  // Calculate totals
  const totalCharges = financialRecords
    .filter(record => record.amount > 0)
    .reduce((sum, record) => sum + record.amount, 0);
    
  const totalCredits = financialRecords
    .filter(record => record.amount < 0)
    .reduce((sum, record) => sum + Math.abs(record.amount), 0);
    
  const balance = totalCharges - totalCredits;
  
  // Current semester's financial records
  const currentSemesterRecords = financialRecords.filter(
    record => record.semester === 'Spring' && record.year === 2023
  );
  
  return (
    <Card 
      title="Financial Summary" 
      subtitle="Current semester balance"
      actions={
        <a href="/financial" className="text-sm text-purple-600 hover:underline">
          Details
        </a>
      }
      className="h-full"
    >
      <div className="flex items-center justify-between mb-4">
        <div>
          <p className="text-sm text-gray-500">Current Balance</p>
          <h3 className={`text-2xl font-bold ${balance > 0 ? 'text-red-600' : 'text-green-600'}`}>
            ${Math.abs(balance).toLocaleString('en-US', { minimumFractionDigits: 2 })}
          </h3>
          <p className="text-xs text-gray-500 mt-1">
            {balance > 0 ? 'Amount Due' : 'Credit Balance'}
          </p>
        </div>
        
        <div className="flex space-x-4">
          <div className="text-center">
            <div className="flex items-center justify-center w-10 h-10 bg-red-100 rounded-full mb-1">
              <ArrowUp size={20} className="text-red-600" />
            </div>
            <p className="text-xs text-gray-500">Charges</p>
            <p className="text-sm font-semibold">${totalCharges.toLocaleString()}</p>
          </div>
          
          <div className="text-center">
            <div className="flex items-center justify-center w-10 h-10 bg-green-100 rounded-full mb-1">
              <ArrowDown size={20} className="text-green-600" />
            </div>
            <p className="text-xs text-gray-500">Credits</p>
            <p className="text-sm font-semibold">${totalCredits.toLocaleString()}</p>
          </div>
        </div>
      </div>
      
      <div className="mt-4 border-t border-gray-100 pt-4">
        <h4 className="text-sm font-medium text-gray-700 mb-2">Recent Transactions</h4>
        
        <div className="space-y-3">
          {currentSemesterRecords.slice(0, 3).map(record => (
            <div key={record.id} className="flex items-center justify-between">
              <div className="flex items-start">
                <div 
                  className={`p-2 rounded-full mr-3 ${
                    record.amount < 0 ? 'bg-green-100' : 'bg-red-100'
                  }`}
                >
                  <DollarSign 
                    size={16} 
                    className={record.amount < 0 ? 'text-green-600' : 'text-red-600'} 
                  />
                </div>
                <div>
                  <p className="text-sm font-medium text-gray-900">{record.type}</p>
                  <p className="text-xs text-gray-500">{record.description}</p>
                </div>
              </div>
              <div className={`text-sm font-semibold ${
                record.amount < 0 ? 'text-green-600' : 'text-red-600'
              }`}>
                {record.amount < 0 ? '-' : ''}${Math.abs(record.amount).toLocaleString()}
              </div>
            </div>
          ))}
        </div>
      </div>
    </Card>
  );
};

export default FinancialSummary;
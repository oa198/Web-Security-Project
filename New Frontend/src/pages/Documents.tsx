import React, { useState } from 'react';
import PageLayout from '../components/layout/PageLayout';
import Card from '../components/ui/Card';
import Button from '../components/ui/Button';
import { FileText, Download, Upload, Trash2 } from 'lucide-react';
import { documents } from '../data/mockData';

const Documents: React.FC = () => {
  const [filter, setFilter] = useState<'all' | 'transcripts' | 'forms' | 'certificates'>('all');

  const filteredDocuments = documents.filter(doc => {
    if (filter === 'all') return true;
    return doc.type.toLowerCase().includes(filter.slice(0, -1));
  });

  const getIcon = (type: string) => {
    switch (type.toLowerCase()) {
      case 'transcript':
        return <FileText size={20} className="text-blue-500" />;
      case 'form':
        return <FileText size={20} className="text-purple-500" />;
      case 'certificate':
        return <FileText size={20} className="text-green-500" />;
      default:
        return <FileText size={20} className="text-gray-500" />;
    }
  };

  return (
    <PageLayout title="Documents">
      <div className="space-y-6">
        {/* Header with upload button */}
        <div className="flex items-center justify-between">
          <div className="flex gap-2">
            <Button 
              variant={filter === 'all' ? 'primary' : 'ghost'}
              onClick={() => setFilter('all')}
            >
              All
            </Button>
            <Button 
              variant={filter === 'transcripts' ? 'primary' : 'ghost'}
              onClick={() => setFilter('transcripts')}
            >
              Transcripts
            </Button>
            <Button 
              variant={filter === 'forms' ? 'primary' : 'ghost'}
              onClick={() => setFilter('forms')}
            >
              Forms
            </Button>
            <Button 
              variant={filter === 'certificates' ? 'primary' : 'ghost'}
              onClick={() => setFilter('certificates')}
            >
              Certificates
            </Button>
          </div>
          <Button>
            <Upload size={16} className="mr-2" />
            Upload Document
          </Button>
        </div>

        {/* Documents Grid */}
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          {filteredDocuments.map((document) => (
            <Card key={document.id} hoverable>
              <div className="flex items-start gap-4">
                {getIcon(document.type)}
                <div className="flex-1">
                  <h3 className="font-medium text-gray-900">{document.name}</h3>
                  <p className="text-sm text-gray-500">{document.type}</p>
                  <div className="flex items-center gap-2 text-sm text-gray-500 mt-2">
                    <span>Uploaded: {new Date(document.uploadDate).toLocaleDateString()}</span>
                    <span>•</span>
                    <span>{document.size}</span>
                  </div>
                </div>
              </div>
              <div className="mt-4 pt-4 border-t border-gray-100 flex justify-end gap-2">
                <Button variant="ghost" size="sm">
                  <Trash2 size={16} className="text-red-500" />
                </Button>
                <Button variant="outline" size="sm">
                  <Download size={16} className="mr-2" />
                  Download
                </Button>
              </div>
            </Card>
          ))}
        </div>
      </div>
    </PageLayout>
  );
};

export default Documents;
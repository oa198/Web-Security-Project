<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Status Update</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header img {
            max-width: 200px;
            margin-bottom: 20px;
        }
        .content {
            background-color: #f9f9f9;
            padding: 25px;
            border-radius: 5px;
            border-left: 4px solid 
                {{ $status === 'approved' ? '#28a745' : ($status === 'rejected' ? '#dc3545' : '#17a2b8') }};
        }
        .status {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 15px;
            color: {{ $status === 'approved' ? '#28a745' : ($status === 'rejected' ? '#dc3545' : '#17a2b8') }};
        }
        .footer {
            margin-top: 30px;
            font-size: 12px;
            text-align: center;
            color: #777;
        }
        .button {
            display: inline-block;
            background-color: #5843D1;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 20px;
        }
        .details {
            margin: 20px 0;
            padding: 15px;
            background-color: #fff;
            border-radius: 4px;
            border: 1px solid #eee;
        }
        .details p {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>University Student Information System</h2>
    </div>
    
    <div class="content">
        <p>Dear {{ $user->name }},</p>
        
        <div class="status">
            Your application status has been updated to: {{ ucfirst($status) }}
        </div>
        
        @if($status === 'approved')
            <p>Congratulations! Your application to join our university has been approved. We are pleased to welcome you to our academic community.</p>
            
            <div class="details">
                <h3>Your Student Information</h3>
                <p><strong>Student ID:</strong> {{ $studentId }}</p>
                <p><strong>Admission Date:</strong> {{ $student->admission_date->format('F d, Y') }}</p>
                <p><strong>Expected Graduation:</strong> {{ $student->expected_graduation_date->format('F Y') }}</p>
            </div>
            
            <p>Please log in to your student account to view your complete profile, register for courses, and access our student resources.</p>
            
            <p><a href="{{ route('dashboard') }}" class="button">Access Your Student Account</a></p>
            
        @elseif($status === 'rejected')
            <p>We regret to inform you that your application has been declined at this time.</p>
            
            @if($rejectionReason)
                <div class="details">
                    <h3>Reason for Decision</h3>
                    <p>{{ $rejectionReason }}</p>
                </div>
            @endif
            
            <p>You may consider applying again in the future or contact our admissions office for more information about alternative programs that might be suitable for your qualifications.</p>
            
        @else
            <p>Your application is currently being reviewed by our admissions team. We will notify you once a decision has been made.</p>
        @endif
        
        @if($notes)
            <div class="details">
                <h3>Additional Notes</h3>
                <p>{{ $notes }}</p>
            </div>
        @endif
        
        <p>If you have any questions, please don't hesitate to contact our admissions office at <a href="mailto:admissions@university.edu">admissions@university.edu</a> or call us at (555) 123-4567.</p>
    </div>
    
    <div class="footer">
        <p>This is an automated message from the University Student Information System.</p>
        <p>&copy; {{ date('Y') }} University. All rights reserved.</p>
    </div>
</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            width: 30%;
            font-weight: bold;
        }
        .section-title {
            font-weight: bold;
            margin-top: 20px;
            margin-bottom: 10px;
            color: #333;
        }
    </style>
</head>
<body>
    <h2>Student Details</h2>
    
    @foreach($students as $student)
    <div class="section-title">Basic Information</div>
    <table>
        <tr>
            <th>Student ID</th>
            <td>{{ $student->id }}</td>
        </tr>
        <tr>
            <th>Full Name</th>
            <td>{{ $student->full_name }}</td>
        </tr>
        <tr>
            <th>Email</th>
            <td>{{ $student->email }}</td>
        </tr>
        <tr>
            <th>Contact Number</th>
            <td>{{ $student->contact_number }}</td>
        </tr>
        <tr>
            <th>WhatsApp Number</th>
            <td>{{ $student->whatsapp_number }}</td>
        </tr>
        <tr>
            <th>Date of Birth</th>
            <td>{{ $student->date_of_birth ? $student->date_of_birth->format('d/m/Y') : 'N/A' }}</td>
        </tr>
        <tr>
            <th>Gender</th>
            <td>{{ $student->gender }}</td>
        </tr>
    </table>

    <div class="section-title">Address Information</div>
    <table>
        <tr>
            <th>College Name</th>
            <td>{{ $student->college_name }}</td>
        </tr>
        <tr>
            <th>College Address</th>
            <td>{{ $student->college_address }}</td>
        </tr>
    </table>

    <div class="section-title">Course Information</div>
    <table>
        <tr>
            <th>Course Enrolled</th>
            <td>{{ $student->course_enrolled }}</td>
        </tr>
        <tr>
            <th>Batch No</th>
            <td>{{ $student->batch_no }}</td>
        </tr>
        <tr>
            <th>Batch Timings</th>
            <td>{{ $student->batch_timings }}</td>
        </tr>
        <tr>
            <th>Faculty Name</th>
            <td>{{ $student->faculty_name }}</td>
        </tr>
        <tr>
            <th>Enrollment Date</th>
            <td>{{ $student->enrollment_date ? $student->enrollment_date->format('d/m/Y') : 'N/A' }}</td>
        </tr>
        <tr>
            <th>ID Proof Type</th>
            <td>{{ $student->id_proof_type }}</td>
        </tr>
        <tr>
            <th>ID Proof Number</th>
            <td>{{ $student->id_proof_number }}</td>
        </tr>
        <tr>
            <th>Qualification</th>
            <td>{{ $student->qualification }}</td>
        </tr>
        <tr>
            <th>Is Pursuing</th>
            <td>{{ $student->is_pursuing ? 'Yes' : 'No' }}</td>
        </tr>
        <tr>
            <th>Looking for Job</th>
            <td>{{ $student->looking_for_job ? 'Yes' : 'No' }}</td>
        </tr>
    </table>

    @if(!$loop->last)
    <div style="page-break-after: always;"></div>
    @endif
    @endforeach
</body>
</html>

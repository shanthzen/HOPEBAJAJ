<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Students Export</title>
    <style>
        @page {
            size: portrait;
            margin: 15mm;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #333;
        }
        .header h1 {
            color: #333;
            margin-bottom: 5px;
            font-size: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            font-size: 11px;
        }
        th {
            background-color: #f5f5f5;
            font-weight: bold;
            color: #333;
        }
        tr:nth-child(even) {
            background-color: #fafafa;
        }
        .footer {
            text-align: right;
            font-size: 11px;
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>HOPE Foundation - Student Records</h1>
        <p>Generated on: {{ now()->format('d-m-Y H:i:s') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Sl No</th>
                <th>Batch No</th>
                <th>Full Name</th>
                <th>Contact Number</th>
                <th>Course Enrolled</th>
                <th>College Name</th>
                <th>Enrollment Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $student)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $student->batch_no }}</td>
                <td>{{ $student->full_name }}</td>
                <td>{{ $student->contact_number }}</td>
                <td>{{ $student->course_enrolled }}</td>
                <td>{{ $student->college_name }}</td>
                <td>{{ optional($student->enrollment_date)->format('d/m/Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Total Students: {{ $students->count() }}</p>
    </div>
</body>
</html>

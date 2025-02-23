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
    <h2>Placement Details</h2>
    
    @foreach($placements as $placement)
    <div class="section-title">Basic Information</div>
    <table>
        <tr>
            <th>Batch No</th>
            <td>{{ $placement->batch_no }}</td>
        </tr>
        <tr>
            <th>Name</th>
            <td>{{ $placement->name }}</td>
        </tr>
        <tr>
            <th>Phone Number</th>
            <td>{{ $placement->phone_number }}</td>
        </tr>
    </table>

    <div class="section-title">Placement Information</div>
    <table>
        <tr>
            <th>Company Name</th>
            <td>{{ $placement->company_name }}</td>
        </tr>
        <tr>
            <th>Designation</th>
            <td>{{ $placement->designation }}</td>
        </tr>
        <tr>
            <th>Salary</th>
            <td>{{ number_format($placement->salary, 2) }}</td>
        </tr>
    </table>
    @endforeach

    <div class="footer">
        Generated on {{ date('Y-m-d H:i:s') }} | HOPE Foundation
    </div>
</body>
</html>

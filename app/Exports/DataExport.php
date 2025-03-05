<?php

namespace App\Exports;

use App\Models\Graduate;
use App\Models\PlacedStudent;
use App\Models\EnrolledStudent;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Database\Eloquent\Builder;

class DataExport implements FromQuery, WithHeadings, WithMapping
{
    protected $type;

    public function __construct($type)
    {
        $this->type = $type;
    }

    public function query()
    {
        switch ($this->type) {
            case 'students':
                return EnrolledStudent::query();
            case 'graduates':
                return Graduate::query();
            case 'placements':
                return PlacedStudent::query();
            default:
                throw new \Exception("Invalid export type");
        }
    }

    public function map($row): array
    {
        switch ($this->type) {
            case 'students':
                return [
                    $row->batch_no,
                    $row->full_name,
                    $row->contact_number,
                    $row->gender,
                    $row->date_of_birth ? $row->date_of_birth->format('d/m/Y') : 'N/A',
                    $row->college_address,
                    $row->course_enrolled,
                    $row->enrollment_date ? $row->enrollment_date->format('d/m/Y') : 'N/A',
                    $row->id_proof_type,
                    $row->id_proof_number
                ];
            case 'graduates':
                return [
                    $row->batch_no,
                    $row->certificate_no,
                    $row->name,
                    $row->phone_number,
                    $row->course_name,
                    $row->course_duration,
                    $row->start_date ? $row->start_date->format('d/m/Y') : 'N/A',
                    $row->end_date ? $row->end_date->format('d/m/Y') : 'N/A',
                    $row->total_days_attended . ' days',
                    $row->id_proof_type,
                    $row->id_proof_number
                ];
            case 'placements':
                return [
                    $row->batch_no,
                    $row->name,
                    $row->phone_number,
                    $row->company_name,
                    $row->designation,
                    number_format($row->salary, 2)
                ];
            default:
                throw new \Exception("Invalid export type");
        }
    }

    public function headings(): array
    {
        switch ($this->type) {
            case 'students':
                return [
                    'Batch No', 'Full Name', 'Contact Number', 'Gender',
                    'Date of Birth', 'College Address', 'Course Enrolled',
                    'Enrollment Date', 'ID Type', 'ID Number'
                ];
            case 'graduates':
                return [
                    'Batch No', 'Certificate No', 'Full Name', 'Phone Number',
                    'Course Name', 'Course Duration', 'Start Date', 'End Date',
                    'Total Days Attended', 'ID Type', 'ID Number'
                ];
            case 'placements':
                return [
                    'Batch No', 'Name', 'Phone Number',
                    'Company Name', 'Designation', 'Salary'
                ];
            default:
                throw new \Exception("Invalid export type");
        }
    }
}

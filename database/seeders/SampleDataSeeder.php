<?php

namespace Database\Seeders;

use App\Models\Batch;
use App\Models\EnrolledStudent;
use App\Models\Graduate;
use App\Models\PlacedStudent;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SampleDataSeeder extends Seeder
{
    public function run(): void
    {
        // Create batches
        $batch1 = Batch::create([
            'batch_name' => 'Web Development Batch 1',
            'batch_code' => 'WD-2025-01',
            'start_date' => '2025-01-01',
            'end_date' => '2025-06-30',
            'start_time' => '09:00:00',
            'end_time' => '12:00:00',
            'faculty_name' => 'John Doe',
            'max_students' => 30,
            'status' => 'active'
        ]);

        $batch2 = Batch::create([
            'batch_name' => 'Digital Marketing Batch 1',
            'batch_code' => 'DM-2025-01',
            'start_date' => '2025-02-01',
            'end_date' => '2025-07-31',
            'start_time' => '14:00:00',
            'end_time' => '17:00:00',
            'faculty_name' => 'Jane Smith',
            'max_students' => 25,
            'status' => 'active'
        ]);

        // Create enrolled students
        for ($i = 1; $i <= 10; $i++) {
            $student = EnrolledStudent::create([
                'name' => "Student $i",
                'full_name' => "Student Full Name $i",
                'email' => "student$i@example.com",
                'contact_number' => "123456789$i",
                'whatsapp_number' => "987654321$i",
                'batch_id' => $i <= 5 ? $batch1->id : $batch2->id,
                'batch_no' => $i <= 5 ? 'WD-2025-01' : 'DM-2025-01',
                'batch_timings' => $i <= 5 ? '09:00:00' : '14:00:00',
                'faculty_name' => $i <= 5 ? 'John Doe' : 'Jane Smith',
                'enrollment_date' => Carbon::now()->subDays(rand(1, 30)),
                'course_enrolled' => $i <= 5 ? 'Web Development' : 'Digital Marketing',
                'status' => 'active',
                'id_proof_type' => 'Aadhar',
                'id_proof_number' => "1234567890$i",
                'date_of_birth' => '2000-01-01',
                'gender' => $i % 2 == 0 ? 'Male' : 'Female',
                'qualification' => 'Bachelor\'s Degree',
                'college_name' => 'Sample College',
                'college_address' => 'Sample Address',
                'looking_for_job' => true
            ]);

            // Create graduates and placements for some students
            if ($i <= 3) {
                $graduate = Graduate::create([
                    'student_id' => $student->id,
                    'name' => $student->name,
                    'email' => $student->email,
                    'contact_number' => $student->contact_number,
                    'course_completed' => $student->course_enrolled,
                    'batch_no' => $student->batch_no,
                    'graduation_date' => Carbon::now()->subDays(rand(1, 15)),
                    'grade' => ['A', 'B', 'A+'][rand(0, 2)],
                    'certificate_no' => "CERT$i",
                    'status' => 'active'
                ]);

                if ($i <= 2) {
                    PlacedStudent::create([
                        'graduate_id' => $graduate->id,
                        'name' => $graduate->name,
                        'email' => $graduate->email,
                        'contact_number' => $graduate->contact_number,
                        'company_name' => ['TCS', 'Infosys', 'Wipro'][rand(0, 2)],
                        'designation' => ['Software Engineer', 'Web Developer', 'Digital Marketing Specialist'][rand(0, 2)],
                        'salary' => rand(300000, 600000),
                        'joining_date' => Carbon::now()->addDays(rand(1, 30)),
                        'status' => 'active'
                    ]);
                }
            }
        }
    }
}

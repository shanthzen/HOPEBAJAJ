<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EnrolledStudent;
use Illuminate\Support\Facades\DB;

class ConvertStudentIdsSeeder extends Seeder
{
    public function run()
    {
        // Get all students with email-based IDs
        $students = EnrolledStudent::where('student_user_id', 'LIKE', '%@%')->get();
        
        foreach ($students as $student) {
            // Convert email to plain text ID by removing domain
            $plainId = strtok($student->student_user_id, '@');
            
            // Update the record
            DB::table('enrolled_students')
                ->where('id', $student->id)
                ->update(['student_user_id' => $plainId]);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Donor;

class DonorSeeder extends Seeder
{
    public function run(): void
    {
        Donor::create([
            'name' => 'Bajaj Finserv',
            'description' => 'Bajaj Finserv is the holding company for the various financial services businesses under the Bajaj group. It is one of India\'s leading and most diversified financial services companies.',
            'contributions' => 'Providing financial support and resources for student education and skill development programs.',
            'impact' => 'Has helped numerous students achieve their educational goals through scholarships and financial assistance.',
            'contact_email' => 'support@bajajfinserv.in',
            'contact_phone' => '02067490000',
            'website' => 'www.bajajfinserv.in'
        ]);
    }
}

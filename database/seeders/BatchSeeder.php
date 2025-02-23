<?php

namespace Database\Seeders;

use App\Models\Batch;
use Illuminate\Database\Seeder;

class BatchSeeder extends Seeder
{
    public function run()
    {
        $batches = [
            ['batch_no' => 'Batch 1'],
            ['batch_no' => 'Batch 2'],
            ['batch_no' => 'Batch 3'],
        ];

        foreach ($batches as $batch) {
            Batch::create($batch);
        }
    }
}

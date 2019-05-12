<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DocumentDepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('document_department')->insert([
            'document_id' => 1,
            'department_id' => 1,
            'sending_date' => Carbon::now(),
        ]);
        DB::table('document_department')->insert([
            'document_id' => 1,
            'department_id' => 2,
            'sending_date' => Carbon::now(),
        ]);
    }
}

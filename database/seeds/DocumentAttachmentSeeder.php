<?php

use Illuminate\Database\Seeder;

class DocumentAttachmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('document_attachments')->insert([
            'document_id' => 1,
            'name' => 'file_1'
        ]);
        DB::table('document_attachments')->insert([
            'document_id' => 1,
            'name' => 'file_2'
        ]);
    }
}

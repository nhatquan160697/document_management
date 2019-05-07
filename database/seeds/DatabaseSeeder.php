<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(DepartmentSeeder::class);
        $this->call(PositionSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(DepartmentUserSeeder::class);
        $this->call(CollaborationUnitSeeder::class);
        $this->call(DocumentTypeSeeder::class);
        $this->call(DocumentSeeder::class);
        $this->call(DocumentUserSeeder::class);
        $this->call(DocumentDepartmentSeeder::class);
        $this->call(MessageSeeder::class);
        $this->call(DocumentAttachmentSeeder::class);
    }
}

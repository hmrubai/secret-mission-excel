<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProjectTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::create(2026, 1, 22, 11, 45, 30);

        DB::table('project_types')->insert([
            [
                'name' => 'Web Application Development',
                'is_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Mobile App Development',
                'is_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'SaaS Platform Development',
                'is_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'API Development & Integration',
                'is_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'UI/UX Design',
                'is_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'E-commerce Website Development',
                'is_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'ERP Implementation',
                'is_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'CRM Setup & Customization',
                'is_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Digital Marketing Campaign',
                'is_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'System Maintenance & Support',
                'is_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}

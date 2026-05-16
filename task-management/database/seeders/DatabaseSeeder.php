<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::factory()->create([
            'name'     => 'Admin User',
            'email'    => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);

        Task::factory()->create([
            'user_id'     => $admin->id,
            'title'       => 'تصميم واجهة المستخدم',
            'description' => 'تصميم لوحة التحكم الرئيسية مع جميع المكونات اللازمة.',
            'status'      => 'completed',
            'priority'    => 'high',
            'due_date'    => now()->subDays(2)->format('Y-m-d'),
        ]);

        Task::factory()->create([
            'user_id'     => $admin->id,
            'title'       => 'تطوير API للمهام',
            'description' => 'بناء RESTful API لإدارة المهام مع التوثيق الكامل.',
            'status'      => 'in_progress',
            'priority'    => 'high',
            'due_date'    => now()->addDays(5)->format('Y-m-d'),
        ]);

        Task::factory()->create([
            'user_id'     => $admin->id,
            'title'       => 'كتابة الاختبارات',
            'description' => 'كتابة Unit Tests و Feature Tests لجميع الميزات.',
            'status'      => 'pending',
            'priority'    => 'medium',
            'due_date'    => now()->addDays(10)->format('Y-m-d'),
        ]);

        Task::factory()->create([
            'user_id'     => $admin->id,
            'title'       => 'مراجعة الكود',
            'description' => 'مراجعة الكود مع الفريق وإصلاح أي مشاكل.',
            'status'      => 'pending',
            'priority'    => 'low',
            'due_date'    => now()->addDays(15)->format('Y-m-d'),
        ]);

        Task::factory()->create([
            'user_id'     => $admin->id,
            'title'       => 'نشر المشروع',
            'description' => 'نشر المشروع على الخادم الإنتاجي.',
            'status'      => 'pending',
            'priority'    => 'high',
            'due_date'    => now()->addDays(20)->format('Y-m-d'),
        ]);

        $user2 = User::factory()->create([
            'name'     => 'John Doe',
            'email'    => 'john@example.com',
            'password' => Hash::make('password'),
        ]);

        Task::factory(8)->create(['user_id' => $user2->id]);
    }
}

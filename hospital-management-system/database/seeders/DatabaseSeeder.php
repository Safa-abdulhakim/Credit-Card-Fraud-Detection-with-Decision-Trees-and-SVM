<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\Patient;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder {
    public function run(): void {
        // Create roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $doctorRole = Role::firstOrCreate(['name' => 'doctor']);
        $receptionistRole = Role::firstOrCreate(['name' => 'receptionist']);
        $patientRole = Role::firstOrCreate(['name' => 'patient']);

        // Create admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@hospital.com'],
            ['name' => 'Admin User', 'password' => Hash::make('password'), 'email_verified_at' => now()]
        );
        $admin->assignRole('admin');

        // Create receptionist user
        $receptionist = User::firstOrCreate(
            ['email' => 'receptionist@hospital.com'],
            ['name' => 'Jane Smith', 'password' => Hash::make('password'), 'email_verified_at' => now()]
        );
        $receptionist->assignRole('receptionist');

        // Create departments
        $departments = [
            ['name' => 'Cardiology', 'description' => 'Heart and cardiovascular diseases'],
            ['name' => 'Neurology', 'description' => 'Brain and nervous system disorders'],
            ['name' => 'Orthopedics', 'description' => 'Bone and joint conditions'],
            ['name' => 'Pediatrics', 'description' => 'Children medical care'],
            ['name' => 'Dermatology', 'description' => 'Skin conditions and diseases'],
            ['name' => 'General Medicine', 'description' => 'General health and wellness'],
        ];

        foreach ($departments as $dept) {
            Department::firstOrCreate(['name' => $dept['name']], $dept);
        }

        // Create doctor users
        $doctorsData = [
            ['name' => 'Dr. John Wilson', 'email' => 'doctor1@hospital.com', 'spec' => 'Cardiologist', 'dept' => 'Cardiology', 'exp' => 10, 'fee' => 150.00],
            ['name' => 'Dr. Sarah Johnson', 'email' => 'doctor2@hospital.com', 'spec' => 'Neurologist', 'dept' => 'Neurology', 'exp' => 8, 'fee' => 120.00],
            ['name' => 'Dr. Michael Chen', 'email' => 'doctor3@hospital.com', 'spec' => 'Orthopedic Surgeon', 'dept' => 'Orthopedics', 'exp' => 12, 'fee' => 180.00],
            ['name' => 'Dr. Emily Davis', 'email' => 'doctor4@hospital.com', 'spec' => 'Pediatrician', 'dept' => 'Pediatrics', 'exp' => 6, 'fee' => 100.00],
        ];

        foreach ($doctorsData as $d) {
            $user = User::firstOrCreate(
                ['email' => $d['email']],
                ['name' => $d['name'], 'password' => Hash::make('password'), 'email_verified_at' => now()]
            );
            $user->assignRole('doctor');
            $dept = Department::where('name', $d['dept'])->first();
            Doctor::firstOrCreate(['user_id' => $user->id], [
                'department_id' => $dept->id,
                'specialization' => $d['spec'],
                'experience_years' => $d['exp'],
                'consultation_fee' => $d['fee'],
                'phone' => '555-' . rand(1000, 9999),
            ]);
        }

        // Create patient users and profiles
        $patientsData = [
            ['name' => 'Alice Brown', 'email' => 'patient1@hospital.com', 'dob' => '1985-03-15', 'gender' => 'female', 'phone' => '555-1001', 'blood' => 'A+'],
            ['name' => 'Bob Martin', 'email' => 'patient2@hospital.com', 'dob' => '1990-07-22', 'gender' => 'male', 'phone' => '555-1002', 'blood' => 'O+'],
            ['name' => 'Carol White', 'email' => 'patient3@hospital.com', 'dob' => '1978-11-08', 'gender' => 'female', 'phone' => '555-1003', 'blood' => 'B-'],
            ['name' => 'David Lee', 'email' => 'patient4@hospital.com', 'dob' => '2000-01-30', 'gender' => 'male', 'phone' => '555-1004', 'blood' => 'AB+'],
            ['name' => 'Emma Wilson', 'email' => 'patient5@hospital.com', 'dob' => '1995-06-12', 'gender' => 'female', 'phone' => '555-1005', 'blood' => 'O-'],
        ];

        foreach ($patientsData as $p) {
            $user = User::firstOrCreate(
                ['email' => $p['email']],
                ['name' => $p['name'], 'password' => Hash::make('password'), 'email_verified_at' => now()]
            );
            $user->assignRole('patient');
            Patient::firstOrCreate(['email' => $p['email']], [
                'user_id' => $user->id,
                'name' => $p['name'],
                'date_of_birth' => $p['dob'],
                'gender' => $p['gender'],
                'phone' => $p['phone'],
                'blood_group' => $p['blood'],
                'address' => '123 Main St, City',
            ]);
        }

        $this->command->info('Hospital Management System seeded successfully!');
    }
}

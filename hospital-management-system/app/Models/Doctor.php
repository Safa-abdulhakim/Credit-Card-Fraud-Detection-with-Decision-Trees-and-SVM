<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model {
    use HasFactory;

    protected $fillable = [
        'user_id', 'department_id', 'specialization', 'experience_years',
        'phone', 'photo', 'bio', 'consultation_fee', 'is_available'
    ];

    protected $casts = ['is_available' => 'boolean', 'consultation_fee' => 'decimal:2'];

    public function user() { return $this->belongsTo(User::class); }
    public function department() { return $this->belongsTo(Department::class); }
    public function appointments() { return $this->hasMany(Appointment::class); }
    public function medicalRecords() { return $this->hasMany(MedicalRecord::class); }
    public function prescriptions() { return $this->hasMany(Prescription::class); }

    public function getFullNameAttribute() { return $this->user->name ?? 'N/A'; }

    public function getPhotoUrlAttribute() {
        return $this->photo ? asset('storage/' . $this->photo) : asset('images/default-doctor.png');
    }

    public function todayAppointments() {
        return $this->appointments()->whereDate('appointment_date', today());
    }
}

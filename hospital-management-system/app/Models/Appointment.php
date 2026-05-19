<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model {
    use HasFactory;

    protected $fillable = [
        'patient_id', 'doctor_id', 'appointment_date', 'appointment_time',
        'status', 'symptoms', 'notes', 'type'
    ];

    protected $casts = ['appointment_date' => 'date'];

    public function patient() { return $this->belongsTo(Patient::class); }
    public function doctor() { return $this->belongsTo(Doctor::class); }
    public function medicalRecord() { return $this->hasOne(MedicalRecord::class); }
    public function invoice() { return $this->hasOne(Invoice::class); }

    public function scopePending($query) { return $query->where('status', 'pending'); }
    public function scopeApproved($query) { return $query->where('status', 'approved'); }
    public function scopeCompleted($query) { return $query->where('status', 'completed'); }
    public function scopeToday($query) { return $query->whereDate('appointment_date', today()); }

    public function getStatusBadgeAttribute() {
        return match($this->status) {
            'pending' => 'warning',
            'approved' => 'info',
            'completed' => 'success',
            'cancelled' => 'danger',
            default => 'secondary'
        };
    }
}

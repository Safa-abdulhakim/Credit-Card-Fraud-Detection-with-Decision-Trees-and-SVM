<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Patient extends Model {
    use HasFactory;

    protected $fillable = [
        'user_id', 'name', 'date_of_birth', 'gender', 'phone', 'email',
        'address', 'blood_group', 'allergies', 'medical_history', 'emergency_contact'
    ];

    protected $casts = ['date_of_birth' => 'date'];

    public function user() { return $this->belongsTo(User::class); }
    public function appointments() { return $this->hasMany(Appointment::class); }
    public function medicalRecords() { return $this->hasMany(MedicalRecord::class); }
    public function prescriptions() { return $this->hasMany(Prescription::class); }
    public function invoices() { return $this->hasMany(Invoice::class); }

    public function getAgeAttribute() {
        return Carbon::parse($this->date_of_birth)->age;
    }

    public function pendingInvoices() {
        return $this->invoices()->whereIn('status', ['unpaid', 'partial']);
    }
}

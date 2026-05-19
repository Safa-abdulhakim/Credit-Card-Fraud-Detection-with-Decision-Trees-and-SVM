<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model {
    use HasFactory;

    protected $fillable = [
        'invoice_number', 'patient_id', 'appointment_id', 'consultation_fee',
        'medicine_fee', 'test_fee', 'other_fee', 'total_amount', 'discount',
        'paid_amount', 'status', 'notes', 'due_date'
    ];

    protected $casts = [
        'due_date' => 'date',
        'total_amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'discount' => 'decimal:2',
    ];

    public function patient() { return $this->belongsTo(Patient::class); }
    public function appointment() { return $this->belongsTo(Appointment::class); }
    public function payments() { return $this->hasMany(Payment::class); }

    public function getRemainingAmountAttribute() {
        return $this->total_amount - $this->paid_amount;
    }

    public function getStatusBadgeAttribute() {
        return match($this->status) {
            'paid' => 'success',
            'partial' => 'warning',
            'unpaid' => 'danger',
            default => 'secondary'
        };
    }

    public static function generateInvoiceNumber() {
        $latest = static::latest()->first();
        $number = $latest ? intval(substr($latest->invoice_number, 4)) + 1 : 1;
        return 'INV-' . str_pad($number, 6, '0', STR_PAD_LEFT);
    }
}

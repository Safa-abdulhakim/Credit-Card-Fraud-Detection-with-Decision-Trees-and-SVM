<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model {
    use HasFactory;

    protected $fillable = ['name', 'description', 'head_doctor', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];

    public function doctors() {
        return $this->hasMany(Doctor::class);
    }

    public function activeDoctors() {
        return $this->hasMany(Doctor::class)->where('is_available', true);
    }
}

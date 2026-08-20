<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'email',
        'password',
        'telephone',
    ];

    protected $hidden = [
        'password',
    ];

    /**
     * Un patient a plusieurs rendez-vous
     */
    public function rendezVouses()
    {
        return $this->hasMany(Rendezvous::class, 'patient_id');
    }
}
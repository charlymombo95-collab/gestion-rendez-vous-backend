<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medecin extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'specialite',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    /**
     * Un médecin a plusieurs rendez-vous
     */
    public function rendezVouses()
    {
        return $this->hasMany(Rendezvous::class, 'medecin_id');
    }
}

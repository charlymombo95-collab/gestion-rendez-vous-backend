<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medecin extends Model
{
    protected $fillable = ['nom', 'specialite', 'email', 'password'];
    protected $hidden = ['password'];

    public function rendezVous()
    {
        return $this->hasMany(Rendezvous::class);
    }
}
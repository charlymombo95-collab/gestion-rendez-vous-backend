<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = ['nom', 'email', 'password', 'telephone'];
    protected $hidden = ['password'];

    public function rendezVous()
    {
        return $this->hasMany(Rendezvous::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    use HasFactory;

    /**
     * Les champs autorisés pour l'insertion / modification.
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Définition de la relation : 
     * Un rôle peut avoir plusieurs utilisateurs.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}


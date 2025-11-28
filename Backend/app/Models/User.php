<?php

namespace App\Models;

// N'oubliez pas d'importer le modèle Role pour la relation
use App\Models\Role; 

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     * C'est ici que 'role_id' doit être ajouté.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id', // ⬅️ AJOUTÉ POUR L'ASSIGNATION EN MASSE
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Définit la relation One-to-One (Inverse) entre User et Role.
     * Chaque utilisateur appartient à un seul rôle.
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }
}
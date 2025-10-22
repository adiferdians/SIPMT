<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class Anggota extends Authenticatable
{
    use HasFactory;
    use HasApiTokens, Notifiable;
    protected $table = 'anggotas';
}

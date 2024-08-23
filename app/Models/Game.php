<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Game extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $guarded = [];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function scores()
    {
        return $this->hasMany(Score::class);
    }
}

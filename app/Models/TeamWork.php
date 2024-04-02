<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamWork extends Model
{
    use HasFactory;
    protected $table = 'team_works';
    protected $fillable = ['image','nom','role'];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteWeb extends Model
{
    use HasFactory;
    protected $table = 'site_webs';
    protected $fillable = ['image','lien'];
}

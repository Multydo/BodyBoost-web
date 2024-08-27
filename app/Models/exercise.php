<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class exercise extends Model
{
    protected $fillable = [
        'id', 'name', 'body_part', 'equipment', 'target', 'secondary_muscles', 'instructions', 'gif_url',
    ]; use HasFactory;
}
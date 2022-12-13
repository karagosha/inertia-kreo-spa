<?php

namespace App\Models;

use App\Traits\IsPublic;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory, IsPublic;

    protected $fillable = ['title', 'description', 'salary', 'hh_link', 'is_public', 'weight'];
}

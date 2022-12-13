<?php

namespace App\Models;

use App\Traits\IsPublic;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory, IsPublic;

    protected $fillable = ['title', 'content', 'is_public', 'html_block', 'slug', 'weight'];
}

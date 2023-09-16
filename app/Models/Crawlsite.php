<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Tags\HasTags;

class Crawlsite extends Model
{
    use HasFactory;
    use HasTags;

    protected $fillable = [
        'url',
    ];
}

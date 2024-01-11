<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class Article extends Model
{
    use HasFactory;
    use HasUlids;

    protected $fillable = [
        'url',
        'crawlsite_id',
    ];

    public function crawlsite()
    {
        return $this->belongsTo(Crawlsite::class);
    }
}

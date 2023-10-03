<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CrawlerJobRun extends Model
{
    use HasFactory;

    protected $fillable = [
        'crawlsite_id',
        'output',
    ];

    public function crawlsite()
    {
        return $this->belongsTo(Crawlsite::class);
    }
}

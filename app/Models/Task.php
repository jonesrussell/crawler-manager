<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Task extends Model
{
   use HasFactory, HasUuids;

   protected $casts = [
       'task_id' => 'string',
       'user_id' => 'string',
       'crawlsite_id' => 'string',
   ];

   public function crawlsite()
   {
       return $this->belongsTo(Crawlsite::class);
   }
}
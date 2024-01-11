<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class Crawlsite extends Model
{
   use HasFactory;
   use HasUlids;

   protected $fillable = [
      'title',
      'url',
      'searchTerms',
   ];

   public function tasks()
   {
      return $this->hasMany(Task::class);
   }

   public function articles()
   {
      return $this->hasMany(Article::class);
   }
}

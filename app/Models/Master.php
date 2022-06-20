<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Master extends Model
{
   protected $fillable=[
       'user_id',
       'name',
       'antecedent',
       'field',
       'image',
   ];

   public function user()
   {
       return $this->belongsTo(User::class);
   }
}

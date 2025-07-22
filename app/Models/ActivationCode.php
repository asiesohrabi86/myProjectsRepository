<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class ActivationCode extends Model
{
    protected $fillable=[
        'user_id',
        'code',
        'expired_at'
    ];

    public $timestamps=false;
    protected $table= 'activation_code';


    public function scopeGenerateCode($query, $user)
    {
        // if($code= $this->getAliveCodeForUser($user))
        // {
        //     $code= $code->code;
        // }
        // else{
            $user->activationCode()->delete();
            do{
                $code=mt_rand(100000,999999);
            }while($this->checkCodeIsUnuique($user,$code));

            $user->activationCode()->create([
                'code'=> $code,
                'expired_at'=> now()->addMinute(10),
            ]);

            return $code;

        // }
        
    }


    private function checkCodeIsUnuique($user,$code)
    {
        return !! $user->activationCode()->whereCode($code)->first();
    }

    private function getAliveCodeForUser($user)
    {
        return $user->activationCode()->where('expired_at' , '>' , now())->first();
    }


   public function scopeVerifyCode($query,$code,$user)
   {
      return !! $user->activationCode()->whereCode($code)->where('expired_at' , '>' , now())->first();
   }



    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

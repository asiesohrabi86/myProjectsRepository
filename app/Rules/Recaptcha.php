<?php

namespace App\Rules;

use Exception;
use GuzzleHttp\Client;
use Illuminate\Contracts\Validation\Rule;

class Recaptcha implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        try{

            $client = new Client();
            $response = $client->request('post' , 'https://www.google.com/recaptcha/api/siteverify' , [
                'form_params' => [
                'secret' => '6Ldby5ogAAAAALcTfY0cTG5_cMuZLtB0axItN5fH',
                'response' => $value,
                'remoteip' => request()->ip(),
                ]
            ]);
        }catch(Exception $exception){

        }

        $response = json_decode($response->getBody());
        return $response->success;

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'شما به عنوان ربات شناخته شدید.';
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use AfricasTalking\SDK\AfricasTalking;

class Token extends Model
{
    //https://github.com/sitepoint-editors/laravel-twilio-2fa/blob/master/routes/web.php
    const  EXPIRATION_TIME=15;//15 minutes
    protected $fillable=['code','user_id','used'];


    public function __construct(array $attributes = [])
    {
        if (! isset($attributes['code'])) {
            $attributes['code'] = $this->generateCode();
        }

        parent::__construct($attributes);
    }

    /**
     * Generate a six digits code
     *
     * @param int $codeLength
     * @return string
     */
    public function generateCode($codeLength = 4)
    {
        $min = pow(10, $codeLength);
        $max = $min * 10 - 1;
        $code = mt_rand($min, $max);

        return $code;
    }

    /**
     * User tokens relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * True if the token is not used nor expired
     *
     * @return bool
     */
    public function isValid()
    {
        return ! $this->isUsed() && ! $this->isExpired();
    }

    /**
     * Is the current token used
     *
     * @return bool
     */
    public function isUsed()
    {
        return $this->used;
    }

    /**
     * Is the current token expired
     *
     * @return bool
     */
    public function isExpired()
    {
        return $this->created_at->diffInMinutes(Carbon::now()) > static::EXPIRATION_TIME;
    }

    public function sendCode()
    {
        if (! $this->user) {
            throw new \Exception("No user attached to this token.");
        }
        if (! $this->code) {
            $this->code = $this->generateCode();
        }
        try {
            //TODO send SMS here
            $username = env('SMS_USER');
            $apiKey   = env('SMS_KEY');// use your sandbox app API key for development in the test environment
            $AT       = new AfricasTalking($username, $apiKey);

            $sms      = $AT->sms();
            $result   = $sms->send([
                'to'      => $this->user->getPhoneNumber(),
                'message' => "Your verification code is $this->code",
            ]);
            //dd($result);
        } catch (\Exception $ex) {
            //dd($ex);
            return false; //unable to send SMS
        }
        return true;
    }

}

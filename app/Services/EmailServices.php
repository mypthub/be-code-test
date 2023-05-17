<?php

declare(strict_types=1);

namespace App\Services;

use App\Organisation;
use Carbon\Carbon;
use Mail;
/**
 * Class EmailServices
 * @package App\Services
 */
class EmailServices
{
    /**
     * @param array $attributes
     *
     * @return Email
     */
    public function sendEmail(int $organisation_id)
    {
        // dd($organisation_id);
        $organisation_details= Organisation::with('owner')->where('id',$organisation_id)->first();
      //  dd($organisation_details->owner->email);
        return Mail::send([], [], function ($message) use ($organisation_details) {
            $message ->from('vishal@gmail.com', 'Vinap Team');
            $message->to($organisation_details->owner->email)
              ->subject('Organisation created successfully')
              ->setBody('Hi, welcome'.$organisation_details->owner->email.'!, <br/> '.$organisation_details->name.' is created successfully, Trail pariod is '.$organisation_details->trail_period, 'text/html'); // for HTML rich messages
          });

    }

    /**
     * @param array $attributes
     *
     * @return Email
     */
    public function sendQueueEmail(int $organisation_id)
    {
       
        $organisation_details= Organisation::with('owner')->where('id',$organisation_id)->first();

        return Mail::queue([], [], function ($message) {
            $message->to($organisation_details->owner->email)
              ->subject('Organisation created successfully')
              ->setBody('Hi, welcome'.$organisation_details->owner->email.'!, <br/> '.$organisation_details->name.' is created successfully, Trail pariod is '.$organisation_details->trail_period, 'text/html'); // for HTML rich messages
          });



    }
}

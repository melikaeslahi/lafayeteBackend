<?php
namespace App\Http\Services\Message\Email;

use App\Http\Interfaces\MessageInterface;
use Illuminate\Support\Facades\Mail;

class EmailService implements MessageInterface{

    private $details;
    private $subject;
    private $from= [
        ['address'=>null , 'name' => null]
    ];
    private $to;
   
    public function fire()
    {
       Mail::to($this->to)->send(new MailViewProvider($this->details , $this->subject , $this->from));
       return true; 
    }

    public function getDetails()
    {
        return $this->details;
    }
    public function setDetails($details)
    {
        return $this->details = $details;
    }

    public function getSubject()
    {
        return $this->subject;
    }
    public function setSubject($subject)
    {
        return $this->subject = $subject;
    }
    public function getFrom()
    {
        return $this->from;
    }
    public function setFrom($address , $name)
    {
        return $this->from = [
            [
                'address'=>$address,
                'name'=>$name
            ]
        ];
    }

    public function getTo()
    {
        return $this->to;
    }
    public function setTo($to)
    {
        return $this->to = $to;
    }

}
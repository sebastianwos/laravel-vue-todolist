<?php


namespace App\Mailers;


use App\User;
use Illuminate\Contracts\Mail\Mailer;

class AppMailer {


    /**
     * @var string
     */
    protected $from = 'admin@example.com';


    /**
     * @var
     */
    protected $to;

    /**
     * @var
     */
    protected $view;

    /**
     * @var array
     */
    protected $data = [];

    /**
     * @var Mailer
     */
    private $mailer;


    /**
     * AppMailer constructor.
     */
    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @param User $user
     */
    public function sendConfirmationEmailTo(User $user)
    {

        $this->to = $user->email;
        $this->view = 'auth.emails.confirm';
        $this->data = compact('user');

        $this->deliver();
    }

    public function deliver(){

        $this->mailer->send($this->view, $this->data, function($message){
            $message->from($this->from, 'Administrator')
                ->to($this->to);
        });

    }
}
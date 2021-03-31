<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $subject_info;
    protected $description;
    protected $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject_info, $description, $user)
    {
        $this->subject_info = $subject_info;
        $this->description = $description;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('email_template.contact_us')
    			->subject($this->subject_info)
                ->from($this->user->email)
                ->with([
                    'user' => $this->user,
                    'description' => $this->description,
                ]);
    }
}

<?php

namespace App\Mail;

use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreatedContact extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * @var Contact
     */
    private $createdContact;

    /**
     * Create a new message instance.
     *
     * @param Contact $createdContact
     * @return void
     */
    public function __construct(Contact $createdContact)
    {
        $this->createdContact = $createdContact;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Вы создали новый контакт')->
                      view('emails.created-contact', ['contact' => $this->createdContact]);
    }
}

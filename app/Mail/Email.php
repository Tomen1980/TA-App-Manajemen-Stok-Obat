<?php 
namespace App\Mail;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use app\Models\User;

class Email extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $tempPassword; // Properti untuk menampung password sementara

    public function __construct(User $user, $tempPassword)
    {
        $this->user = $user;
        $this->tempPassword = $tempPassword; // <--- Pastikan ini ada
    }
    // ...
    public function content(): Content
    {
        return new Content(
            view: 'users.WelcomEmail',
            with: [
                'password' => $this->tempPassword, // <--- Properti yang dilewatkan ke view
            ],
        );
    }
}
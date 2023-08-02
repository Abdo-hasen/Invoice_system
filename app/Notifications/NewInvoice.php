<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewInvoice extends Notification
{
    use Queueable;
    private $invoice_id;


    /**
     * Create a new notification instance.
     */
    public function __construct($invoice_id)
    {
        $this->invoice_id = $invoice_id; 
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database','mail'];
    }


    public function toDatabase($notifiable) 
    {
        return [

            // "invoice"=> $this->invoice,
            "id"=> $this->invoice_id,
            "title"=> "New Invoice Added By: ",
            "user"=> auth()->user()->name,   
        ];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('New Invoice')
                    ->action('Display Invoice', url("http://127.0.0.1:8000/admin/invoices/" . $this->invoice_id . "/show"))
                    ->line('Thank you for using our application!');
    }

}

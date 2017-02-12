<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;

use App\Order;

class OrderSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    protected $order;
    protected $content;

    /**
     * Create a new message instance.
     *
     * @param  Order        $order   instance of the submitted order
     * @return void
     */
    public function __construct(Order $order, Collection $content)
    {
        $this->order = $order;
        $this->content = $content;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('New Order From Supremeglobal.com.my: '.$this->order->reference_number)->view('emails.ordersubmitted');
    }
}

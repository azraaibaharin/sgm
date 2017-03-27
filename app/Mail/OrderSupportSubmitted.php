<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;

use App\Order;

class OrderSupportSubmitted extends Mailable
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
        return $this->subject('supremeglobal.com.my order submitted: '.$this->order->reference_number)
                ->view('emails.ordersubmitted')
                ->with('order', $this->order)
                ->with('content', $this->content);
    }
}

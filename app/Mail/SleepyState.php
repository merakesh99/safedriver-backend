<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SleepyState extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($title,$entries,$name,$vehicle)
    {
        $this->title = $title;
        $this->entries = $entries;
        $this->name = $name;
        $this->vehicle = $vehicle;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->title)->view('sleepy_alert',['Name' => $this->name, 'ID'=>$this->entries, 'Vehicle_No'=>$this->vehicle]);
    }
}

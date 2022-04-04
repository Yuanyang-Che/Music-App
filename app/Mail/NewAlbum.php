<?php

namespace App\Mail;

use App\Models\Album;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewAlbum extends Mailable
{
    use Queueable, SerializesModels;

    public $album;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($album)
    {
        $this->album = $album;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject("{$this->album->artist->name} has a new album!")
            ->view('email.new-album');
    }
}

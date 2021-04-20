<?php

namespace App\Mail\Export;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CsvExported extends Mailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    /**
     * Create a new message instance.
     *
     * @param  array  $files
     */
    public function __construct(public array $files)
    {
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        foreach ($this->files as $file) {
            $this->attach(storage_path('app/'.$file));
        }

        return $this->subject('[tootlog] export')
                    ->text('emails.export');
    }
}

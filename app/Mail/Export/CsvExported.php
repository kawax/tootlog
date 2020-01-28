<?php

namespace App\Mail\Export;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CsvExported extends Mailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    public $files;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(array $files)
    {
        $this->files = $files;
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

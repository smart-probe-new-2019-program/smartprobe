<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendLowWarningEmail extends Mailable
{
	use Queueable, SerializesModels;
	public $probe;
	public $latest_log;

	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	public function __construct($probe, $latest_log)
	{
		$this->probe = $probe;
		$this->latest_log = $latest_log;
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build()
	{
		return $this->subject('Probe Reading - Low Warning Notification')
			->view('emails.lowWarningEmail');
	}
}

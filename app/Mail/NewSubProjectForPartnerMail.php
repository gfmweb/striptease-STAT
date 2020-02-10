<?php

namespace App\Mail;

use App\SubProject;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewSubProjectForPartnerMail extends Mailable
{
	use Queueable, SerializesModels;

	/**
	 * @var User $user
	 */
	public $subProject;

	/**
	 * Create a new message instance.
	 *
	 * @param SubProject $subProject
	 */
	public function __construct(SubProject $subProject)
	{
		$this->subProject = $subProject;
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build()
	{
		$this->from('no-reply@stat.bvcrm.ru', 'Служба уведомлений stat.bvcrm.ru');
		$this->subject('Вам доступен новый проект');

		return $this->view('mails.new-sub-project')->with(['subProject' => $this->subProject]);
	}
}

<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Support\HtmlString;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class SuccessRegNotification extends Notification
{
	public function __construct(){
		////
	}
	public function via($notifiable)
	{
		return ['mail'];
	}
	public function toMail($notifiable)
	{
		return (new MailMessage)
			->greeting(new HtmlString("Hi, <b>{$notifiable->username}!</b>"))
			->subject("REGISTRATION")
			->from("patathome182@gmail.com", "patrick chua")
			->line(new HtmlString($this->mailMessage($notifiable)));
	}
	private function mailMessage($notifiable)
	{
		$message = "Youre registered";
		return $message;
	}
}
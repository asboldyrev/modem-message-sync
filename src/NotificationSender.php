<?php

namespace Asboldyrev\ModemMessageSync;

use Asboldyrev\AppriseNotificationSdk\Client;
use Asboldyrev\AppriseNotificationSdk\Content;
use Asboldyrev\AppriseNotificationSdk\Enums\Format;

class NotificationSender
{
	public static function sendTelegramNotification(string $content, string $sender, string $token = null, string $chatId = null): void
	{
		if(env('APPRISE_LOGIN') && env('APPRISE_PASSWORD')) {
			$base_auth = [
				env('APPRISE_LOGIN'),
				env('APPRISE_PASSWORD')
			];
		}

		$client = new Client(env('APPRISE_URL'), $base_auth ?? []);

		$client
			->setContent(new Content($content, $sender))
			->setFormat(Format::HTML)
			->telegram(
				$token ?? env('TELEGRAM_TOKEN'),
				$chatId ?? env('TELEGRAM_CHAT_ID')
			)
			->send();
	}
}

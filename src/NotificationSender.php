<?php

namespace Asboldyrev\ModemMessageSync;

use Asboldyrev\AppriseNotificationSdk\Client;
use Asboldyrev\AppriseNotificationSdk\Content;
use Asboldyrev\AppriseNotificationSdk\Enums\Format;
use PhpMqtt\Client\ConnectionSettings;
use PhpMqtt\Client\MqttClient;

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


	public static function sendMqttNotification(string $content, string $sender) {
		$client = new MqttClient(env('MQTT_SERVER'), clientId:env('MQTT_CLIENT_ID'));
		$settings = (new ConnectionSettings())
			->setUsername(env('MQTT_USERNAME'))
			->setPassword(env('MQTT_PASSWORD'));
		$client->connect($settings, true);

		if ($client->isConnected()) {
			$client->publish(env('MQTT_TOPIC'), $content);
			$client->disconnect();
		} else {
			echo 'Connection failed!' . PHP_EOL;
		}

	}
}

<?php

require_once 'src/bootstrap/bootstrap.php';

use Asboldyrev\ModemMessageSync\NotificationSender;
use Asboldyrev\ModemMessageSync\SmsDecoder;
use Asboldyrev\ModemMessageSync\SmsManager;
use Asboldyrev\ModemMessageSync\SshConnector;

$ssh = $sshConnection = SshConnector::connect(
		env('SSH_HOST'),
		env('SSH_USERNAME'),
		env('SSH_PASSWORD'),
		env('SSH_PORT')
);

$sshCommand = 'at -S modem at-sms-list all';
$sshCommandOutput = $ssh->executeCommand($sshCommand);

$smsData = json_decode($sshCommandOutput);
$processedSms = SmsDecoder::concatenate($smsData->sms);

$previousSms = SmsManager::loadLocalSms();

foreach ($processedSms as $newSms) {
	$found = false;
	foreach ($previousSms as $existingSms) {
		if ($newSms->ts === $existingSms->ts) {
			$found = true;
			break;
		}
	}

	if (!$found) {
		$content = [
			$newSms->data,
			'==========',
			'<strong>Номер</strong>: <code>' . $newSms->smsc . '</code>',
			'<strong>Дата</strong>: ' . $newSms->date . ' ' . $newSms->time
		];

		$content = implode(PHP_EOL, $content);

		NotificationSender::sendTelegramNotification($content, $newSms->sender);

		echo $newSms->sender . PHP_EOL;
		echo $content . PHP_EOL;
	}
}

SmsManager::saveLocalSms($processedSms);

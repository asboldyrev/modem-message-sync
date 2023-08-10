<?php

namespace Asboldyrev\ModemMessageSync;

class SmsManager
{
	protected static $localSmsFile = 'storage/sms_messages.json';


	public static function loadLocalSms(): array
	{
		return json_decode(file_get_contents(self::$localSmsFile)) ?? [];
	}


	public static function saveLocalSms($smsData): void
	{
		file_put_contents(self::$localSmsFile, json_encode($smsData));
	}
}

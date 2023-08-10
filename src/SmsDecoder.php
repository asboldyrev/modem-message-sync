<?php

namespace Asboldyrev\ModemMessageSync;

use stdClass;

class SmsDecoder
{
	public static function concatenate(array $sms): array
	{
		$obj = [];

		foreach ($sms as $message) {
			if (!$message) continue;

			if (($message->c_ref ?? null) && !$message->fail) {
				$tmp = $message;
				$cur = 1;
				$total = $message->c_tot;

				while ($total-- > 0) {
					foreach ($sms as $j => $msg) {
						if ($msg && (($tmp->c_ref ?? null) == ($msg->c_ref ?? null)) && ($msg->c_cur == $cur)) {
							if ($cur == 1) {
								$tmp = $msg;
							} else {
								$tmp->data .= $msg->data;
							}
							$cur++;
							unset($sms[$j]);
							break;
						}
					}
				}

				if ($cur == ($tmp->c_tot + 1)) {
					$obj[] = self::translate($tmp);
				}
			} else {
				$obj[] = self::translate($message);
			}
		}

		usort($obj, [self::class, 'smsCompare']);
		return $obj;
	}


	protected static function decodeUnicode(string $sub): string
	{
		$result = '';
		$index = 0;
		while ($index < strlen($sub)) {
			$char = substr($sub, $index, 4);
			$result .= mb_convert_encoding('&#x' . $char . ';', 'UTF-8', 'HTML-ENTITIES');
			$index += 4;
		}
		return $result;
	}


	protected static function translate(stdClass $sms): stdClass
	{
		$text = '';
		if ($sms->dcs == 2) {
			$text = self::decodeUnicode($sms->data);
			$sms->data = $text;
		}
		return $sms;
	}


	protected static function smsCompare(stdClass $a, stdClass $b): int
	{
		return $a->ts <=> $b->ts;
	}
}

<?php

namespace Asboldyrev\ModemMessageSync;

use phpseclib3\Net\SSH2;

class SshConnector
{
	/**
	 * @var SSH2 $connection
	 */
	protected $connection;


	public static function connect(string $host, string $username, string $password, int $port = 22): self
	{
		$connector = new self();
		$connector->connection = new SSH2($host, $port);
		$config = [
			'hostkey' => 'ssh-rsa',
			'mac_algorithms' => 'hmac-sha2-256'
		];

		if (!$connector->connection->login($username, $password, $config)) {
			exit('SSH Connection Failed');
		}

		return $connector;
	}


	public function executeCommand(string $command): string
	{
		return $this->connection->exec($command);
	}
}

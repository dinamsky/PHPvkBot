<?php namespace vkbot\commands;

use vkbot\commands\Respond;


/**
* Пользовательские команды которые обрабатывает бот
*/
class adminCommands
{
	
	public static $adminCommand = 
	[
		'ping' => 'pingpong',
	];

	private $messageData;
	private $profilesData;

	function __construct($_messageData, $_profilesData)
	{
		$this->messageData = $_messageData;
		$this->profilesData = $_profilesData;
	}

	public function pingpong()
	{
		$responseText = 'pong! (admin)';

		Respond::sendReply($responseText, $this->messageData, $this->profilesData);
	}
}

?>
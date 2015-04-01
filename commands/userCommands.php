<?php namespace vkbot\commands;

use vkbot\commands\Respond;


/**
* Пользовательские команды которые обрабатывает бот
*/
class userCommands
{
	
	public static $userCommand = 
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
		$responseText = 'pong! (user)';

		Respond::sendReply($responseText, $this->messageData, $this->profilesData);
	}
}

?>
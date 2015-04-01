<?php namespace vkbot\commands;

use vkbot\utils\Requests;
use vkbot\utils\QueryBuilder;
use vkbot\utils\AddLog;

/**
* Составления ответа на команду и его отправка
*/
class Respond
{
	/**
	* Отправка сообщения с ответом на команду
	* @var $responseText 			Ответ который вернула функция команды
	* @var $messageData 			Массив сообщения с которым работаем
	* @var $profilesData 			Массив профилей пользователей который вернул лонг пулл
	*/
	public function sendReply($responseText, $messageData, $profilesData)
	{
		$firstName = Respond::getUserName($messageData['uid'], $profilesData);

		$reply = urlencode($firstName.", ".$responseText);

		$response = Requests::get(QueryBuilder::buildVkApiURL('messages.send', ['chat_id' => $messageData['chat_id'], 'message' => $reply]), true);

		if (isset($response['error']))
		{
			AddLog::write('Response not send. ['.$response['error']['error_msg'].']');
		}
		elseif (isset($response['response']))
		{
			AddLog::write('Reply to ['.$messageData['uid'].']   msg_id: '.$response['response']);
		}

	}

	/**
	* Получаем имя пользователя по uid'у
	* @var 	$uid 					id отправителя сообщения (команды)
	* @var  $profilesData 			Массив профилей пользователей который вернул лонг пулл
	*/
	private function getUserName($uid, $profilesData)
	{
		for ($i=0; $i < count($profilesData); $i++)
		{ 
			if ($profilesData[$i]['uid'] == $uid)
			{
				return $profilesData[$i]['first_name'];
			}
		}
	}

}

?>
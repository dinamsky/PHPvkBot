<?php namespace vkbot\modules;

use vkbot\modules\Configure;
use vkbot\commands\userCommands;
use vkbot\commands\adminCommands;
use vkbot\utils\AddLog;

/**
* Обработчик сообщений
* @var 	$messageData 			Массив сообщения которой вернул лонг пулл
* @var 	$profilesData 			Массив пользователей который вернул лонг пулл
* @var  $configData 			Конфгурация с данными для бота
*/
class MessagesHandler
{
	private $messagesData;
	private $profilesData;
	private $configData;
	
	/**
	* Конструктор принимающий данные от лонг пула
	* @var 	$_messageData 			Массив сообщения которой вернул лонг пулл
	* @var 	$_profilesData 			Массив пользователей который вернул лонг пулл
	*/
	public function construct($_messagesData, $_profilesData)
	{
		$this->messagesData = $_messagesData;
		$this->profilesData = $_profilesData;
		$this->configData = Configure::get();
	}

	/**
	* Проверяем сообщение на валидность (id отправителя не совпадает с id бота / пустое сообщение / работа в данной конференции)
	* Отправляем сообщение для проверки на команду и ее тип
	* @var $message 			Массив сообщения с которым работаем
	*/
	private function validator($message)
	{
		if (($message['uid'] != $this->configData['bot_id']) and ($message['body'] != '') and (in_array($message['chat_id'], $this->configData['chat_ids'])))
		{
			return $this->getPrivilege($message);
		}
		else
		{
			return [false, 'Not valid message.'];
		}
	}

	/**
	* Определяем тип команды (пользовательская или админская)
	* Отправляем на поиск команды в списке
	* @var $message 			Массив сообщения с которым работаем
	*/
	private function getPrivilege($message)
	{
		$commandList = [];

		if ($message['body'][0] == '!')
		{
			$commandList = userCommands::$userCommand;
			$this->searchCommand('user', $commandList, $message);
			return 'user';
		}
		elseif ($message['body'][0] == '/')
		{
			$commandList = adminCommands::$adminCommand;
			
			if (in_array($message['uid'], $this->configData['admin_ids']))
			{
				$this->searchCommand('admin', $commandList, $message);
				return 'admin';
			}
			else
			{
				return [false, 'Not admin. ['.$message['uid'].']'];
			}

			
		}
		else
		{
			return [false, 'Message not command.'];
		}
	}

	/**
	* Ищем команду из сообщения в списке команд
	* @var 	$commandList 			Список команд (пользовательские или админские)
	* @var 	$message 				Массив сообщения с которым работаем
	*/
	private function searchCommand($commandType, $commandList, $message)
	{
		 foreach ($commandList as $command => $function)
		 {
		 	if (strstr(mb_strtolower($message['body']), $command))
		 	{
		 		if ($commandType == 'user')
		 		{
		 			$userCommands = new userCommands($message, $this->profilesData);
		 			$userCommands->$function();
		 		}
		 		elseif ($commandType == 'admin')
		 		{
		 			$adminCommands = new adminCommands($message, $this->profilesData);
		 			$adminCommands->$function();
		 		}
		 	}
		 }
	}

	# Чекинг сообщений на валидность
	public function checking()
	{
		if ($this->messagesData[0] != 0)
		{
			for ($i=1; $i < $this->messagesData[0]+1; $i++)
			{ 
				$validator = $this->validator($this->messagesData[$i]);

				if (!$validator[0])
				{
					AddLog::write($validator[1]);
				}
			}
		}
		else
		{
			AddLog::write("No new messages.");
		}
	}
}

?>
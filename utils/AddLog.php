<?php namespace vkbot\utils;

/**
* Работа лога в консоли
*/
class AddLog
{
	/**
	* Вывод сообщений в консоль
	* @var 	$text 		Текст сообщения
	*/
	public function write($text)
	{	
		$text = str_replace('і', 'i', $text);
		$text = str_replace('ї', '?', $text);
		$text = str_replace('<br>', PHP_EOL, $text);
		$text = iconv('UTF-8', 'CP866', $text);

		if ($text !== FALSE)
		{
			print_r("[".date("H:i:s")."]  ".$text.PHP_EOL);
		}
		else
		{
			print_r("[".date("H:i:s")."]  Log error.".PHP_EOL);
		}

		
	}

}

?>
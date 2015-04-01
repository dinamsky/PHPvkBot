<?php namespace vkbot\modules;

/*
 Схороняем данные в конфигурационный файл и возвращаем их же
*/
class Configure
{
	public static function set($data)
	{
		file_put_contents('config.json', json_encode($data));
	}

	public static function get()
	{
		return json_decode(file_get_contents('config.json'), true);
	}
}

?>
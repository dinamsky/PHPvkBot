<?php namespace vkbot\utils;

use vkbot\modules\Configure;

/**
* Класс построения строк для запросов
*/
class QueryBuilder
{
	/**
	* Построение URL для запроса к апи вк
	* @var  $method 		Метод апи вк
	* @var  $params 		Параметры запроса в виде ассоциативного массива
	*
	* @var 	$param 			Параметры гет запроса
	* @var 	$config 		Конфгурация с данными для бота
	* @var 	$url 			Готовый URL для запроса	
	*/
	public function buildVkApiURL($method, $params)
	{
		$param = '';
		$config = Configure::get();

		foreach ($params as $key => $value)
		{
			$param .= $key.'='.$value.'&';
		}

		$url = "https://api.vk.com/method/".$method."?".$param."access_token=".$config['token'];

		return $url;
	}
}

?>
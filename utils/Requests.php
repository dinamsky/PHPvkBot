<?php namespace vkbot\utils;

/*
* POST / GET запросы и запрос к апи вк
*/
class Requests
{
	/**
	* Отправка GET запроса
	* @var 	$url 		Полный URL GET запроса
	* @var 	$json 		Декодировать ли JSON ответ (true/false)
	*/
	public function get($url, $json)
	{
		$response = file_get_contents($url);

		if ($json)
		{
			return json_decode($response, true);
		}
		else
		{
			return $response;
		}
	}

}

?>
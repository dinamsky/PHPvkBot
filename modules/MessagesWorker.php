<?php namespace vkbot\modules;

use vkbot\utils\QueryBuilder;
use vkbot\utils\Requests;
use vkbot\modules\Configure;
use vkbot\modules\MessagesHandler;
use vkbot\utils\AddLog;

/**
* Получение новых сообщений с помощью longpoll'a
* @var  $working  				Работа цикла получения новых сообщений (true/false)
* @var  $LPSData  				Данные LongPoll сервера
*/
class MessagesWorker
{
	public $working = false;

	private $Handler;
	private $LPSData;

	# Получаем данные LongPoll сервера
	private function getLongPoolServerData()
	{
		$this->LPSData = Requests::get(QueryBuilder::buildVkApiURL('messages.getLongPollServer', ['use_ssl' => '1', 'need_pts' => '1']), true)['response'];
	}

	# Получаем новые сообщения
	private function getLongPoolHistory()
	{
		return Requests::get(QueryBuilder::buildVkApiURL('messages.getLongPollHistory',['ts' => $this->LPSData["ts"], 'pts' => $this->LPSData['pts']]), true);
	}

	# Каждых N секунд получаем новые сообщения
	private function rounds()
	{
		while ($this->working)
		{
			$response = $this->getLongPoolHistory();
			$this->LPSData['pts'] = $response['response']['new_pts'];

			$this->Handler->construct($response['response']['messages'], $response['response']['profiles']);
			$this->Handler->checking();

			usleep(3200000);
		}
	}
	
	# Получаем данные лонг пула и стартуем цикл для получения новых сообщений
	public function launch()
	{
		AddLog::write('Starting!');
		$this->Handler = new MessagesHandler;

		$this->getLongPoolServerData();
		$this->working = true;
		$this->rounds();
	}
	
}

?>
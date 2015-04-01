<?php
require_once dirname(__FILE__).'\autoload.php';

use vkbot\modules\Configure;
use vkbot\modules\MessagesWorker;


Configure::set(
[
	'token' => '4cfdc2e157eefe6facb983b1d557b3a14cfdc2e157eefe6facb983b1d557b3a14cfdc2e157eefe6facb98',
	'admin_ids' => ['1', '2'],
	'chat_ids' => ['13', '37'],
	'bot_id' => '123456789'
]);



$worker = new MessagesWorker;
$worker->launch();


?>
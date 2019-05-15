<?php
/**
 * Created by PhpStorm.
 * User: axharus
 * Date: 13-May-19
 * Time: 16:34
 */

namespace App\Classes;


use Http\Adapter\Guzzle6\Client;
use Http\Factory\Guzzle\RequestFactory;
use Http\Factory\Guzzle\StreamFactory;

class TelegramBot {
	private $bot;
	private $userId;

	public function __construct() {
		$botKey = env('TELEGRAM_BOT_KEY');

		$requestFactory = new RequestFactory();
		$streamFactory = new StreamFactory();
		$client = new Client();

		$apiClient = new \TgBotApi\BotApiBase\ApiClient($requestFactory, $streamFactory, $client);
		$this->bot = new \TgBotApi\BotApiBase\BotApi($botKey, $apiClient, new \TgBotApi\BotApiBase\BotApiNormalizer());

		$this->userId = env('TELEGRAM_BOT_CLIENT');


	}

	public function send($message){
		$this->bot->send(\TgBotApi\BotApiBase\Method\SendMessageMethod::create($this->userId, $message));
	}
}
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
	private $userId = [];

	public function __construct() {
		$botKey = env('TELEGRAM_BOT_KEY');

		$requestFactory = new RequestFactory();
		$streamFactory = new StreamFactory();
		$client = new Client();

		$apiClient = new \TgBotApi\BotApiBase\ApiClient($requestFactory, $streamFactory, $client);
		$this->bot = new \TgBotApi\BotApiBase\BotApi($botKey, $apiClient, new \TgBotApi\BotApiBase\BotApiNormalizer());

		$this->userId = explode(',',env('TELEGRAM_BOT_CLIENT'));
//		dd($this->userId);
	}

	public function send($message){
		foreach($this->userId as $user){
			try{
				$this->bot->send(\TgBotApi\BotApiBase\Method\SendMessageMethod::create($user, $message));
			}catch (\Exception $e){

			}
		}

	}
}
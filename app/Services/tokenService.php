<?php 
require_once('./alertService.php');

use \Firebase\JWT\JWT;

class TokenService
{
	private $_alert_service;
	private $_validator_service;	
	public $secret_key;

	public function __construct()
	{
		$this->_alert_service = new AlertService;
		$this->secret_key = base64_encode('my_super_secure_key');
	}

	public function generateToken($credentials)
	{
			$current_time = time();
			$expiration_time = $current_time + (60*60); //expiration time -> 1 hour;
			$token_data = array(
				'iat' => $current_time,
				'exp' => $expiration_time,
				'user_data' => array(
					"mail" => $credentials['mail'],
					"pass" => $credentials['pass']
				)
			);
			$token = JWT::encode($token_data, $this->secret_key);

			$this->_alert_service->throwMssg("token",$token,200);
	}
	public function validateToken()
	{
		$is_token_exist = array_key_exists("Authorization",getallheaders());

		if ($is_token_exist) {
			//get token value from header and delete spaces
			$token =trim(substr(getallheaders()["Authorization"],7));
			try {
				JWT::decode($token,$this->secret_key,array('HS256'));
				return true;
			}
			catch (Exception $error) 
			{
				switch ($error->getMessage()) {
					case 'Expired token':
					$this->_alert_service->throwMssg("error: ","Expired token",401);
					break;

					default:
					$this->_alert_service->throwMssg("error: ","Invalid Token",401);
					break;
				}
				return false;
			} 
		}
		else
		{
			$this->_alert_service->throwMssg("error: ","Token not provided",401);
			return false;
		}
	}
}
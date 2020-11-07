<?php 
require_once('./app/Models/UserModel.php');
require_once('./app/Services/alertService.php');
require_once('./app/Services/tokenService.php');
require_once('./app/Services/requestService.php');
require_once('./app/Services/validatorService.php');

new Database();

class UserController 
{
	private $_alert_service;
	private $_token_service;
	private $_request_service;
	private $_user;

	public function __construct()
	{
		$this->_alert_service = new AlertService;
		$this->_token_service = new TokenService;
		$this->_validator_service = new ValidatorService;
		$this->_request_service = new RequestService;
		$this->_user =  new User;
	}

	public function store()
	{

		$request = $this->_validator_service->encryptPass(
			$this->_request_service->getRequest()
		);

		$required_fields = ['name','surname','mail','balance','pass'];

		if($this->_validator_service->validateData($required_fields,$request)) 
		{
			if($this->_user->where("mail",$request['mail'])->get()->count()>0)
			{
				$this->_alert_service->throwMssg("message","The mail already exist",403);
			}
			else
			{
				$user = $this->_user->create($request);
				$this->_alert_service->throwMssg("user",$this->_request_service->getRequest(),201);
			}
		}

	}

	public function show()
	{
		$request = $this->_validator_service->encryptPass(
			$this->_request_service->getRequest()
		);

		$required_fields = ['id'];

		if($this->_validator_service->validateData($required_fields,$request)) 
		{
			if($this->_user->where("id",$request['id'])->get()->count()>0)
			{
				$user_data = $this->_user->where("id",$request['id'])->first();
				$this->_alert_service->throwMssg("user",$user_data,200);
			}
			else
			{
				$this->_alert_service->throwMssg("error","The user doesn't exist",404);
			}
		}
	}

	public function update()
	{
		$request = $this->_request_service->getRequest();
		$required_fields = ['id','balance'];

		if($this->_validator_service->validateData($required_fields,$request))
		{
			$user = $this->_user->where("id",$request['id'])->get();
			if(count($user)>0)
			{
				$this->_user->where("id",$request['id'])->update(['balance' => $request['id']]);
				$this->_alert_service->throwMssg("user","Balance was saved",200);
			}
			else
			{
				$this->_alert_service->throwMssg("error","The user doesn't exist",404);
			}
		}
	}

	public function login()
	{
		$credentials = $this->_request_service->getRequest();
		
		if (self::validateCredentials($credentials)) 
		{
			$token = $this->_token_service->generateToken($credentials);
		}
	}

	private function validateCredentials($credentials)
	{
		if ($this->_validator_service->validateData(["mail","pass"],$credentials)) 
		{
			if($this->_user->where("mail",$credentials['mail'])->get()->count()>0)
			{
				$db_pass = $this->_user->where("mail",$credentials['mail'])->first()->pass;
				

				return $is_pass_valid = password_verify($credentials['pass'],$db_pass) ? true : $this->_alert_service->throwMssg("message","Invalid password",401);
			}
			else
			{
				$this->_alert_service->throwMssg("message","Invalid mail",401);
			}
		}
	}
}
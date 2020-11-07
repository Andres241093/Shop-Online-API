<?php 
require_once("./../app/Services/alertService.php");
require_once('./../app/Controllers/userController.php');

class AuthRouter
{
	private $http_method;
	public $_alert_service;
	public $_user_controller;

	public function __construct()
	{
		$this->http_method = $_SERVER['REQUEST_METHOD'];
		$this->_alert_service = new AlertService;
		$this->_user_controller = new UserController;
	}

	public function checkHttpMethod()
	{
		switch ($this->http_method) 
		{
			case 'POST':
				$this->_user_controller->login();
			break;
			
			default:
				$this->_alert_service->throwMssg("error: ","Method not allowed",405);
			break;
		}
	}
}
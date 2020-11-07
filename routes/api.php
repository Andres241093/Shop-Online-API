<?php 
require_once('./../app/Services/alertService.php');
require_once('./authRouter.php');
require_once('./userRouter.php');
require_once('./productRouter.php');

class ApiRoute
{
	public $route;
	public $url;
	public $_alert_service;
	public $_auth_router;
	public $_user_router;
	public $_product_router;
	public $_user_controller;

	public function __construct($route)
	{
		$this->route = $route;
		$this->_alert_service = new AlertService;
		$this->_auth_router = new AuthRouter;
		$this->_user_router = new UserRouter;
		$this->_product_router = new ProductRouter;
		$this->url_array = array('/api/users','/api/auth/login','/api/products');
	}
	
	public function redirect()
	{
		$this->route = self::checkRoute();
		switch($this->route) 
		{
			case '/api/auth/login':
				$this->_auth_router->checkHttpMethod();
			break;

			case '/api/users':
				$this->_user_router->checkHttpMethod();
			break;

			case '/api/users?id='$_GET['id']:
				$this->_user_router->checkHttpMethod();
			break;

			case '/api/products':
				$this->_product_router->checkToken();
			break;

			default:
				$this->_alert_service->throwMssg("error: ","Not route found",404);
			break;
		}
	}

	public function checkRoute()
	{ 
		if (in_array($this->route,$this->url_array)) 
		{
			return $this->route;
		}
	}

}
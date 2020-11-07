<?php 
require_once('./../app/Services/alertService.php');
require_once('./../app/Services/tokenService.php');
require_once('./../app/Controllers/ProductController.php');


class ProductRouter
{
	private $http_method;
	private $_alert_service;
	private $_token_service;
	private $_product_controller;

	public function __construct()
	{
		$this->http_method = $_SERVER['REQUEST_METHOD'];
		$this->_alert_service = new AlertService;
		$this->_token_service = new TokenService;
		$this->_product_controller = new ProductController;
	}

	public function checkToken()
	{
		if($this->_token_service->validateToken())
		{
			self::checkhttp_method();
		}
	}

	public function checkhttp_method()
	{
		switch ($this->http_method) 
		{
			case 'GET':
				$this->_product_controller->index();
			break;

			case 'PUT':
				$this->_product_controller->update();
			break;
			
			default:
				$this->_alert_service->throwMssg("error: ","Method not allowed",405);
			break;
		}
	}
	
}
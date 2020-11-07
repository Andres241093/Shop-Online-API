<?php 
require_once('./../Models/ProductModel.php');
require_once('./../Services/alertService.php');
require_once('./../Services/requestService.php');
require_once('./../Services/validatorService.php');

new Database();

class ProductController 
{
	private $_alert_service;
	private $_token_service;
	private $_request_service;
	private $_product;

	public function __construct()
	{
		$this->_alert_service = new AlertService;
		$this->_validator_service = new ValidatorService;
		$this->_request_service = new RequestService;
		$this->_product =  new Product;
	}

	public function index()
	{
		$product = $this->_product->all();
		$this->_alert_service->throwMssg("products",$product,200);
	}

	public function update()
	{
		$request = $this->_request_service->getRequest();
		$required_fields = ["id"];
		
		if($this->_validator_service->validateData($required_fields,$request)
			&& $this->_validator_service->validateStarFields($request))
		{
			self::setRanking($request["star"],$request["id"]);
		}
	}
	private function setRanking($star,$id)
	{
		$product = $this->_product->where("id",$id)->get();
		if(count($product)>0)
		{
			$db_star_rank = $this->_product->where("id",$id)->first();

			$new_star_rank = $db_star_rank->$star + 1;

			$this->_product->where("id",$id)->update([$star => $new_star_rank]);
			$this->_alert_service->throwMssg("message","Thanks for ranking our products!",200);
		}
		else
		{
			$this->_alert_service->throwMssg("error","The product doesn't exist",404);
		}

	}
}
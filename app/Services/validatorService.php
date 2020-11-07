<?php 
require_once('./alertService.php');

class ValidatorService
{
	private $_alert_service;

	public function __construct()
	{
		$this->_alert_service = new AlertService;
	}

	public function validateData($required_fields,$request)
	{
		$missed_fields = [];
		foreach ($required_fields as $key => $value) 
		{
			if(!array_key_exists($value,$request)) 
			{
				array_push($missed_fields,$value);
			}
		}
		if(count($missed_fields)>0)
		{
			$string_missed_fields = implode(",", $missed_fields);
			$this->_alert_service->throwMssg("error","This fields are required: ".$string_missed_fields,401);
			return false;
		}
		else
		{
			return true;
		}
		
	}

	public function encryptPass($request)
	{
		if (array_key_exists("pass",$request)) {
			$request["pass"] = password_hash($request["pass"], PASSWORD_DEFAULT);
		}
		return $request;
	}

	public function validateStarFields($request)
	{
		$star_fields = ['star_1','star_2','star_3','star_4','star_5'];
		if (array_key_exists("star",$request)) 
		{
			$value = $request['star'];
			if(!in_array($value,$star_fields))
			{
				$this->_alert_service->throwMssg("error","The star field is invalid",401);
				return false;
			}
			else
			{
				return true;
			}
		}
		else
		{
			$this->_alert_service->throwMssg("error","The star field is required",401);
		}
	}
}
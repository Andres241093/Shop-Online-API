<?php 

class AlertService
{
	public function throwMssg($title,$alert,$status)
	{
		$mssg = array($title=>$alert);
		echo json_encode($mssg,JSON_UNESCAPED_UNICODE);
		http_response_code($status);
	}
}
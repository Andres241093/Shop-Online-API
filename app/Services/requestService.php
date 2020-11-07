<?php 

//getRequest
//validateRequest
class RequestService
{
	public function getRequest()
	{
		$request = self::transformToArray(file_get_contents('php://input'));
		return $request;
	}

	public function transformToArray($data)
	{
		return json_decode($data,true);
	}
}
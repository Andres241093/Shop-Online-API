<?php 

class HttpHeader
{
	public function setData()
	{
		header("Content-type: application/json; charset=utf-8");
		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Headers: Authorization, Content-Type");
		header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
	}
}
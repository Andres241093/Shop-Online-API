<?php 

require 'vendor/autoload.php';
require 'config/database.php';
require 'routes/api.php';
require 'app/Middlewares/httpHeader.php';

$_route = new ApiRoute($_SERVER["REQUEST_URI"]);
$_header = new HttpHeader;

$_route->redirect();
$_header->setData();

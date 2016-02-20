<?php

define('ROOT_DIR', __DIR__ );

require 'class'. DIRECTORY_SEPARATOR .'scrap_amazon.php';

$obj  = new Scrap_amazon;

$result = $obj->index();

echo json_encode($result);


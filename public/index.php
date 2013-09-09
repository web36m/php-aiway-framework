<?php

require_once dirname(__FILE__).'/../framework/Aiway.php';

Aiway::create(array(
	'config' => dirname(__FILE__).'/../protected/main.ini',
	'basepath' => dirname(__FILE__).'/../protected',
	'routes' => dirname(__FILE__).'/../protected/routes.php',
));
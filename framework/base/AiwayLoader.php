<?php

class AiwayLoader {
	
	public static function base($class) {
		self::load(dirname(__FILE__), $class);
	}

	public static function model($class) {
		self::load(Aiway::app()->basepath.'/'.Aiway::app()->request['module'].'models', $class);
	}

	public static function controller($class) {
		self::load(Aiway::app()->basepath.'/'.Aiway::app()->request['module'].'controllers', $class);
	}

	public static function component($class) {
		self::load(Aiway::app()->basepath.'/'.Aiway::app()->request['module'].'components', $class);		
	}
	
	public static function load($path, $class) {
		if (file_exists($path.'/'.$class.'.php') && !class_exists($class))
			require_once $path.'/'.$class.'.php';
	}

}

<?php

class Aiway {

	protected static $oi = null;

	private function __construct() {}
	private function __clone() {}
	private function __wakeup() {}

	public static function create($options = array()) {
		if (is_null(self::$oi)) {
			self::$oi = new self();
		}
		self::$oi->config = parse_ini_file($options['config'], true);
		self::$oi->basepath = $options['basepath'];
		self::$oi->request = array(
			'module' => '',
			'controller' => 'siteController',
			'action' => 'indexAction',
		);
		self::$oi->run($options['routes']);
		return self::$oi;
	}

	public static function app() {
		return self::$oi;
	}
	
	public function run($routes) {
		require_once dirname(__FILE__).'/base/AiwayLoader.php';
		spl_autoload_register(array('AiwayLoader', 'controller'));
		spl_autoload_register(array('AiwayLoader', 'component'));
		spl_autoload_register(array('AiwayLoader', 'base'));
		spl_autoload_register(array('AiwayLoader', 'model'));
		try {
			AiwayRouter::run($routes);
		} catch(AiwayException $e) {
			$e->responseError();
			AiwayRouter::forward('site', 'error', array(
				'code' => $e->getCode(),
				'message' => $e->getMessage(),
			));
		}
	}

}
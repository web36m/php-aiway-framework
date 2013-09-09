<?php

class AiwayRouter {
	
	private function setMCA($urlData, $routes) {
		$str = 'controller=site&action=error';
		foreach(require $routes as $pattern => $route) {
			if (preg_match('/'.addcslashes($pattern, '/').'/i', $urlData['path'])) {
				$str = preg_replace('/' . addcslashes($pattern, '/') . '/i', $route, $urlData['path']);
				break;
			}
		}
		parse_str($str, $data);
		Aiway::app()->request = $data;
		Aiway::app()->request['module'] = (!empty($data['module'])) ? 'modules/'.$data['module'].'/' : '';
		Aiway::app()->request['controller'] = (!empty($data['controller'])) ? $data['controller'] : 'site';
		Aiway::app()->request['action'] = (!empty($data['action'])) ? $data['action'] : 'index';
		unset($data,$str);
		return $this;
	}
	
	public static function run($routes) {
		$oi = new self();
		$oi->setMCA(parse_url($_SERVER['REQUEST_URI']), $routes);
		if (!class_exists(Aiway::app()->request['controller'].'Controller'))
			throw new AiwayException('Страница не найдена', 404);
		if (!method_exists(Aiway::app()->request['controller'].'Controller', Aiway::app()->request['action'].'Action'))
			throw new AiwayException('Страница не найдена', 404);
		$oi->forward(Aiway::app()->request['controller'], Aiway::app()->request['action']);
	}
	
	public static function forward($controller='site', $action='index', $data=null) {
			$controller = $controller.'Controller';
			$action = $action.'Action';
			$oi = new $controller();
			$oi->$action($data);
			if (method_exists($controller, 'run'))
				$controller->run();
			if (method_exists($controller, 'init'))
				$controller->init();
	}

}
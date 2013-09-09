<?php

class AiwayController {
	
	public function render($template, $data=array()) {
		$view = new AiwayView($data);
		return $view->getContent($template);
	}

}
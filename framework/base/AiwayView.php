
<?php

class AiwayView {

	public function __construct($data=array()) {
		foreach ($data as $key => $value)
			$this->$key = $value;
	}

	public function __get($name) {
		return '';
	}
	
	public function getContent($template) {
		$template = Aiway::app()->basepath.'/'.Aiway::app()->request['module'].'views/'.$template.'.php';
		if (!file_exists($template))
			throw new AiwayException('Не найдено представление '.$template, 500);
		ob_start();
		require $template;
		$content = ob_get_contents();
		ob_end_clean();
		return $content;
	}

}
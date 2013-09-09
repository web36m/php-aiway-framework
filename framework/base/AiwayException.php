
<?php

class AiwayException extends Exception {

	public function __construct($message, $code) {
		$this->message = $message;
		$this->code = $code;
	}

	public function responseError() {
		$method = 'error_' . $this->code;
		if (method_exists($this, $method))
			$this->$method();
	}

	private function error_404() {
		ob_end_clean();
		header('HTTP/1.0 404 Not Found');
	}

	private function error_500() {
		ob_end_clean();
		header('HTTP/1.1 500 Internal Server Error');
	}

	private function error_1045() {
		ob_end_clean();
		header('HTTP/1.1 500 Internal Server Error');
	}
}		
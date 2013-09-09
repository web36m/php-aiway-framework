php-aiway-framework
===================

Mini PHP Framework from Aiway Studio
### Example controller
```php
<?php

class siteController extends AiwayController {
	
	public function indexAction() {
		$model = Pages::model();
		$page = $model->getPageById(1);
    echo $this->render('site/index', $page);
	}

	public function errorAction($data=array()) {
		
		$model = Pages::model();
		$page = (object) array(
					'title' => 'Ошибка: '.$data['code'].' '.$data['message'],
		);
    echo $this->render('site/error', $page);
		
	}
	
}
```
### Example model
```php
<?php

class Pages extends AiwayModel {
	
	public static function model($className=__CLASS__){
		return parent::model($className);
	}

	public $table = 'content_pages';

	public function getPageById($id = 1) {
		$pd = Aiway::app()->db->query('SELECT * FROM `' . $this->table . '` WHERE `id` = "' . (int) $id . '" AND `status` = "1" LIMIT 1');
		return ($pd) ? $pd->fetch(PDO::FETCH_OBJ) : false;
	}

}
```
### Example view
```html
<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo strip_tags($this->title); ?></title>
  </head>
  <body>
    <h1><?php echo $this->h1; ?></h1>
    <?php echo $this->content; ?>
  </body>
</html>
```

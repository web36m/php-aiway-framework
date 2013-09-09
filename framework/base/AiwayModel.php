
<?php

class AiwayModel {

	public static function model($className = __CLASS__) {
		if (empty(Aiway::app()->db))
			try {
				Aiway::app()->db = new PDO(Aiway::app()->config['db']['driver'] . ':host=' . Aiway::app()->config['db']['host'] . ';dbname=' . Aiway::app()->config['db']['name'], Aiway::app()->config['db']['user'], Aiway::app()->config['db']['password']);
				Aiway::app()->db->exec('SET NAMES `' . Aiway::app()->config['db']['encoding'] . '`');
			} catch (Exception $e) {
				throw new AiwayException('Невозможно подключиться к базе данных', 500);
			}
		return new $className;
	}

	public function setError($key, $value) {
		$this->error->$key = $value;
		return true;
	}

	public function getError($key) {
		return (isset($this->error->$key)) ? $this->error->$key : null;
	}

	public function getErrorAll() {
		return (!empty($this->error)) ? $this->error : null;
	}

	public function validation($rules) {
		$return = true;
		if (!is_array($rules))
			return $return;
		foreach ($rules as $attr => $rule) {
			if (!preg_match(iconv('utf-8', 'cp1251', $rule[0]), iconv('utf-8', 'cp1251', $this->$attr))) {
				$this->setError($attr, $rule[1]);
				$return = false;
			}
		}
		return $return;
	}

	public function count($where = '`status` = "1"') {
		$pd = Aiway::app()->db->query('SELECT COUNT(`id`) AS "count" FROM `' . $this->table . '` WHERE ' . $where);
		return ($pd) ? $pd->fetch(PDO::FETCH_OBJ)->count : 0;
	}

	public function save($data = array(), $insert = false, $table = false) {
		if (!is_array($data) || count($data) === 0)
			return false;
		$data = array_map('mysql_escape_string', $data);
		if ($insert) {
			if (isset($data['id']))
				unset($data['id']);
			return (Aiway::app()->db->query('INSERT INTO `' . ($table === false ? $this->table : $table) . '` (`' . implode('`, `', array_keys($data)) . '`) VALUES ("' . implode('", "', array_values($data)) . '")')) ? Aiway::app()->db->lastInsertId() : false;
		} else {
			if (!isset($data['id']))
				return false;
			else {
				$id = $data['id'];
				unset($data['id']);
				$update = array();
				foreach ($data as $key => $value) {
					$update[] = '`' . $key . '` = "' . $value . '"';
				}
				return (Aiway::app()->db->query('UPDATE `' . ($table === false ? $this->table : $table) . '` SET ' . implode(', ', $update) . ' WHERE `id` = ' . (int) $id)) ? (int) $id : false;
			}
		}
	}

}
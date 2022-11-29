<?php
declare(strict_types=1);

namespace App\Model\BaseModel;

use Nette\SmartObject;

use Nette\Database\Context;
use Nette\Database\Table\ActiveRow;
use Nette\Database\Table\Selection;

use Nette\Utils\ArrayHash;

class BaseModel{

    use SmartObject;

    protected $db;

    protected $table = "";

    function __construct(Context $db){
        $this->db = $db;
    }

    public function findById($id){
        return $this->db->table($this->table)->wherePrimary($id);
    }

    public function fetchById($id) {
		return $this->findById($id)->fetch();
	}

    public function findAll(): Selection {
		return $this->db->table($this->table);
	}

    public function findAllActive(): Selection {
		return $this->findAll()->where("is_deleted IS FALSE");
	}

    public function save($values): int {
		if ($values instanceof ArrayHash) {
			$values = (array)$values;
		}

		if ($this->isSetId($values)) {
			$id = $values['id'];
			unset($values['id']);
			$this->db->query("UPDATE `$this->table` SET ? WHERE id = ?", $values, $id);
			return intval($id);
		} else {

			if (array_key_exists('id', $values)) {
				unset($values['id']);
			}
			$this->db->query("INSERT INTO `$this->table`", $values);
			return intval($this->db->getInsertId());
		}
	}

    public function saveWithId($values): int {
        $this->db->query("INSERT INTO `$this->table`", $values);
        return intval($this->db->getInsertId());
    }

    public function isSetId($values) {
		return array_key_exists('id', $values) && intval($values['id']) > 0;
	}

	public function getColumnNames($tableName): array {
		return $this->db->query("SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME ='$tableName' AND TABLE_SCHEMA='skss'")
			->fetchPairs(null, "COLUMN_NAME");
	}

    public function delete($id): int {
		return $this->db->table($this->table)->wherePrimary($id)->delete();
	}

    public function softDelete($id, $column = 'is_deleted') {
		$this->db->query("UPDATE `$this->table` SET $column = 1 WHERE id = ?", $id);
	}

    public function softDeleteDate(int $id, int $loginId) {
		$args = ["date_deleted" => new \DateTime, "deleted_by" => $loginId, "is_active" => 0];
		$this->db->query("UPDATE `$this->table` SET ? WHERE id = ?", $args, $id);
	}


}
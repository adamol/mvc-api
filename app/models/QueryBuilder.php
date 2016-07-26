<?php

class QueryBuilder
{
	public $query = '';

	public static function create() {
		return new QueryBuilder();
	}

	public function select($input)
	{
		$this->query = "SELECT {$input}";

		return $this;
	}

	public function from($table)
	{
		$this->query .= " FROM {$table}";

		return $this;
	}

	public function where($col, $val)
	{
		$val = "'" . $val . "'";
		$this->query .= " WHERE {$col}={$val}";

		return $this;
	}

	public function whereIn($col, $vals)
	{
		$vals = $this->addQuotes($vals);
		$this->query .= " WHERE {$col} IN ({$vals})";

		return $this;
	}

	public function into($table)
	{
		$this->query = "INSERT INTO {$table}";

		return $this;
	}

	public function insert($cols, $vals)
	{
		$cols = implode(',', $cols);
		$vals = implode(',', $this->addQuotes($vals));
		$this->query .= " ({$cols}) VALUES ({$vals})";

		return $this;
	}

	public function update($table)
	{
		$this->query = "UPDATE {$table}";

		return $this;
	}

	public function set($input)
	{
		$set = "";
		foreach ($input as $col => $val) {
			$set .= $col . "='" . $val . "',";
		}
		$set = substr($set, 0, -1);
		
		$this->query .= " SET {$set}";

		return $this;
	}

	public function deleteFrom($table)
	{
		$this->query = "DELETE FROM {$table}";

		return $this;
	}

	protected function addQuotes(array $vals) {
		return array_map(function($val) {
			return "'" . $val . "'";
		}, $vals);
	}
}
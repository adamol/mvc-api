<?php

require_once 'QueryBuilder.php';
require_once 'Post.php';
require_once 'Comment.php';

abstract class Model
{
	protected $conn;

	public static function all() {
		global $conn;

		$class = get_called_class();
		$sql = QueryBuilder::create()
			->select('*')
			->from((new $class)->table);

		$result = mysqli_query($conn, $sql->query);

		if (mysqli_num_rows($result) > 0) {
			$objects = array();
			while ($row = mysqli_fetch_assoc($result)) {
				$objects[] = (new $class)->create($row);
			}
			return $objects;
		}
	}

	public static function find($id) {
		$class = get_called_class();
		global $conn;
		if (!is_array($id)) {
			$sql = QueryBuilder::create()
				->select('*')
				->from((new $class)->table)
				->where('id', $id)
				->query;

			$result = mysqli_query($conn, $sql);
			return (new $class)->create(mysqli_fetch_assoc($result));

		} else {
			$sql = QueryBuilder::create()
				->select('*')
				->from((new $class)->table)
				->whereIn('id', $id)
				->query;

			$result = mysqli_query($conn, $sql);

			if (mysqli_num_rows($result) > 0) {
				$objects = array();
				while ($row = mysqli_fetch_assoc($result)) {
					$objects[] = (new $class)->create($row);
				}
				return $objects;
			}
		}
	}

	public function save() {
		global $conn;
		$vals = [];

		foreach ($this->fillables as $fillable) {
			$vals[] = $this->$fillable;
		}

		$sql = QueryBuilder::create()
			->into($this->table)
			->insert($this->fillables, $vals)
			->query;

		if (mysqli_query($conn, $sql)) {
			// $_SESSION['message'] = "Query processed successfully.";
			echo "Query processed successfully.";
		} else {
			echo "Unable to process query.";
		}
	}

	public static function update($id, array $input) {
		global $conn;
		$class = get_called_class();

		$sql = QueryBuilder::create()
			->update((new $class)->table)
			->set($input)
			->where('id', $id)
			->query;

		if (mysqli_query($conn, $sql)) {
			// $_SESSION['message'] = "Query processed successfully.";
			echo "Query processed successfully.";
		} else {
			echo "Unable to process query.";
		}
	}

	public static function delete($id) {
		global $conn;
		$class = get_called_class();

		$sql = QueryBuilder::create()
			->deleteFrom((new $class)->table)
			->where('id', $id)
			->query;

		if (mysqli_query($conn, $sql)) {
			// $_SESSION['message'] = "Query processed successfully.";
			echo "Query processed successfully.";
		} else {
			echo "Unable to process query.";
		}
	}

	public function belongsTo($table, $id)
	{
		global $conn;
		$sql = QueryBuilder::create()
			->select('*')
			->from($table)
			->where('id', $id)
			->query;

		$result = mysqli_query($conn, $sql);

		$class = substr(ucfirst($table), 0, -1);

		return (new $class)->create(mysqli_fetch_assoc($result));
	}

	public function hasMany($table, $id)
	{
		global $conn;
		$sql = QueryBuilder::create()
			->select('*')
			->from($table)
			->where($id, $this->id)
			->query;

		$result = mysqli_query($conn, $sql);
		$class = substr(ucfirst($table), 0, -1);

		if (mysqli_num_rows($result) > 0) {
			$objects = array();
			while ($row = mysqli_fetch_assoc($result)) {
				$objects[] = (new $class)->create($row);
			}
			return $objects;
		}
	}

	abstract public function create($input);
}
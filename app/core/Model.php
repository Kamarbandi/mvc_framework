<?php

namespace Model;

use Exception;

defined('ROOTPATH') OR exit('Access Denied!');

/**
 * @author Azad Kamarbandi <azadkamarbandi@gmail.com>
 */
Trait Model
{
	use Database;

    protected int $limit = 10;
    protected int $offset = 0;
    protected string $order_type = 'desc';
    protected string $order_column = 'id';
    public array $errors = [];

    /**
     * @throws Exception
     * @author Azad Kamarbandi <azadkamarbandi@gmail.com>
     */
	public function findAll()
	{
        $query = "SELECT * FROM $this->table 
                  ORDER BY $this->order_column $this->order_type 
                  LIMIT $this->limit OFFSET $this->offset";

		return $this->query($query);
	}

    /**
     * @param $data
     * @param $data_not
     * @throws Exception
     * @author Azad Kamarbandi <azadkamarbandi@gmail.com>
     */
	public function where($data, $data_not = [])
	{
		$keys = array_keys($data);
		$keys_not = array_keys($data_not);
		$query = "select * from $this->table where ";

		foreach ($keys as $key) {
			$query .= $key . " = :". $key . " && ";
		}

		foreach ($keys_not as $key) {
			$query .= $key . " != :". $key . " && ";
		}
		
		$query = trim($query," && ");

		$query .= " order by $this->order_column $this->order_type limit $this->limit offset $this->offset";
		$data = array_merge($data, $data_not);

		return $this->query($query, $data);
	}

    /**
     * @param $data
     * @param $data_not
     * @throws Exception
     * @author Azad Kamarbandi <azadkamarbandi@gmail.com>
     */
	public function first($data, $data_not = [])
	{
		$keys = array_keys($data);
		$keys_not = array_keys($data_not);
		$query = "select * from $this->table where ";

		foreach ($keys as $key) {
			$query .= $key . " = :". $key . " && ";
		}

		foreach ($keys_not as $key) {
			$query .= $key . " != :". $key . " && ";
		}
		
		$query = trim($query," && ");

		$query .= " limit $this->limit offset $this->offset";
		$data = array_merge($data, $data_not);
		
		$result = $this->query($query, $data);
		if($result)
			return $result[0];

		return false;
	}

    /**
     * @param $data
     * @throws Exception
     * @author Azad Kamarbandi <azadkamarbandi@gmail.com>
     */
	public function insert($data)
	{
		if(!empty($this->allowedColumns))
		{
			foreach ($data as $key => $value) {
				
				if(!in_array($key, $this->allowedColumns))
				{
					unset($data[$key]);
				}
			}
		}

		$keys = array_keys($data);

		$query = "insert into $this->table (".implode(",", $keys).") values (:".implode(",:", $keys).")";
	 	return $this->query($query, $data);
	}

    /**
     * @param $id
     * @param $data
     * @param $id_column
     * @throws Exception
     * @author Azad Kamarbandi <azadkamarbandi@gmail.com>
     */
	public function update($id, $data, $id_column = 'id')
	{
		if(!empty($this->allowedColumns))
		{
			foreach ($data as $key => $value) {
				
				if(!in_array($key, $this->allowedColumns))
				{
					unset($data[$key]);
				}
			}
		}

		$keys = array_keys($data);
		$query = "update $this->table set ";

		foreach ($keys as $key) {
			$query .= $key . " = :". $key . ", ";
		}

		$query = trim($query,", ");

		$query .= " where $id_column = :$id_column ";

		$data[$id_column] = $id;

		return $this->query($query, $data);
	}

    /**
     * @param $id
     * @param $id_column
     * @throws Exception
     * @author Azad Kamarbandi <azadkamarbandi@gmail.com>
     */
	public function delete($id, $id_column = 'id')
	{
		$data[$id_column] = $id;
		$query = "delete from $this->table where $id_column = :$id_column ";
		return $this->query($query, $data);
	}
}
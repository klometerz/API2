<?php

//Api.php

class API
{
	private $connect = '';

	function __construct()
	{
		$this->database_connection();
	}

	function database_connection()
	{
		$this->connect = new PDO("mysql:host=localhost;dbname=testing", "root", "");
	}

	function fetch_all()
	{
		$query = "SELECT * FROM tbl_sample ORDER BY id";
		$statement = $this->connect->prepare($query);
		if($statement->execute())
		{
			while($row = $statement->fetch(PDO::FETCH_ASSOC))
			{
				$data[] = $row;
			}
			return $data;
		}
	}

	function insert()
	{
		if(isset($_POST["code"]))
		{
			$form_data = array(
				':code'		=>	$_POST["code"],
				':name'		=>	$_POST["name"],
				':descriptions'		=>	$_POST["descriptions"],
				':price'		=>	$_POST["price"]
			);
			$query = "
			INSERT INTO tbl_sample 
			(code, name, descriptions, price) VALUES 
			(:code, :name, :descriptions, :price)
			";
			$statement = $this->connect->prepare($query);
			if($statement->execute($form_data))
			{
				$data[] = array(
					'success'	=>	'1'
				);
			}
			else
			{
				$data[] = array(
					'success'	=>	'0'
				);
			}
		}
		else
		{
			$data[] = array(
				'success'	=>	'0'
			);
		}
		return $data;
	}

	function fetch_single($id)
	{
		$query = "SELECT * FROM tbl_sample WHERE id='".$id."'";
		$statement = $this->connect->prepare($query);
		if($statement->execute())
		{
			foreach($statement->fetchAll() as $row)
			{
				$data['code'] = $row['code'];
				$data['name'] = $row['name'];
				$data['descriptions'] = $row['descriptions'];
				$data['price'] = $row['price'];
			}
			return $data;
		}
	}

	function update()
	{
		if(isset($_POST["code"]))
		{
			$form_data = array(
				':code'	=>	$_POST['code'],
				':name'	=>	$_POST['name'],
				':descriptions'	=>	$_POST['descriptions'],
				':price'	=>	$_POST['price'],
				':id'			=>	$_POST['id']
			);
			$query = "
			UPDATE tbl_sample 
			SET code = :code, name = :name, descriptions = :descriptions, price = :price 
			WHERE id = :id
			";
			$statement = $this->connect->prepare($query);
			if($statement->execute($form_data))
			{
				$data[] = array(
					'success'	=>	'1'
				);
			}
			else
			{
				$data[] = array(
					'success'	=>	'0'
				);
			}
		}
		else
		{
			$data[] = array(
				'success'	=>	'0'
			);
		}
		return $data;
	}
	function delete($id)
	{
		$query = "DELETE FROM tbl_sample WHERE id = '".$id."'";
		$statement = $this->connect->prepare($query);
		if($statement->execute())
		{
			$data[] = array(
				'success'	=>	'1'
			);
		}
		else
		{
			$data[] = array(
				'success'	=>	'0'
			);
		}
		return $data;
	}
}

?>
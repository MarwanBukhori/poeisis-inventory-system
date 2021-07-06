<?php
header("Content-Type: application/json;Charset=UTF-8");
require 'database.php';

$Json = array();
if (isset($_GET['search'])) {
	//senang sikit nk ubahhh
	$field = ['fld_product_name', 'fld_type' , 'fld_origin'];
	$search = htmlspecialchars($_GET['search']);
	$data = explode(" ", $search);

	$name = (isset($data[0]) ? $data[0] : '');
	$type = (isset($data[1]) ? $data[1] : '');
	$origin = (isset($data[2]) ? $data[2] : '');

	try {
		//kalo nk search pastu dapat specific product. like nk dapat product tu je
		/*if(count($data)<3){
			 $stmt = $db->prepare("SELECT * FROM `tbl_products_a173586` WHERE {$field[0]} LIKE ? OR {$field[1]} LIKE ? OR {$field[2]} LIKE ?");
			 $stmt->execute(["%{$search}%","%{$search}%", "%{$search}%"]);
		}
		elseif(count($data)==3){
			$stmt = $db->prepare("SELECT * FROM `tbl_products_a173586` WHERE {$field[0]} LIKE ? AND {$field[1]} LIKE ? AND {$field[2]} LIKE ?");
			$stmt->execute(["%{$name}%","%{$price}%", "%{$brand}%"]);
		}*/


		//kalo nk search any keyword and return all row yg ade words tu(harap faham). Tak kisah berapa perkataan pun
		$queries = array();
		foreach($data as $dat){
			$queries[] = "SELECT * FROM `tbl_products_a174856_pt2` WHERE {$field[0]} LIKE '%{$dat}%' OR {$field[1]} LIKE '%{$dat}%' OR {$field[2]} LIKE '%{$dat}%'";
		}
		$sql = implode(' UNION ',$queries);//kalo nk tukr ni jadi INTERSECT untuk dapat refined search
		$stmt = $db->prepare($sql);


		//penting for both cara
		$stmt->execute();
		$res = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$Json = array('status' => 200, 'data' => $res);
	} catch (PDOException $e) {
		$Json = array('status' => 400, 'data' => $e->getMessage());
	}

}

if (isset($Json))
	echo json_encode($Json);

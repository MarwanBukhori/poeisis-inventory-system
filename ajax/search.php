<?php
header("Content-Type: application/json;Charset=UTF-8");
require '../database.php';

$Json = array();

if (isset($_POST['search'])) {

    $field = ['fld_product_name', 'fld_type' , 'fld_origin'];
    $search = htmlspecialchars($_POST['search']);
    $data = explode(" ", $search);

    $name = (isset($data[0]) ? $data[0] : '');
	$type = (isset($data[1]) ? $data[1] : '');
	$origin = (isset($data[2]) ? $data[2] : '');
  
    // 0 - name
    // 1 - type
    // 2 - origin
    
    # check if $ is set and will return true user search
    
    #terniary operator, $ = data or '' 

    try {
        $stmt = $db->prepare("SELECT * FROM `tbl_products_a174856_pt2` WHERE fld_product_name LIKE ? OR fld_type LIKE ? OR fld_origin LIKE ?");
        $stmt->execute(["%{$search}%","%{$search}%", "%{$search}%"]);
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $Json = array('status' => 200, 'data' => $res);
    } catch (PDOException $e) {
        $Json = array('status' => 400, 'data' => $e->getMessage());
    }

}

if (isset($Json))
    echo json_encode($Json);

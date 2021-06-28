<?php
 
include_once 'database.php';

if (!isset($_SESSION['loggedin']))
    header("LOCATION: login.php");
 

 
//Create
if (isset($_POST['create'])) {
 
  try {
 
      $stmt = $db->prepare("INSERT INTO tbl_products_a174856_pt2(fld_product_id,
        fld_product_name, fld_price, fld_type, fld_weight,
        fld_description, fld_origin) VALUES(:pid, :name, :price, :type,
        :weight, :desc, :origin)");
     
      $stmt->bindParam(':pid', $pid, PDO::PARAM_STR);
      $stmt->bindParam(':name', $name, PDO::PARAM_STR);
      $stmt->bindParam(':price', $price, PDO::PARAM_INT);
      $stmt->bindParam(':type', $type, PDO::PARAM_STR);
      $stmt->bindParam(':weight', $weight, PDO::PARAM_INT);
      $stmt->bindParam(':desc', $desc, PDO::PARAM_STR);
      $stmt->bindParam(':origin', $origin, PDO::PARAM_STR);
       
    $pid = $_POST['pid'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $type =  $_POST['type'];
    $weight = $_POST['weight'];
    $desc = $_POST['desc'];
    $origin = $_POST['origin'];
     
    $stmt->execute();
    }
 
  catch(PDOException $e)
  {
      echo "Error: " . $e->getMessage();
  }
}
 
//Update
if (isset($_POST['update'])) {
 
  try {
 
      $stmt = $db->prepare("UPDATE tbl_products_a174856_pt2 SET fld_product_id = :pid,
        fld_product_name = :name, fld_price = :price, fld_type = :type,
        fld_weight = :weight, fld_description = :desc, fld_origin = :origin
        WHERE fld_product_id = :oldpid");
     
      $stmt->bindParam(':pid', $pid, PDO::PARAM_STR);
      $stmt->bindParam(':name', $name, PDO::PARAM_STR);
      $stmt->bindParam(':price', $price, PDO::PARAM_INT);
      $stmt->bindParam(':type', $type, PDO::PARAM_STR);
      $stmt->bindParam(':weight', $weight, PDO::PARAM_INT);
      $stmt->bindParam(':desc', $desc, PDO::PARAM_STR);
      $stmt->bindParam(':origin', $origin, PDO::PARAM_STR);
      $stmt->bindParam(':oldpid', $oldpid, PDO::PARAM_STR);
       
    $pid = $_POST['pid'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $type =  $_POST['type'];
    $weight = $_POST['weight'];
    $desc = $_POST['desc'];
    $origin = $_POST['origin'];
    $oldpid = $_POST['oldpid'];
     
    $stmt->execute();
 
    header("Location: products.php");
    }
 
  catch(PDOException $e)
  {
      echo "Error: " . $e->getMessage();
  }
}
 
//Delete
if (isset($_GET['delete'])) {
 
  try {
 
      $stmt = $db->prepare("DELETE FROM tbl_products_a174856_pt2 WHERE fld_product_id = :pid");
     
      $stmt->bindParam(':pid', $pid, PDO::PARAM_STR);
       
    $pid = $_GET['delete'];
     
    $stmt->execute();
 
    header("Location: products.php");
    }
 
  catch(PDOException $e)
  {
      echo "Error: " . $e->getMessage();
  }
}
 
//Edit
if (isset($_GET['edit'])) {
 
  try {
 
    $stmt = $db->prepare("SELECT * FROM tbl_products_a174856_pt2 WHERE fld_product_id = :pid");
     
    $stmt->bindParam(':pid', $pid, PDO::PARAM_STR);
       
    $pid = $_GET['edit'];
     
    $stmt->execute();
 
    $editrow = $stmt->fetch(PDO::FETCH_ASSOC);
    
    }
 
  catch(PDOException $e)
  {
      echo "Error: " . $e->getMessage();
  }
}
 


 // get next id 
 $lastid = $db->query("SELECT MAX(fld_product_id) AS lastid FROM tbl_products_a174856_pt2")->fetch();
 $lastid_str = implode("",$lastid);
 $nextid = "P". substr($lastid_str, 1,3) +1 ;
 
 $db = null;

?>
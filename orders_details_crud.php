<?php
 
include_once 'database.php';

if (!isset($_SESSION['loggedin']))
    header("LOCATION: login.php");
 

 
//Create
if (isset($_POST['addproduct'])) {
 
  try {
 
    $stmt = $db->prepare("INSERT INTO tbl_orders_details_a174856(fld_order_detail_num,
      fld_order_num, fld_product_num, fld_order_detail_quantity) VALUES(:did, :oid,
      :pid, :quantity)");
   
    $stmt->bindParam(':did', $did, PDO::PARAM_STR);
    $stmt->bindParam(':oid', $oid, PDO::PARAM_STR);
    $stmt->bindParam(':pid', $pid, PDO::PARAM_STR);
    $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
       
    $did = uniqid('D', true);
    $oid = $_POST['oid'];
    $pid = $_POST['pid'];
    $quantity= $_POST['quantity'];
     
    $stmt->execute();
    }
 
  catch(PDOException $e)
  {
      echo "Error: " . $e->getMessage();
  }
  $_GET['oid'] = $oid;
}
 
//Delete
if (isset($_GET['delete'])) {
 
  try {
 
    $stmt = $db->prepare("DELETE FROM tbl_orders_details_a174856 where fld_order_detail_num = :did");
   
    $stmt->bindParam(':did', $did, PDO::PARAM_STR);
       
    $did = $_GET['delete'];
     
    $stmt->execute();
 
    header("Location: orders_details.php?oid=".$_GET['oid']);
    }
 
  catch(PDOException $e)
  {
      echo "Error: " . $e->getMessage();
  }
}
 
?>
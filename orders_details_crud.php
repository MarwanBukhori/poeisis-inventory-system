<?php
 
include_once 'database.php';

if (!isset($_SESSION['loggedin']))
    header("LOCATION: login.php");
 
if (!isset($_GET['oid']))
    header("LOCATION: orders.php");
 
//Create
# if user tekan submit button addproduct then...
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
    $_SESSION['error'] = "Error while adding: " . $e->getMessage();
  }
  $_GET['oid'] = $oid;
  header("LOCATION: {$_SERVER['PHP_SELF']}?oid={$_GET['oid']}");
  exit();
}
 
//Delete
if (isset($_GET['delete'])) {
 
  try {
 
    $stmt = $db->prepare("DELETE FROM tbl_orders_details_a174856 where fld_order_detail_num = :did");
   
    $stmt->bindParam(':did', $did, PDO::PARAM_STR);
       
    $did = $_GET['delete'];
     
    $stmt->execute();
 
   
    }
 
  catch(PDOException $e)
  {
    $_SESSION['error'] = "Error: " . $e->getMessage();
  }

  header("LOCATION: {$_SERVER['PHP_SELF']}?oid={$_GET['oid']}");
  exit();

}
 
?>
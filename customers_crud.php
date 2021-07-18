<?php
 
include_once 'database.php';

if (!isset($_SESSION['loggedin']))
    header("LOCATION: login.php");
 
$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 
//Create
if (isset($_POST['create'])) {
    if (isset($_SESSION['user']) && $_SESSION['user']['fld_staff_role'] == 'admin') {
    try {
   
      $stmt = $conn->prepare("INSERT INTO tbl_customers_a174856_pt2(fld_cust_id, fld_cust_name, 
        fld_cust_phone, fld_cust_address) VALUES(:cid, :name,
         :phone, :address)");
     
     $stmt->bindParam(':cid', $cid, PDO::PARAM_STR);
     $stmt->bindParam(':name', $name, PDO::PARAM_STR);
     $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
     $stmt->bindParam(':address', $address, PDO::PARAM_STR);
  
     $cid = $_POST['cid'];
     $name = $_POST['name'];
     $phone = $_POST['phone'];
     $address = $_POST['address'];
    
           
      $stmt->execute();
      }
   
      catch (PDOException $e) {
         $_SESSION['error'] = "Error while creating: " . $e->getMessage();
    }
  
  }else{
      $_SESSION['error'] = "Sorry, but you don't have permission to create a new customer.";
  }
  
    header("LOCATION: {$_SERVER['REQUEST_URI']}");
    exit();
  
  }
 
 
//Update
if (isset($_POST['update'])) {
    if (isset($_SESSION['user']) && $_SESSION['user']['fld_staff_role'] == 'admin') {
    try {
   
      $stmt = $db->prepare("UPDATE tbl_customers_a174856_pt2 SET fld_cust_name = :name, fld_cust_phone = :phone, fld_cust_address = :address WHERE fld_cust_id = :oldcid");
   
    /*$stmt->bindParam(':cid', $sid, PDO::PARAM_STR);
    */
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
    $stmt->bindParam(':address', $address, PDO::PARAM_STR);

    $stmt->bindParam(':oldcid', $oldcid, PDO::PARAM_STR);
       
   /*  $sid = $_POST['sid']; */
    $name = $_POST['name'];  
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $oldcid = $_POST['oldcid'];
         
    $stmt->execute();
   
    }catch(PDOException $e)
    {
      $_SESSION['error'] = "Error while updating: " . $e->getMessage();
      header("LOCATION: {$_SERVER['REQUEST_URI']}");
      exit();
    }
    } else {
      $_SESSION['error'] = "Sorry, but you don't have permission to update customer.";
  }
  
  header("LOCATION: {$_SERVER['PHP_SELF']}");
  exit();
  }
   



 
//Delete
if (isset($_GET['delete'])) {

  if (isset($_SESSION['user']) && $_SESSION['user']['fld_staff_role'] == 'admin') {
    try {
        $stmt = $conn->prepare("DELETE FROM tbl_customers_a174856_pt2 WHERE fld_cust_id = :cid");
        $stmt->bindParam(':cid', $cid, PDO::PARAM_STR);

        $cid = $_GET['delete'];

        $stmt->execute();
    } catch (PDOException $e) {
        $_SESSION['error'] = "Error while deleting: " . $e->getMessage();
    }
} else {
    $_SESSION['error'] = "Sorry, but you don't have permission to delete customer.";
}

header("LOCATION: {$_SERVER['PHP_SELF']}");
exit();

}
 
//Edit
//Edit
if (isset($_GET['edit'])) {
    if (isset($_SESSION['user']) && $_SESSION['user']['fld_staff_role'] == 'admin') {
    try {
   
      $stmt = $db->prepare("SELECT * FROM tbl_customers_a174856_pt2 where fld_cust_id = :cid");
     
      $stmt->bindParam(':cid', $cid, PDO::PARAM_STR);
         
      $cid = $_GET['edit'];
       
      $stmt->execute();
   
      $editrow = $stmt->fetch(PDO::FETCH_ASSOC);
      }
   
    catch(PDOException $e)
    {
      $_SESSION['error'] = "Error: " . $e->getMessage();
      header("LOCATION: {$_SERVER['PHP_SELF']}");
      exit();
    }
  
  }else{
    $_SESSION['error'] = "Sorry, but you don't have permission to edit a customer.";
    header("LOCATION: {$_SERVER['PHP_SELF']}");
    exit();
  }
  }
 
//coding ni tk perlu guna. ni untuk aku punye auto increment je
$num = $db->query("SELECT MAX(fld_cust_id) AS cid FROM tbl_customers_a174856_pt2")->fetch()['cid'];


	$num = ltrim($num, 'C')+1; 
	
	$num = 'C'.$num
 
?>
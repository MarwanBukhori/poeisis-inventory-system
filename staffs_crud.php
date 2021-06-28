<?php
 
include_once 'database.php';
 

if (!isset($_SESSION['loggedin']))
    header("LOCATION: login.php");


 
//Create
if (isset($_POST['create'])) {
 
  try {
 
    $stmt = $db->prepare("INSERT INTO tbl_staffs_a174856_pt2(fld_staff_id, fld_staff_name, fld_staff_phone,
      fld_staff_address) VALUES(:sid, :name, :phone, :address)");
   
   $stmt->bindParam(':sid', $sid, PDO::PARAM_STR);
   $stmt->bindParam(':name', $name, PDO::PARAM_STR);
   $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
   $stmt->bindParam(':address', $address, PDO::PARAM_STR);
      
   $sid = $_POST['sid'];
   $name = $_POST['name'];
   $phone = $_POST['phone'];
   $address = $_POST['address'];
         
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
 
    $stmt = $db->prepare("UPDATE tbl_staffs_a174856_pt2 SET
    fld_staff_id = :sid, fld_staff_name = :name,
    fld_staff_phone = :phone, fld_staff_address = :address
    WHERE fld_staff_id = :oldsid");
 
  $stmt->bindParam(':sid', $sid, PDO::PARAM_STR);
  $stmt->bindParam(':name', $name, PDO::PARAM_STR);
  $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
  $stmt->bindParam(':address', $address, PDO::PARAM_STR);
  $stmt->bindParam(':oldsid', $oldsid, PDO::PARAM_STR);
     
  $sid = $_POST['sid'];
  $name = $_POST['name'];
  $phone = $_POST['phone'];
  $address = $_POST['address'];
  $oldsid = $_POST['oldsid'];
       
  $stmt->execute();
    header("Location: staffs.php");
    }
 
  catch(PDOException $e)
  {
      echo "Error: " . $e->getMessage();
  }
}
 
//Delete
if (isset($_GET['delete'])) {
 
  try {
 
    $stmt = $db->prepare("DELETE FROM tbl_staffs_a174856_pt2 where fld_staff_id = :sid");
   
    $stmt->bindParam(':sid', $sid, PDO::PARAM_STR);
       
    $sid = $_GET['delete'];
     
    $stmt->execute();
 
    header("Location: staffs.php");
    }
 
  catch(PDOException $e)
  {
      echo "Error: " . $e->getMessage();
  }
}
 
//Edit
if (isset($_GET['edit'])) {
   
  try {
 
    $stmt = $db->prepare("SELECT * FROM tbl_staffs_a174856_pt2 where fld_staff_id = :sid");
   
    $stmt->bindParam(':sid', $sid, PDO::PARAM_STR);
       
    $sid = $_GET['edit'];
     
    $stmt->execute();
 
    $editrow = $stmt->fetch(PDO::FETCH_ASSOC);
    }
 
  catch(PDOException $e)
  {
      echo "Error: " . $e->getMessage();
  }
}
 
// get next id 
$lastid = $db->query("SELECT MAX(fld_staff_id) AS lastid FROM tbl_staffs_a174856_pt2")->fetch();
$lastid_str = implode("",$lastid);
$nextid = "S". substr($lastid_str, 1,3) +1 ;

$db = null;
 


?>

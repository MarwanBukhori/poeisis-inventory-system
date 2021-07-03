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
 
    $stmt = $conn->prepare("INSERT INTO tbl_staffs_a174856_pt2(fld_staff_id, fld_staff_name, 
      fld_staff_phone, fld_staff_address, fld_staff_email, fld_staff_password, fld_staff_role) VALUES(:sid, :name,
       :phone, :address, :email, :password , :role)");
   
   $stmt->bindParam(':sid', $sid, PDO::PARAM_STR);
   $stmt->bindParam(':name', $name, PDO::PARAM_STR);
   $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
   $stmt->bindParam(':address', $address, PDO::PARAM_STR);
   $stmt->bindParam(':email', $email, PDO::PARAM_STR);
   $stmt->bindParam(':password', $password, PDO::PARAM_STR);
   $stmt->bindParam(':role', $role, PDO::PARAM_STR);
      
   $sid = $_POST['sid'];
   $name = $_POST['name'];
   $phone = $_POST['phone'];
   $address = $_POST['address'];
   $email = $_POST['email'];
   $password = $_POST['password'];
   $role = $_POST['role'];
         
    $stmt->execute();
    }
 
    catch (PDOException $e) {
       $_SESSION['error'] = "Error while creating: " . $e->getMessage();
  }

}else{
    $_SESSION['error'] = "Sorry, but you don't have permission to create a new staff.";
}

  header("LOCATION: {$_SERVER['REQUEST_URI']}");
  exit();

}
 
//Update
if (isset($_POST['update'])) {
  if (isset($_SESSION['user']) && $_SESSION['user']['fld_staff_role'] == 'admin') {
  try {
 
    $stmt = $db->prepare("UPDATE tbl_staffs_a174856_pt2 SET
    fld_staff_id = :sid, fld_staff_name = :name,
    fld_staff_phone = :phone, fld_staff_address = :address, fld_staff_email = :email, fld_staff_password = :password, fld_staff_role = :role
    WHERE fld_staff_id = :oldsid");
 
  $stmt->bindParam(':sid', $sid, PDO::PARAM_STR);
  $stmt->bindParam(':name', $name, PDO::PARAM_STR);
  $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
  $stmt->bindParam(':address', $address, PDO::PARAM_STR);
  $stmt->bindParam(':email', $address, PDO::PARAM_STR);
  $stmt->bindParam(':password', $address, PDO::PARAM_STR);
  $stmt->bindParam(':role', $address, PDO::PARAM_STR);
  $stmt->bindParam(':oldsid', $oldsid, PDO::PARAM_STR);
     
  $sid = $_POST['sid'];
  $name = $_POST['name'];
  $role = $_POST['role'];
  $phone = $_POST['phone'];
  $address = $_POST['address'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $role = $_POST['role'];
  $oldsid = $_POST['oldsid'];
       
  $stmt->execute();
 
  }catch(PDOException $e)
  {
    $_SESSION['error'] = "Error while updating: " . $e->getMessage();
    header("LOCATION: {$_SERVER['REQUEST_URI']}");
    exit();
  }
  } else {
    $_SESSION['error'] = "Sorry, but you don't have permission to update staff.";
}

header("LOCATION: {$_SERVER['PHP_SELF']}");
exit();


}
 
//Delete
if (isset($_GET['delete'])) {
  if (isset($_SESSION['user']) && $_SESSION['user']['fld_staff_role'] == 'admin') {
  try {
 
    $stmt = $db->prepare("DELETE FROM tbl_staffs_a174856_pt2 where fld_staff_id = :sid");  
    $stmt->bindParam(':sid', $sid, PDO::PARAM_STR);
    $sid = $_GET['delete'];     
    $stmt->execute();

    }
 
  catch(PDOException $e)
  {
      echo "Error: " . $e->getMessage();
  }

} else{
  $_SESSION['error'] = "Sorry, but you don't have permission to delete staff.";
}

header("LOCATION: {$_SERVER['PHP_SELF']}");
    exit();
}
 
//Edit
if (isset($_GET['edit'])) {
  if (isset($_SESSION['user']) && $_SESSION['user']['fld_staff_role'] == 'admin') {
  try {
 
    $stmt = $db->prepare("SELECT * FROM tbl_staffs_a174856_pt2 where fld_staff_id = :sid");
   
    $stmt->bindParam(':sid', $sid, PDO::PARAM_STR);
       
    $sid = $_GET['edit'];
     
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
  $_SESSION['error'] = "Sorry, but you don't have permission to edit a staff.";
  header("LOCATION: {$_SERVER['PHP_SELF']}");
  exit();
}


}
 
// get next id 
$lastid = $db->query("SELECT MAX(fld_staff_id) AS lastid FROM tbl_staffs_a174856_pt2")->fetch();
$lastid_str = implode("",$lastid);
$nextid = "S". substr($lastid_str, 1,3) +1 ;

$db = null;
 

?>
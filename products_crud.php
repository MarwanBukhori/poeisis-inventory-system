<?php
 
include_once 'database.php';

if (!isset($_SESSION['loggedin']))
    header("LOCATION: login.php");
 
function uploadPhoto($file, $id)
{
        $target_dir = "products/";
        $target_file = $target_dir . basename($file["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowedExt = ['gif'];
    
        $newfilename = "{$id}.{$imageFileType}";
    
        /*
         * 0 = image file is a fake image
         * 1 = file is too large.
         * 2 = PNG & GIF files are allowed
         * 3 = Server error
         * 4 = No file were uploaded
         */
    
        if ($file['error'] == 4)
            return 4;
    
        // Check if image file is a actual image or fake image
        if (!getimagesize($file['tmp_name']))
            return 0;
    
        // Check file size
        if ($file["size"] > 10000000)
            return 1;
    
        // Allow certain file formats
        if (!in_array($imageFileType, $allowedExt))
            return 2;
    
        if (!move_uploaded_file($file["tmp_name"], $target_dir . $newfilename))
            return 3;
    
        return array('status' => 200, 'name' => $newfilename, 'ext' => $imageFileType);
}
 
//Create
if (isset($_POST['create'])) {
    if (isset($_SESSION['user']) && $_SESSION['user']['fld_staff_role'] == 'admin') {
    $uploadStatus = uploadPhoto($_FILES['fileToUpload'], $_POST['pid']);

      if(isset($uploadStatus['status'])) {


          try {
 
             $stmt = $db->prepare("INSERT INTO tbl_products_a174856_pt2(fld_product_id, fld_product_name, fld_price, fld_type, fld_weight,
                    fld_description, fld_origin, fld_product_image) VALUES(:pid, :name, :price, :type,
                    :weight, :desc, :origin, :image)");

                    $stmt->bindParam(':pid', $pid, PDO::PARAM_STR);
                    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
                    $stmt->bindParam(':price', $price, PDO::PARAM_INT);
                    $stmt->bindParam(':type', $type, PDO::PARAM_STR);
                    $stmt->bindParam(':weight', $weight, PDO::PARAM_INT);
                    $stmt->bindParam(':desc', $desc, PDO::PARAM_STR);
                    $stmt->bindParam(':origin', $origin, PDO::PARAM_STR);
                    $stmt->bindParam(':image', $uploadStatus['name']);
       
                    $pid = $_POST['pid'];
                    $name = $_POST['name'];
                    $price = $_POST['price'];
                    $type =  $_POST['type'];
                    $weight = $_POST['weight'];
                    $desc = $_POST['desc'];
                    $origin = $_POST['origin'];
     
                    $stmt->execute();
              } catch(PDOException $e) {
                $_SESSION['error'] = "Error while creating: " . $e->getMessage();
              }
      }else{
          if ($uploadStatus == 0)
            $_SESSION['error'] = "Please make sure the file uploaded is an image.";
          elseif ($uploadStatus == 1)
            $_SESSION['error'] = "Sorry, only file with below 10MB are allowed.";
          elseif ($uploadStatus == 2)
            $_SESSION['error'] = "Sorry, only GIF files are allowed.";
          elseif ($uploadStatus == 3)
            $_SESSION['error'] = "Sorry, there was an error uploading your file.";
          elseif ($uploadStatus == 4)
             $_SESSION['error'] = 'Please upload an image.';
          else
            $_SESSION['error'] = "An unknown error has been occurred.";
      }

    } else {
      $_SESSION['error'] = "Sorry, but you don't have permission to create a new customer.";
    }

      header("LOCATION: {$_SERVER['REQUEST_URI']}");
      exit();
  }
 
//Update
if (isset($_POST['update'])) {
 
  if (isset($_SESSION['user']) && $_SESSION['user']['fld_staff_role'] == 'admin') {

       try {
 
        $stmt = $db->prepare("UPDATE tbl_products_a174856_pt2 SET 
                fld_product_name = :name, fld_price = :price, fld_type = :type,
                fld_weight = :weight, fld_description = :desc, fld_origin = :origin
                WHERE fld_product_id = :pid ");
        
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

        // Image Upload
        $flag = uploadPhoto($_FILES['fileToUpload'], $_POST['pid']);
    
        if (isset($flag['status'])) {
        
            $stmt = $db->prepare("UPDATE tbl_products_a174856_pt2 SET fld_product_image = :image WHERE fld_product_id = :pid LIMIT 1");

            $stmt->bindParam(':image', $flag['name']);
            $stmt->bindParam(':pid', $pid);
            $stmt->execute();

          // Rename file after upload (IF NEEDED)
          // rename("products/{$uploadStatus['name']}", "products/{$oldpid}.{$uploadStatus['ext']}");
        } elseif ($flag != 4) {
      
            if ($flag == 0)
                $_SESSION['error'] = "Please make sure the file uploaded is an image.";
            elseif ($flag == 1)
              $_SESSION['error'] = "Sorry, only file with below 10MB are allowed.";
            elseif ($flag == 2)
              $_SESSION['error'] = "Sorry, only PNG & GIF files are allowed.";
            elseif ($flag == 3)
              $_SESSION['error'] = "Sorry, there was an error uploading your file.";
            else
              $_SESSION['error'] = "An unknown error has been occurred.";
         }
    
      } catch (PDOException $e) {
          $_SESSION['error'] = "Error while updating: " . $e->getMessage();
      
      } catch (Exception $e) {
          $_SESSION['error'] = "Error while updating: " . $e->getMessage();
      }
  
    } else {
        
         $_SESSION['error'] = "Sorry, but you don't have permission to update this product.";
         header("LOCATION: {$_SERVER['PHP_SELF']}");
        
         exit();
    }
  
  if (isset($_SESSION['error']))
    header("LOCATION: {$_SERVER['REQUEST_URI']}");
  else
    header("Location: {$_SERVER['PHP_SELF']}");
      
  exit();
}
 
//Delete
if (isset($_GET['delete'])) {
    if (isset($_SESSION['user']) && $_SESSION['user']['fld_staff_role'] == 'admin') {
      try {
          $pid = $_GET['delete'];
          
          // Select Product Image Name
          $query = $db->query("SELECT fld_product_image FROM tbl_products_a174856_pt2 WHERE fld_product_id = '{$pid}' LIMIT 1")->fetch(PDO::FETCH_ASSOC);
          
          // Check if selected product id exists .
          if (isset($query['fld_product_image'])) {
            // Delete Query
            $stmt = $db->prepare("DELETE FROM tbl_products_a174856_pt2 WHERE fld_product_id = :pid");
            $stmt->bindParam(':pid', $pid);

            $stmt->execute();

            // Delete Image
            unlink("products/{$query['fld_product_image']}");
          }
      } catch (PDOException $e) {
        $_SESSION['error'] = "Error while deleting: " . $e->getMessage();
    }
  } else {
          $_SESSION['error'] = "Sorry, but you don't have permission to delete this product.";
    }
}
 
//Edit
if (isset($_GET['edit'])) {
  if (isset($_SESSION['user']) && $_SESSION['user']['fld_staff_role'] == 'admin') {
        
    try {
        $stmt = $db->prepare("SELECT * FROM tbl_products_a174856_pt2 WHERE fld_product_id = :pid");
        $stmt->bindParam(':pid', $pid, PDO::PARAM_STR);   
        $pid = $_GET['edit'];
        $stmt->execute();
 
        $editrow = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if(empty($editrow['fld_product_image']))
          $editrow['fld_product_image'] = $editrow['fld_product_id']. '.png';
        
    } catch (PDOException $e) {
      $_SESSION['error'] = "Error: " . $e->getMessage();
    }

  } else{
    $_SESSION['error'] = "Sorry, but you don't have permission to edit a customer.";
  }
  if (isset($_SESSION['error'])) {
    header("LOCATION: {$_SERVER['PHP_SELF']}");
    exit();
  }
}


 // get next id 
 $lastid = $db->query("SELECT MAX(fld_product_id) AS lastid FROM tbl_products_a174856_pt2")->fetch();
 $lastid_str = implode("",$lastid);
 $nextid = "P". substr($lastid_str, 1,3) +1 ;
 
 $db = null;

?>
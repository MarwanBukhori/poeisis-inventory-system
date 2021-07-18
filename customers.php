<?php
include_once 'customers_crud.php';
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <title>Poeisis Animal Shop : Customers</title>
  <!-- Font -->
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Pacifico" rel="stylesheet">
  
  <!-- Bootstrap -->
  <link href="css/bootstrap.min.css" rel="stylesheet">
  
  <link href="style/products.css" rel="stylesheet">
  <link rel="shortcut icon" type="image/jpg" href="favicon.ico" />
  

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>

<body style="background-color: #0070cc;">
  <?php include_once 'nav_bar.php'; ?>

  <div class="container">
    <div class="row">
      <div class="col col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
        <div class="page-header">
          <?php
          #Bila user tekan edit button
          if (isset($_GET['edit'])) {
            echo "<h2>Editing {$cid}</h2>";
          } else {
            echo "<h2>Create New Customer</h2>";
          }
          ?>

        <?php
            if (isset($_SESSION['error'])) {
                echo "<p class='text-danger text-center'>{$_SESSION['error']}</p>";
                unset($_SESSION['error']);
            }
            ?>
        </div>

        

        <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" class="form-horizontal">
          <?php
          if (isset($_GET['edit'])) {
            echo '<input type="hidden" name="cid" value="'.$editrow['fld_cust_id'].'" />';
          }
          ?>
          <div class="form-group">
            <label for="customerid" class="col-sm-3 control-label">Customer ID</label>
            <div class="col-sm-9 inputfield">
              <input name="cid" type="text" class="form-control" id="customerid" placeholder="Customer ID"
                value="<?php echo (isset($_GET['edit']) ? $cid : $num); ?>" required readonly>
            </div>
          </div>

          <div class="form-group">
            <label for="fullname" class="col-sm-3 control-label">Name</label>
            <div class="col-sm-9 inputfield">
              <input name="name" type="text" class="form-control" id="name" placeholder="Name"
                value="<?php if(isset($_GET['edit'])) echo $editrow['fld_cust_name']; ?>" required />
            </div>
          </div>

          <div class="form-group">
            <label for="address" class="col-sm-3 control-label">Address</label>
            <div class="col-sm-9 inputfield">
              <textarea name="address" type="text" class="form-control" id="address" placeholder="Address" rows="5"
                style="resize:none;"
                required><?php if(isset($_GET['edit'])) echo $editrow['fld_cust_address']; ?></textarea>
            </div>
          </div>

          <div class="form-group">
            <label for="phone" class="col-sm-3 control-label">Phone Number</label>
            <div class="col-sm-9 inputfield">
              <input name="phone" type="tel" class="form-control" id="phone" pattern="\+60\d{2}-(\d{7}|\d{8})$"
                placeholder="Phone Number : +60##-#######" value="<?php if(isset($_GET['edit'])) echo $editrow['fld_cust_phone']; ?>"
                required /> <!--\+60\d{2}-\d{7}-->
            </div>
          </div>

          <div class="form-group">
            <div class="col-sm-offset-3 col-sm-9 inputfield">
              <?php if (isset($_GET['edit'])) { ?>
              <input type="hidden" name="oldcid" value="<?php echo $editrow['fld_cust_id']; ?>">
              <button class="btn btn-default" type="submit" name="update"><span class="glyphicon glyphicon-pencil"
                  aria-hidden="true"></span> Update</button>
              <?php } else { ?>
              <button class="btn btn-default" type="submit" name="create"><span class="glyphicon glyphicon-plus"
                  aria-hidden="true"></span> Create</button>
              <?php } ?>
              <button class="btn btn-default" type="reset"><span class="glyphicon glyphicon-erase"
                  aria-hidden="true"></span> Clear</button>
            </div>
          </div>
        </form>
      </div>
    </div>
    
    <hr />
    <div class="row">
      <div class="tbl col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
        <div class="page-header">
          <h2>Customer List</h2>
        </div>
        <table class="table table-bordered table-hover table-striped">
          <tr id="table-header">
            <th>Customer ID</th>
            <th>Name</th>
            <th>Adress</th>
            <th>Phone Number</th>
            <th></th>
          </tr>
          <?php
          // Read
          $per_page = 5;
          if (isset($_GET["page"]))
            $page = $_GET["page"];
          else
            $page = 1;
          $start_from = ($page-1) * $per_page;
          try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare("SELECT * FROM tbl_customers_a174856_pt2 LIMIT $start_from, $per_page");
            $stmt->execute();
            $result = $stmt->fetchAll();
          }
          catch(PDOException $e){
            echo "Error: " . $e->getMessage();
          }
          foreach($result as $readrow) {
            ?>
          <tr>
            <td><?php echo $readrow['fld_cust_id']; ?></td>
            <td><?php echo $readrow['fld_cust_name']; ?></td>
            <td><?php echo $readrow['fld_cust_address']; ?></td>
            <td><?php echo $readrow['fld_cust_phone']; ?></td>
            <td class="text-center">
                           
                                <a style="margin:2px;" href="customers.php?edit=<?php echo $readrow['fld_cust_id']; ?>"
                                   class="btn btn-success btn-xs" role="button"> Edit </a>
                                <a style="margin:2px;" href="customers.php?delete=<?php echo $readrow['fld_cust_id']; ?>"
                                   onclick="return confirm('Are you sure to delete?');"
                                   class="btn btn-danger btn-xs"
                                   role="button">Delete</a>
                                <?php
                            
                            ?>
                        </td>
          </tr>
          <?php } ?>

        </table>
      </div>
    </div>

    <div class="row">
      <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
        <nav>
          <ul class="pagination">
            <?php
            try {
              $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
              $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
              $stmt = $conn->prepare("SELECT * FROM tbl_customers_a174856_pt2");
              $stmt->execute();
              $result = $stmt->fetchAll();
              $total_records = count($result);
            }
            catch(PDOException $e){
              echo "Error: " . $e->getMessage();
            }
            $total_pages = ceil($total_records / $per_page);
            ?>
            <?php if ($page==1) { ?>
            <li class="disabled"><span aria-hidden="true">«</span></li>
            <?php } else { ?>
            <li><a href="customers.php?page=<?php echo $page-1 ?>" aria-label="Previous"><span
                  aria-hidden="true">«</span></a></li>
            <?php
            }
            for ($i=1; $i<=$total_pages; $i++)
              if ($i == $page)
                echo "<li class=\"active\"><a href=\"customers.php?page=$i\">$i</a></li>";
              else
                echo "<li><a href=\"customers.php?page=$i\">$i</a></li>";
              ?>
            <?php if ($page==$total_pages) { ?>
            <li class="disabled"><span aria-hidden="true">»</span></li>
            <?php } else { ?>
            <li><a href="customers.php?page=<?php echo $page+1 ?>" aria-label="Previous"><span
                  aria-hidden="true">»</span></a></li>
            <?php } ?>
          </ul>
        </nav>
      </div>
    </div>
  </div>

  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="js/bootstrap.min.js"></script>
</body>

</html>
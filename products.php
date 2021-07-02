<?php
  include_once 'products_crud.php';
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <title>Poiesis Animal Shop : Products</title>
  <!-- Bootstrap -->
  <link href="css/bootstrap.min.css" rel="stylesheet">

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

  <style>
    input[type="file"] {
      display: none;
    }
  </style>

</head>

<body>

  <?php include_once 'nav_bar.php'; ?>


  <div class="container-fluid dark" style="padding-bottom: 30px;">
    <div class="container">
      <div class="row">
        <div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
          <div class="page-header">

            <?php
          if(isset($editrow) && count($editrow) > 0) {
            echo "<h2>Editing ".$pid."</h2>";
          } else {
            echo "<h2>Create New Product</h2>";
          }
      ?>
            <?php
                if (isset($_SESSION['error'])) {
                    echo "<p class='text-danger text-center'>{$_SESSION['error']}</p>";
                    unset($_SESSION['error']);
                }
                ?>
          </div>



          <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" class="form-horizontal"
            enctype="multipart/form-data">



            <?php
          if (isset($_GET['edit']))
            echo "<input type='hidden' name='pid' value='".$editrow['fld_product_id']."' />";
          else
            echo "<input type='hidden' name='pid' value='{$nextid}' />";
         ?>

            <!-- ID -->
            <div class="form-group">
              <label for="productid" class="col-sm-3 control-label">ID</label>
              <div class="col-sm-9">
                <input name="pid" type="text" class="form-control" id="productid" placeholder="ID"
                  value="<?php if (isset($_GET['edit'])) echo $pid;  else echo $nextid; ?>" required readonly>
              </div>
            </div>
            <!-- Name -->
            <div class="form-group">
              <label for="productname" class="col-sm-3 control-label">Name</label>
              <div class="col-sm-9">
                <input name="name" id="productname" type="text" class="form-control" placeholder="Product Name"
                  value="<?php if(isset($_GET['edit'])) echo $editrow['fld_product_name']; ?>" required>
              </div>
            </div>

            <!-- Price -->
            <div class="form-group">
              <label for="productprice" class="col-sm-3 control-label">Price</label>
              <div class="col-sm-9">
                <input name="price" id="productprice" type="number" class="form-control" placeholder="Price (RM)"
                  value="<?php if(isset($_GET['edit'])) echo $editrow['fld_price']; ?>" required>
              </div>
            </div>

            <!-- Type -->
            <div class="form-group">
              <label for="producttype" class="col-sm-3 control-label">Type</label>
              <div class="col-sm-9">
                <select name="type" id="producttype" class="form-control" placeholder="Animal Type" required>
                  <option value="PET"
                    <?php if(isset($_GET['edit'])) if($editrow['fld_type']=="Pet") echo "selected"; ?>>
                    PET</option>
                  <option value="FOOD"
                    <?php if(isset($_GET['edit'])) if($editrow['fld_type']=="Food") echo "selected"; ?>>FOOD</option>
                  <option value="SUPPLY"
                    <?php if(isset($_GET['edit'])) if($editrow['fld_type']=="Supply") echo "selected"; ?>>SUPPLY
                  </option>
                </select>
              </div>
            </div>

            <!-- Weight -->
            <div class="form-group">
              <label for="productweight" class="col-sm-3 control-label">Weight</label>
              <div class="col-sm-9">
                <input name="weight" id="productweight" type="number" class="form-control" placeholder="Weight (g)"
                  value="<?php if(isset($_GET['edit'])) echo $editrow['fld_weight']; ?>" required>
              </div>
            </div>

            <!-- Origin -->
            <div class="form-group">
              <label for="productorigin" class="col-sm-3 control-label">Origin</label>
              <div class="col-sm-9">
                <input name="origin" id="productorigin" type="text" class="form-control" placeholder="Origin"
                  value="<?php if(isset($_GET['edit'])) echo $editrow['fld_origin']; ?>" required>
              </div>
            </div>

            <!-- Description -->
            <div class="form-group">
              <label for="productdesc" class="col-sm-3 control-label">Description</label>
              <div class="col-sm-9">
                <input name="desc" id="productdesc" type="text" class="form-control" placeholder="Description"
                  value="<?php if(isset($_GET['edit'])) echo $editrow['fld_description']; ?>" required>
              </div>
            </div>

             <!-- Form Button -->
            <div class="form-group">
              <div class="col-sm-offset-3 col-sm-9">
                <?php if (isset($_GET['edit'])) { ?>
                <!--<input type="hidden" name="oldpid" value="<?php echo $editrow['fld_product_id']; ?>"> -->
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

            <!-- Img Upload -->
            <div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3" style="height: 100%">
              <div class="thumbnail dark-1">
                <img src="products/<?php echo(isset($_GET['edit']) ? $editrow['fld_product_image'] : '') ?>"
                  onerror="this.onerror=null;this.src='products/no-photo.png';" id="productPhoto" alt="Product Image"
                  style="width: 100%;height: 225px;">
                <div class="caption text-center">
                  <h3 id="productImageTitle" style="word-break: break-all;">Product Image</h3>
                  <p>
                    <label class="btn btn-primary">
                      <input type="file" accept="image/*" name="fileToUpload" id="inputImage"
                        onchange="loadFile(event);" />
                      <span class="glyphicon glyphicon-cloud" aria-hidden="true"></span> Browse
                    </label>
                    <?php
                      if (isset($_GET['edit']) && $editrow['fld_product_image'] != '') {
                          echo '<a href="#" class="btn btn-danger disabled" role="button">Delete</a>';
                      }
                    ?>
                  </p>
                </div>
              </div>
            </div>

          </form>

        </div>
      </div>
    </div>


    <hr>
    <!--Table-->
    <div class="container-fluid">
      <div class="row">
        <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
          <div class="page-header">
            <h2>Products List</h2>
          </div>
          <table class="table table-striped table-bordered">


            <tr>
              <td>Product ID</td>
              <td>Name</td>
              <td>Price</td>
              <td>Brand</td>
              <td></td>
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
        $stmt = $conn->prepare("SELECT * from tbl_products_a174856_pt2 LIMIT {$start_from}, {$per_page}");
        $stmt->execute();
        $result = $stmt->fetchAll();
      }
      catch(PDOException $e){
            echo "Error: " . $e->getMessage();
      }
      foreach($result as $readrow) {
      ?>
            <tr>
              <td><?php echo $readrow['fld_product_id']; ?></td>
              <td><?php echo $readrow['fld_product_name']; ?></td>
              <td>RM<?php echo $readrow['fld_price']; ?></td>
              <td><?php echo $readrow['fld_type']; ?></td>
              <td class="text-center">
                <a href="products_details.php?pid=<?php echo $readrow['fld_product_id']; ?>"
                  class="btn btn-warning btn-xs" role="button">Details</a>


                <?php
                  if (isset($_SESSION['user']) && $_SESSION['user']['fld_staff_role'] == 'admin') {
                                ?>
                <a href="products.php?edit=<?php echo $readrow['fld_product_id'];
                                echo(isset($_GET['page']) ? '&page=' . $_GET['page'] : ''); ?>"
                  class="btn btn-success btn-xs" role="button"> Edit </a>
                <a href="products.php?delete=<?php echo $readrow['fld_product_id']; ?>"
                  onclick="return confirm('Are you sure to delete?');" class="btn btn-danger btn-xs"
                  role="button">Delete</a>
                <?php }?>

              </td>
            </tr>
            <?php
      }
      $conn = null;
      ?>
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
            $stmt = $conn->prepare("SELECT * FROM tbl_products_a174856_pt2");
            $stmt->execute();
            $result = $stmt->fetchAll();
            $total_records = count($result);
          }
          catch(PDOException $e){
                echo "Error: " . $e->getMessage();
          }
          $total_pages = ceil($total_records / $per_page);
          ?>
              <?php if ($page == 1) { ?>
              <li class="disabled"><span aria-hidden="true">«</span></li>
              <?php } else { ?>
              <li><a href="products.php?page=<?php echo $page-1 ?>" aria-label="Previous"><span
                    aria-hidden="true">«</span></a></li>
              <?php
          }
          for ($i=1; $i<=$total_pages; $i++)
            if ($i == $page)
              echo "<li class=\"active\"><a href=\"products.php?page=$i\">$i</a></li>";
            else
              echo "<li><a href=\"products.php?page=$i\">$i</a></li>";
          ?>
              <?php if ($page==$total_pages) { ?>
              <li class="disabled"><span aria-hidden="true">»</span></li>
              <?php } else { ?>
              <li><a href="products.php?page=<?php echo $page+1 ?>" aria-label="Previous"><span
                    aria-hidden="true">»</span></a></li>
              <?php } ?>
            </ul>
          </nav>
        </div>

      </div>

    </div> <!-- end container fluid -->



    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>

    <script type="application/javascript">
      var loadFile = function (event) {
        var reader = new FileReader();
        reader.onload = function () {
          var output = document.getElementById('productPhoto');
          output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
        document.getElementById('productImageTitle').innerText = event.target.files[0]['name'];
      };
    </script>
</body>

</html>
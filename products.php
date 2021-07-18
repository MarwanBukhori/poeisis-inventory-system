<?php
  include_once 'products_crud.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Poeisis Product</title>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.25/datatables.min.css" />
  <!-- Font -->
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Pacifico" rel="stylesheet">

  <!-- Bootstrap -->
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="style/catalog.css" rel="stylesheet">

  <style>
    input[type="file"] {
      display: none;
    }
  </style>
</head>

<body style="background-color: #0070cc;" }>

  <?php  include_once "nav_bar.php";?>

  <!-- container for form  -->
  <div class="container">

    <div class="row">

      <div class="col col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
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

        </div> <!-- / page header -->



        <!-- ----------------------------------- FORM --------------------------------------------------------- -->
        <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" class="form-horizontal"
          enctype="multipart/form-data">

          <!-- ID -->
          <div class="form-group">
            <label for="pid" class="col-sm-3 control-label">Product ID</label>
            <div class="col-sm-9 inputfield">
              <input name="pid" type="text" class="form-control" placeholder="ID"
                value="<?php if (isset($_GET['edit'])) echo $pid;  else echo $num; ?>" readonly>
            </div>
          </div>

          <!-- Name -->
          <div class="form-group">
            <label for="productname" class="col-sm-3 control-label">Product Name</label>
            <div class="col-sm-9 inputfield">
              <input name="name" id="productname" type="text" class="form-control" placeholder="Product Name"
                value="<?php if(isset($_GET['edit'])) echo $editrow['fld_product_name']; ?>" required>
            </div>
          </div>

          <!-- Price -->
          <div class="form-group">
            <label for="productprice" class="col-sm-3 control-label">Price</label>
            <div class="col-sm-9 inputfield">
              <input name="price" id="productprice" type="number" class="form-control" placeholder="Price (RM)"
                value="<?php if(isset($_GET['edit'])) echo $editrow['fld_price']; ?>" required>
            </div>
          </div>

          <!-- Type -->
          <div class="form-group">
            <label for="producttype" class="col-sm-3 control-label">Type</label>
            <div class="col-sm-9 inputfield">
              <select name="type" id="producttype" class="form-control" placeholder="Animal Type" required>
                <option value="PET" <?php if(isset($_GET['edit'])) if($editrow['fld_type']=="Pet") echo "selected"; ?>>
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
            <div class="col-sm-9 inputfield">
              <input name="weight" id="productweight" type="number" class="form-control" placeholder="Weight (g)"
                value="<?php if(isset($_GET['edit'])) echo $editrow['fld_weight']; ?>" required>
            </div>
          </div>

          <!-- Origin -->
          <div class="form-group">
            <label for="productorigin" class="col-sm-3 control-label">Origin</label>
            <div class="col-sm-9 inputfield">
              <input name="origin" id="productorigin" type="text" class="form-control" placeholder="Origin"
                value="<?php if(isset($_GET['edit'])) echo $editrow['fld_origin']; ?>" required>
            </div>
          </div>

          <!-- Description -->
          <div class="form-group">
            <label for="productdesc" class="col-sm-3 control-label">Description</label>
            <div class="col-sm-9 inputfield">
              <input name="desc" id="productdesc" type="text" class="form-control" placeholder="Description"
                value="<?php if(isset($_GET['edit'])) echo $editrow['fld_description']; ?>" required>
            </div>
          </div>


          <!-- Img Upload -->
          <div class="form-group">
            <div class="submit-img col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3" style="height: 100%">
              <div style="background-color:#d6ecf3;" class="thumbnail dark-1 inputfield">
                <img src="products/<?php echo(isset($_GET['edit']) ? $editrow['fld_product_image'] : '') ?>"
                  onerror="this.onerror=null;this.src='products/no-photo.png';" id="productPhoto" alt="Product Image"
                  style="width: 100%;height: auto;">
                <div class="caption text-center">
                  <h4 id="productImageTitle" style="word-break: break-all;">Product Image</h3>
                    <p>
                      <label class="btn btn-primary" style="width:100%; height: auto;">
                        <input  type="file" accept="image/*" name="fileToUpload" id="inputImage"
                          onchange="loadFile(event);" />
                        <span class="glyphicon glyphicon-cloud" aria-hidden="true"></span> Browse
                      </label>
                      <?php
                      if (isset($_GET['edit']) && $editrow['fld_product_image'] != '') {
                          echo '<a href="#" class="btn btn-danger disabled" role="button">Delete</a>';
                      }
                    ?>
                    </p>
                </div> <!-- / caption -->
              </div> <!-- thumbnail -->
            </div> <!-- / col img -->
          </div>



          <!-- Form Button -->
          <div class="form-group">
            <div class="col-sm-offset-3 col-sm-9 inputfield btn-group">
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

        </form> <!-- /form  -->
      </div> <!-- / col -->
    </div> <!-- / row -->
  </div> <!-- / container  -->



  <!--Table-->
  <div class="container-fluid">
    <div class="row ">
      <div class="tbl col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
        <div class="page-header">
          <h2>Products List</h2>
        </div>


        <table id="tbl-search" class="display">
          <thead>
            <tr>
              <th>Product ID</th>
              <th>Name</th>
              <th>Price</th>
              <th>Type</th>
              <th>Origin</th>
              <th>Description</th>
              <th>Image</th>


              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php
      
      try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("SELECT * from tbl_products_a174856_pt2");
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
              <td><?php echo $readrow['fld_origin']; ?></td>
              <td><?php echo $readrow['fld_description']; ?></td>

              <?php if(file_exists('products/'. $readrow['fld_product_image'])){
								$img = 'products/'.$readrow['fld_product_image'];
								echo '<td><img data-toggle="modal" data-target="#'.$readrow['fld_product_id'].'" width=150px; src="products/'.$readrow['fld_product_image'].'"></td>';
							}
							else{
								$img = 'products/nophoto.jpg';
								echo '<td><img width=70%; data-toggle="modal" data-target="#'.$readrow['fld_product_id'].'" src="products/nophoto.jpg"'.'></td>';
							}?>

              <div id="<?php echo $readrow['fld_product_id']?>" class="modal fade" tabindex="-1" role="dialog"
                aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-body">
                  <img src="<?php echo $img ?>" class="img-responsive">
                </div>
              </div>


              <td>
                <a style="margin:2px;" href="products_details.php?pid=<?php echo $readrow['fld_product_id']; ?>"
                  class="btn btn-warning btn-xs" role="button">Details</a>
                <?php
									if($_SESSION['user']['fld_staff_role'] == 'admin'){ ?>
                <a style="margin:2px;" href="products.php?edit=<?php echo $readrow['fld_product_id']; ?>" class="btn btn-success btn-xs"
                  role="button"> Edit </a>
                <br>
                <a  style="margin:2px;" href="products.php?delete=<?php echo $readrow['fld_product_id']; ?>"
                  onclick="return confirm('Are you sure to delete?');" class="btn btn-danger btn-xs"
                  role="button">Delete</a>
                <?php } ?>
              </td>


            </tr>
            <?php
      }
      $conn = null;
      ?>
          </tbody>
        </table>
      </div> <!-- / col -->
    </div> <!-- / row  -->
  </div> <!-- end container fluid -->



  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

  <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.25/datatables.min.js"></script>

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


    $(document).ready(function () {
      $("#tbl-search").DataTable({
        "lengthMenu": [
          [5, 20, 50, -1],
          [5, 20, 50, "All"]
        ]
      });
    });
  </script>
</body>

</html>
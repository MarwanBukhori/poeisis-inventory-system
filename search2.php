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
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.25/datatables.min.css"/>
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

                </div> <!-- / page header  -->


                <!-- ----------------------------------- FORM --------------------------------------------------------- -->
                <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" class="form-horizontal"
                    enctype="multipart/form-data">

                    <?php
          if (isset($_GET['edit']))
            echo "<input type='hidden' name='pid' value='".$editrow['fld_product_id']."' />";
          else
            echo "<input type='hidden' name='pid' value='{$nextid}' />";
         ?>

                    <!-- Name -->
                    <div class="form-group">
                        <label for="productname" class="col-sm-3 control-label">Search</label>
                        <div class="col-sm-9 inputfield">
                            <input name="search2" id="productname" type="text" class="form-control"
                                placeholder="Product Name"
                                value="<?php if(isset($_GET['edit'])) echo $editrow['fld_product_name']; ?>" required>
                        </div>
                    </div>



                    <!-- Form Button -->
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-9 inputfield btn-group">


                            <button class="btn btn-default" type="submit" name="search2"><span
                                    class="glyphicon glyphicon-plus" aria-hidden="true"></span> Search</button>

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
                            <th>Image</th>
                            
                            
                            <td></td>
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
                            
                            <?php if(file_exists('products/'. $readrow['fld_product_image'])){
								$img = 'products/'.$readrow['fld_product_image'];
								echo '<td><img data-toggle="modal" data-target="#'.$readrow['fld_product_id'].'" width=150px; src="products/'.$readrow['fld_product_image'].'"></td>';
							}
							else{
								$img = 'products/nophoto.jpg';
								echo '<td><img width=70%; data-toggle="modal" data-target="#'.$readrow['fld_product_id'].'" src="products/nophoto.jpg"'.'></td>';
							}?>
                            
                            <div id="<?php echo $readrow['fld_product_id']?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								<div class="modal-dialog modal-body">
									<img src="<?php echo $img ?>" class="img-responsive">
								</div>
							</div>
                            
                            
                        	<td>
								<a href="products_details.php?pid=<?php echo $readrow['fld_product_id']; ?>" class="btn btn-warning btn-xs" role="button">Details</a>
								<?php
									if($_SESSION['user']['fld_staff_role'] == 'admin'){ ?>
										<a href="products.php?edit=<?php echo $readrow['fld_product_id']; ?>" class="btn btn-success btn-xs" role="button"> Edit </a>
										<br>
                                        <a href="products.php?delete=<?php echo $readrow['fld_product_id']; ?>" onclick="return confirm('Are you sure to delete?');" class="btn btn-danger btn-xs" role="button">Delete</a>
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
		"lengthMenu": [[5, 20, 50, -1], [5, 20, 50, "All"]]
	});
	});
    </script>
</body>

</html>
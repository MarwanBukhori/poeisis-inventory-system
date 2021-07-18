


<?php

$user_name = $_SESSION["username"];
$staff_role = $_SESSION["staff_role"];
?>
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css?family=Pacifico" rel="stylesheet">
    <link rel="stylesheet" href="style/nav_bar.css">


    <!-- partial:index.partial.html -->
    <input id="hamburger" class="hamburger" type="checkbox" />
    <label for="hamburger" class="hamburger">
    <i></i>
  <text>
      <close>close</close>
      <open>menu</open>
    </text>
  </label>

    <nav class="primnav">
        <ul>
            <li>
                <a href="products.php">
         <i class="icon bi bi-bag-fill"></i> PRODUCT
                </a>
</li>
            <li>
                <a href="orders.php">
                    <i class="bi bi-receipt icon"></i> ORDER
                    <div class="tag">23</div>
                </a>
                
            </li>

            <li>
                <a href="staffs.php">
                <i class="icon bi bi-people-fill"></i> USER
                </a>
                <ul class="secnav">
                    <li>
                        <a href="staffs.php">Staff</a>
                    </li>
                    <li>
                        <a href="customers.php">Customer</a>
                    </li>
                 
                </ul>
            </li>
        </ul>
    </nav>

    <user id="user" style="padding-right: 20px; padding-top: 15px;">
        <section>
            <img src="jett-avatar.jpg" />
            <section>
            <a id ="username" href="#" style="color:#fff; margin-left:6px; text-decoration:none;"><?php echo  $user_name ; ?> ( <?php echo $staff_role ; ?> )</a>
                <actions><a href="index.php">Home</a> | <a href="logout.php">Logout</a></actions>
            </section>
        </section>
    </user> 



   
  




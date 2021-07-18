<?php
require_once 'database.php';



$userID = ""; //* Delecare the Email address
$pass = ""; //* Declare the password field
$errors = array(); //* Hold error messages


# if user logged in, go to index.php
if (isset($_SESSION['loggedin'])){       
    header("LOCATION: index.php");
}

if(isset($_POST['userid'], $_POST['password'])){
   
    $userID = htmlspecialchars($_POST['userid']);
    $pass = $_POST['password'];
   
    if (empty($userID) || empty($pass)) {
        $_SESSION['error'] = 'Please fill in the blanks.';
    } else {
        $stmt = $db->prepare("SELECT * FROM tbl_staffs_a174856_pt2 WHERE (fld_staff_id = :id OR fld_staff_email = :id) LIMIT 1");
        $stmt->bindParam(':id', $userID);

        $stmt->execute();

        # fetch satu record as object 
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (isset($user['fld_staff_id'])) {
            if ($user['fld_staff_password'] == $pass) {
                unset($user['fld_staff_password']);
                $_SESSION['loggedin'] = true;
                $_SESSION['user'] = $user;
                $_SESSION['username'] = $user['fld_staff_name'];
                $_SESSION['staff_role'] = $user['fld_staff_role'];
               
                header("LOCATION: index.php");
                exit();
            } else {
                $_SESSION['error'] = 'Invalid login credentials. Please try again.';
            }
        } else {
            $_SESSION['error'] = 'Account does not exist.';
        }
    }

    header("LOCATION: " . $_SERVER['REQUEST_URI']);
    exit();
    
}
?>

<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Poiesis Animal Shop : Login</title>
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css'>
    <link href="style/login.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700|Raleway:300,600" rel="stylesheet">



    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
 

<!-- partial:index.partial.html -->
    <div class="container">
        <section id="formHolder">

            <div class="row">

                <!-- Brand Box -->
                <div class="col-sm-6 brand">
                    <a href="#" class="logo">marwanbukhori <span>.</span></a>

                    <div class="heading">
                        <h2>Poeisis</h2>
                        <p>Animal Inventory System</p>
                    </div>

                    <div class="success-msg">
                        <p>Great! You are one of our members now</p>
                        <a href="#" class="profile">Your Profile</a>
                    </div>
                </div>


                <!-- Form Box -->
                <div class="col-sm-6 form">

                    <!-- Login Form -->
                    <div class="login form-peice">
                        <form class="login-form" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST">
                            <div class="form-group">
                                <label for="inputUserID">ID / Email</label>
                                <input type="text" name="userid" id="inputUserID" required>
                            </div>

                            <div class="form-group">
                                <label for="inputUserPass">Password</label>
                                <input type="password" name="password" id="inputUserPass" required>
                            </div>

                            <?php
                if (isset($_SESSION['error'])) {
                    echo "<p class='text-danger text-center'>{$_SESSION['error']}</p>";
                    unset($_SESSION['error']);
                }
                ?>

                            <div class="CTA">
                                <input type="submit" value="Login">
                                <a href="#" class="switch">I'm New</a>
                            </div>
                        </form>
                    </div><!-- End Login Form -->


                    <!-- Signup Form -->
                    <div class="signup form-peice switched">
                        <form class="signup-form" action="#" method="post">

                            <div class="form-group">
                                <label for="name">Full Name</label>
                                <input type="text" name="username" id="name" class="name">
                                <span class="error"></span>
                            </div>

                            <div class="form-group">
                                <label for="email">Email Adderss</label>
                                <input type="email" name="emailAdress" id="email" class="email">
                                <span class="error"></span>
                            </div>

                            <div class="form-group">
                                <label for="phone">Phone Number - <small>Optional</small></label>
                                <input type="text" name="phone" id="phone">
                            </div>

                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" id="password" class="pass">
                                <span class="error"></span>
                            </div>

                            <div class="form-group">
                                <label for="passwordCon">Confirm Password</label>
                                <input type="password" name="passwordCon" id="passwordCon" class="passConfirm">
                                <span class="error"></span>
                            </div>

                            <div class="CTA">
                                <input type="submit" value="Signup Now" id="submit">
                                <a href="#" class="switch">I have an account</a>
                            </div>
                        </form>
                    </div><!-- End Signup Form -->
                </div>
            </div>

        </section>


        <footer>

        </footer>

    </div>
    <!-- partial -->
    <script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js'></script>
    <script src="script/login.js"></script>

</body>

</html>
<?php $db = null; ?>
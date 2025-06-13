<?php
include('config.php');

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['submit'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        if (!empty($username) && !empty($password)) {
     
            $sql = "SELECT id FROM users WHERE username = ? AND password = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('ss', $username, $password);
            $stmt->execute();
            $stmt->bind_result($id);
            $stmt->fetch();

          
            if ($id) {
                $_SESSION['user_id'] = $id;
                 header("Location: Worker_Profile.php");

                exit();
            } else {           
                echo "<div class='alert alert-danger'>Invalid username or password</div>";
            }
        } else {
                echo "<div class='alert alert-danger'>Please enter both username and password</div>";
            
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="style.css">
</head>
<style>
    body {
        background-image: url('../imgs/background2.jpg');
        background-size: cover;
    }
</style>

<body>
    <?php
    include('navbar.php');
    ?>
    <div class="container">
        <div class="row justify-content-center align-items-center">
        
            <div class="col-md-6 mt-5">
                <img src="../imgs/user_login.jpg" alt="Your Image" class="img-fluid mb-4"
                    style="max-width: 100%; height: auto;">
            </div>
           
            <div class="col-md-6">
                <div id="login">
                    <h3 class="text-center text-white pt-5">User Login</h3>
                    <form id="login-form" class="form" action="" method="post">
                        <?php
                        if (isset($error_message)) {
                            echo '<div class="alert alert-danger">' . $error_message . '</div>';
                        }
                        ?>
                        <div class="form-group">
                            <label for="username" class="text-info">Username:</label><br>
                            <input type="text" name="username" id="username" placeholder="Enter Username"
                                class="form-control">
                        </div>
                        
                        <div class="form-group">
                            <label for="password" class="text-info">Password:</label><br>
                            <input type="password" name="password" id="password" placeholder="Enter Password"
                                class="form-control">
                        </div>
                        <div class="form-group">
                            <input type="submit" name="submit" class="btn col btn-info btn-md" value="Login">
                        </div>
                        <div id="register-link" class="text-left text-white">
                            <label for="">Not have an account?</label>
                            <a href="create_account.php" class="text" style="text-decoration: underline; "> Click
                                here</a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

  
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
</body>

</html>
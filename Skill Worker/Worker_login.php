<?php
include('config.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   
    if (isset($_POST['submit'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

     
        if (!empty($username) && !empty($password)) {
            
            $sql = "SELECT * FROM worker WHERE username = ? AND password = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('ss', $username, $password);
            $stmt->execute();
            $result = $stmt->get_result();

      
            if ($result->num_rows > 0) {
              
                $user = $result->fetch_assoc();
                $_SESSION['user_id'] = $user['id'];

                header("Location: SkillWoerkerPanel.php");
                exit();

            } else {
              
                $error_message = "Invalid username or password";
            }
        } else {
      
            $error_message = "Please enter both username and password";
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
        background-image: url('../imgs/background9.jpg');
        background-size: cover;
    }
</style>

<body>
    <?php
    include('navbar.php');
    ?>
    <div id="login">
        <h3 class="text-center text-white pt-5"></h3>
        <div class="container">
            <div id="login-row" class="row justify-content-center align-items-center">
                    <div class="col-md-5">
                    <img src="../imgs/Skilled Worker Login.jpg" alt="Worker Login Image" class="img-fluid mb-4"
                        style="max-width: 100%; height: auto;">
                </div>
                    <div id="login-column" class="col-md-6">
                    <div id="login-box" class="col-md-12">
                        <form id="login-form" class="form"
                            action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <h3 class="text-center text-info">Skilled Worker Login</h3>
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
                            <div id="register-link" class="text-left">
                                <a href="registration.php" class="text-white"
                                    style="text-decoration: underline;">Register Here</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
</body>

</html>
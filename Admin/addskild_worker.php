<?php
include('config.php');

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST['Email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];

    if (empty($email) || empty($username) || empty($password) || empty($confirm)) {

        $errors[] = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $errors[] = "Invalid email format.";
    } elseif ($password !== $confirm) {

        $errors[] = "Password and Confirm Password must match.";
    } else {

        $insertSql = "INSERT INTO worker ( Email, username, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($insertSql);

        $stmt->bind_param("sss", $email, $username, $password);
        $stmt->execute();


        session_start();
        $_SESSION['AddWorker_success'] = true;
        header("Location: dashboard.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Worker Registration</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <style>
        body {
            background-image: url('../imgs/background9.jpg');
            background-size: cover;
            background-attachment: fixed;
        }
    </style>
</head>

<body>
    <?php
    include('navbar.php');
    session_start();
    if (isset($_SESSION['registration_success']) && $_SESSION['registration_success']) {
        echo '<div class="container alert alert-success mt-3">Add Worker successfully!</div>';
       
        unset($_SESSION['registration_success']);
    }
    ?>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <h4 class="card-header text-center">Add Skill Worker</h4>
                    <div class="card-body">
                        <?php
                   
                        if (!empty($errors)) {
                            echo '<div class="alert alert-danger">';
                            foreach ($errors as $error) {
                                echo $error . '<br>';
                            }
                            echo '</div>';
                        }
                        ?>
                        <form class="form-horizontal" method="post" action="#">
                            <div class="form-group">
                                <label for="Email" class="cols-sm-2 control-label">Worker Email</label>
                                <div class="cols-sm-10">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-envelope fa"
                                                aria-hidden="true"></i></span>
                                        <input type="text" class="form-control" name="Email" id="Email"
                                            placeholder="Enter worker Email" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="username" class="cols-sm-2 control-label">Worker Username</label>
                                <div class="cols-sm-10">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-users fa"
                                                aria-hidden="true"></i></span>
                                        <input type="text" class="form-control" name="username" id="username"
                                            placeholder="Enter worker Username" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password" class="cols-sm-2 control-label">Password</label>
                                <div class="cols-sm-10">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-lock fa-lg"
                                                aria-hidden="true"></i></span>
                                        <input type="password" class="form-control" name="password" id="password"
                                            placeholder="Enter Password" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="confirm" class="cols-sm-2 control-label">Confirm Password</label>
                                <div class="cols-sm-10">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-lock fa-lg"
                                                aria-hidden="true"></i></span>
                                        <input type="password" class="form-control" name="confirm" id="confirm"
                                            placeholder="Confirm Password" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit"
                                    class="btn btn-primary btn-lg btn-block login-button">Add</button>
                            </div>
                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</body>

</html>

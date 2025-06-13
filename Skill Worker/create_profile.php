<?php
include('config.php');
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
 
    $name = $_POST['name'];
    $skills = $_POST['skills'];
    $certifications = $_POST['certifications'];
    $workHistory = $_POST['History'];
    $availability = $_POST['availability'];
    $location = $_POST['location'];
    $contact = $_POST['contact'];
    

    if (empty($name)  || empty($skills) || empty($certifications) || empty($workHistory) || empty($availability) || empty($location) || empty($contact) ) {
      
        $error_message = "All fields are required.";
    } else {
      
        $insertSql = "INSERT INTO workerprofile (name,skills, certifications, work_history, availability, location, contact) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insertSql);
        $stmt->bind_param("sssssss", $name,$skills, $certifications, $workHistory, $availability, $location, $contact);
        $stmt->execute();

      
        session_start();
        $_SESSION['CreateProfile_success'] = true;
        header("Location: create_profile.php");
        exit();
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Profile</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>
<?php
    include('navbar.php');
    if (isset($_SESSION['CreateProfile_success']) && $_SESSION['CreateProfile_success']) {
        echo '<div class="container alert alert-success mt-3">Create Profile successfully!</div>';
        
        unset($_SESSION['CreateProfile_success']);
    }
    ?>
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <h4 class="card-header text-center">Create Profile</h4>
                    <div class="card-body">
                        <form class="form-horizontal" method="post">
                            <div class="form-group">
                                <label for="name" class="cols-sm-2 control-label">Your Name</label>
                                <div class="cols-sm-10">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-user fa"
                                                aria-hidden="true"></i></span>
                                        <input type="text" class="form-control" name="name" id="name"
                                            placeholder="Enter your Name" required />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="skills" class="cols-sm-2 control-label">Your Skills</label>
                                <div class="cols-sm-10">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-envelope fa"
                                                aria-hidden="true"></i></span>
                                        <input type="text" class="form-control" name="skills" id="skills"
                                            placeholder="Enter your Skills" required />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="certifications" class="cols-sm-2 control-label">Your Certifications</label>
                                <div class="cols-sm-10">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-envelope fa"
                                                aria-hidden="true"></i></span>
                                        <input type="text" class="form-control" name="certifications"
                                            id="certifications" placeholder="Enter your Certifications" required />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="History" class="cols-sm-2 control-label">Your Work History</label>
                                <div class="cols-sm-10">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-envelope fa"
                                                aria-hidden="true"></i></span>
                                        <input type="text" class="form-control" name="History" id="History"
                                            placeholder="Enter your Work History" required />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="availability" class="cols-sm-2 control-label">Your Availability</label>
                                <div class="cols-sm-10">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-envelope fa"
                                                aria-hidden="true"></i></span>
                                        <input type="text" class="form-control" name="availability" id="availability"
                                            placeholder="Enter your Availability" required />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="location" class="cols-sm-2 control-label">Your Location</label>
                                <div class="cols-sm-10">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-envelope fa"
                                                aria-hidden="true"></i></span>
                                        <input type="text" class="form-control" name="location" id="location"
                                            placeholder="Enter your Location" required />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="contact" class="cols-sm-2 control-label">Contact</label>
                                <div class="cols-sm-10">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-envelope fa"
                                                aria-hidden="true"></i></span>
                                        <input type="text" class="form-control" name="contact" id="contact"
                                            placeholder="Enter your Contact" required />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-lg btn-block login-button">Submit</button>
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

<?php
include('config.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$workers = array();


$sql = "SELECT * FROM workerprofile";
$result = $conn->query($sql);


if (!$result) {
    die("Error: " . $conn->error);
}

if ($result->num_rows > 0) {
    $workers = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $workers = array(); 
}


$conn->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Skilled Worker Panel</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>
    <?php
    include('navbar.php');
    ?>
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h4 class="card-header text-center bg-dark text-light">Welcome Skilled Worker Panel</h4>
                <a href="create_profile.php" class="btn btn-primary mb-3 mt-2 md-8 col">Create Profile</a>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Skill</th>
                            <th>Certification</th>
                            <th>Work History</th>
                            <th>Availability</th>
                            <th>Location</th>
                            <th>Contact</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($workers as $worker): ?>
                            <tr>
                                <td>
                                    <?php echo $worker['name']; ?>
                                </td>
                                <td>
                                    <?php echo $worker['skills']; ?>
                                </td>
                                <td>
                                    <?php echo $worker['certifications']; ?>
                                </td>
                                <td>
                                    <?php echo $worker['work_history']; ?>
                                </td>
                                <td>
                                    <?php echo $worker['availability']; ?>
                                </td>
                                <td>
                                    <?php echo $worker['location']; ?>
                                </td>
                                <td>
                                    <?php echo $worker['contact']; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

 
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
</body>

</html>

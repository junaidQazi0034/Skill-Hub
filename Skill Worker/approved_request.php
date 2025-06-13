<?php
include('config.php');
session_start();


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete']) && isset($_POST['requestId'])) {
    $requestIdToDelete = $_POST['requestId'];


    $deleteSql = "DELETE FROM service_requests WHERE id = ?";
    $deleteStmt = $conn->prepare($deleteSql);
    $deleteStmt->bind_param('i', $requestIdToDelete);

    if ($deleteStmt->execute()) {

        header("Location: {$_SERVER['PHP_SELF']}");
        exit();
    } else {
        echo "Error deleting record";
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['accept']) && isset($_POST['requestId'])) {
    $requestIdToAccept = $_POST['requestId'];


    $acceptSql = "UPDATE service_requests SET action = 'Accepted' WHERE id = ?";
    $acceptStmt = $conn->prepare($acceptSql);
    $acceptStmt->bind_param('i', $requestIdToAccept);

    if ($acceptStmt->execute()) {

        header("Location: {$_SERVER['PHP_SELF']}");
        exit();
    } else {
        echo "Error accepting record";
    }
}


$approvedSql = "SELECT * FROM service_requests WHERE approved = 1";
$approvedResult = $conn->query($approvedSql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approved Service Requests</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>
    <?php
    include('navbar.php');
    ?>

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <h4 class="card-header text-center">Approved Service Requests</h4>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Customer Name</th>
                                    <th>Contact</th>
                                    <th>Email</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($approvedRow = $approvedResult->fetch_assoc()) {
                                    echo '<tr>';
                                    echo '<td>' . $approvedRow['id'] . '</td>';
                                    echo '<td>' . $approvedRow['customer_name'] . '</td>';
                                    echo '<td>' . $approvedRow['customer_contact'] . '</td>';
                                    echo '<td>' . $approvedRow['customer_email'] . '</td>';
                                    echo '<td>' . $approvedRow['description'] . '</td>';
                                    echo '<td>' . $approvedRow['action'] . '</td>';
                                    echo '<td>';
                                
                                    if ($approvedRow['action'] != 'Accepted') {
                                        echo '<form method="post">';
                                        echo '<input type="hidden" name="requestId" value="' . $approvedRow['id'] . '">';
                                        echo '<button type="submit" class="btn btn-success md-1 ml-2 btn-sm " name="accept">Accept</button>';
                                        echo '<button type="submit" class="btn btn-danger md-1 ml-2 btn-sm" name="delete">Delete</button>';
                                        echo '</form> ';
                                    } 
                                    echo '</td>';
                                    echo '</tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
</body>

</html>

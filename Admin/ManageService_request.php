<?php
include('config.php');
session_start();

if (!isset($_SESSION['user_id'])) {

    header("Location: ../index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['delete'])) {

        $requestIdToDelete = isset($_POST['request_id']) ? $_POST['request_id'] : null;
        if ($requestIdToDelete !== null) {

            $deleteSql = "DELETE FROM service_requests WHERE id = ?";
            $deleteStmt = $conn->prepare($deleteSql);
            $deleteStmt->bind_param('i', $requestIdToDelete);
            $deleteStmt->execute();
        }
    } elseif (isset($_POST['approve'])) {

        $requestIdToApprove = isset($_POST['request_id']) ? $_POST['request_id'] : null;
        if ($requestIdToApprove !== null) {

            $approveSql = "UPDATE service_requests SET approved = 1 WHERE id = ?";
            $approveStmt = $conn->prepare($approveSql);
            $approveStmt->bind_param('i', $requestIdToApprove);
            $approveStmt->execute();
        }
    }
}


$sql = "SELECT * FROM service_requests WHERE approved = 0";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Service Requests</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php include('navbar.php'); ?>

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-14">
                <div class="card">
                    <h4 class="card-header text-center">Manage Service Requests</h4>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Customer Name</th>
                                    <th>Contact</th>
                                    <th>Email</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($row = $result->fetch_assoc()) {
                                    echo '<tr>';
                                    echo '<td>' . $row['id'] . '</td>';
                                    echo '<td>' . $row['customer_name'] . '</td>';
                                    echo '<td>' . $row['customer_contact'] . '</td>';
                                    echo '<td>' . $row['customer_email'] . '</td>';
                                    echo '<td>' . $row['description'] . '</td>';
                                    echo '<td>
                                    <form method="post" onsubmit="return confirm(\'Are you sure you want to delete/approve this service request?\');">
                                    <input type="hidden" name="request_id" value="' . $row['id'] . '">
                                    <button type="submit" class="btn btn-danger col btn-sm" name="delete">Delete</button>
                                    <button type="submit" class="btn btn-success col mt-1 btn-sm" name="approve">Approve</button>
                                </form>
                                        </td>';
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
</body>

</html>
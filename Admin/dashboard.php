<?php
include('config.php');
session_start();

if (!isset($_SESSION['user_id'])) {

    header("Location: login.php");
    exit();
}


$sql = "SELECT * FROM workerprofile"; 
$result = $conn->query($sql);


$updateSuccessMessage = $deleteSuccessMessage = '';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['update'])) {

        $workerIdToUpdate = isset($_POST['worker_id']) ? $_POST['worker_id'] : null;

        if ($workerIdToUpdate !== null) {

            $newName = $_POST['new_name'];
            $newSkill = $_POST['new_skill'];
            $newCertification = $_POST['new_certification'];
            $newWorkHistory = $_POST['new_work_history'];
            $newAvailability = $_POST['new_availability'];
            $newLocation = $_POST['new_location'];
            $newContact = $_POST['new_contact'];

            $updateSql = "UPDATE workerprofile SET 
                name = ?, 
                skills = ?, 
                certifications = ?, 
                work_history = ?, 
                availability = ?,  
                location = ?, 
                contact = ? 
                WHERE id = ?";

            $updateStmt = $conn->prepare($updateSql);
            $updateStmt->bind_param('sssssssi',
                $newName,
                $newSkill,
                $newCertification,
                $newWorkHistory,
                $newAvailability,
                $newLocation,
                $newContact,
                $workerIdToUpdate);

            $updateStmt->execute();


            $updateSuccessMessage = "Worker profile updated successfully!";
        } else {

            echo '<div class="alert alert-danger">Error: Worker ID not provided for update.</div>';
        }
    } elseif (isset($_POST['delete'])) {

        $workerIdToDelete = isset($_POST['worker_id']) ? $_POST['worker_id'] : null;

        if ($workerIdToDelete !== null) {
         
            $deleteSql = "DELETE FROM workerprofile WHERE id = ?";
            $deleteStmt = $conn->prepare($deleteSql);
            $deleteStmt->bind_param('i', $workerIdToDelete);
            $deleteStmt->execute();

         
            $deleteSuccessMessage = "Worker profile deleted successfully!";
        } else {
       
            echo '<div class="alert alert-danger">Error: Worker ID not provided for delete.</div>';
        }
    }elseif (isset($_POST['toggleStatus'])) {
        $workerId = $_POST['worker_id'];
        
        // Fetch the current status of the worker profile
        $statusSql = "SELECT status FROM workerprofile WHERE id = ?";
        $stmt = $conn->prepare($statusSql);
        $stmt->bind_param('i', $workerId);
        $stmt->execute();
        $statusResult = $stmt->get_result();
        $currentStatus = $statusResult->fetch_assoc()['status'];
        
        // Toggle the status and update it in the database
        $newStatus = ($currentStatus == 'active') ? 'inactive' : 'active';
        $updateStatusSql = "UPDATE workerprofile SET status = ? WHERE id = ?";
        $updateStmt = $conn->prepare($updateStatusSql);
        $updateStmt->bind_param('si', $newStatus, $workerId);
        $updateStmt->execute();
        
        $statusUpdateMessage = "Worker profile status updated successfully!";
    }
}

$sql = "SELECT * FROM workerprofile";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Worker Profiles</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">

</head>

<body>
    <?php
    include('navbar.php');
    ?>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <h4 class="card-header text-center">Manage Skilled Worker Profiles</h4>
                    <div class="card-body">
                        <?php
                        if (!empty($updateSuccessMessage)) {
                            echo '<div class="alert alert-success">' . $updateSuccessMessage . '</div>';
                        } elseif (!empty($deleteSuccessMessage)) {
                            echo '<div class="alert alert-success">' . $deleteSuccessMessage . '</div>';
                        }
                        ?>
                    <div class="container">
                            <a href="addskild_worker.php" class="btn col btn-success mb-3 float-right">Add New SKill
                                Worker</a>
                        </div>
                        <table class="table">
                            <thead class="thead-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Skill</th>
                                    <th>Certification</th>
                                    <th>Work History</th>
                                    <th>Availability</th>
                                    <th>Location</th>
                                    <th>Contact</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($row = $result->fetch_assoc()) {
                                    echo '<tr>';
                                    echo '<td>' . $row['id'] . '</td>';
                                    echo '<td>' . $row['name'] . '</td>';
                                    echo '<td>' . $row['skills'] . '</td>';
                                    echo '<td>' . $row['certifications'] . '</td>';
                                    echo '<td>' . $row['work_history'] . '</td>';
                                    echo '<td>' . $row['availability'] . '</td>';
                                    echo '<td>' . $row['location'] . '</td>';
                                    echo '<td>' . $row['contact'] . '</td>';
                                    echo '<td>' . $row['status'] . '</td>';
                                    echo '<td>
                                        <button type="button" class="btn btn-primary col btn-sm" data-toggle="modal" data-target="#editModal' . $row['id'] . '">Edit</button>
                                        <form method="post" style="display: inline;">
                                            <input type="hidden" name="worker_id" value="' . $row['id'] . '">
                                            <button type="submit" class="btn btn-danger col btn-sm mt-1" name="delete" onclick="return confirm(\'Are you sure you want to delete this worker profile?\')">Delete</button>
                                            <button type="submit" class="btn btn-primary btn-sm col mt-2" name="toggleStatus">' . 
                                                ($row['status'] == 'active' ? 'Deactivate' : 'Activate') . '</button>
                                       
                                        </form>
                                    </td>';
                                    echo '</tr>';

                                   
                                    echo '<div class="modal fade" id="editModal' . $row['id'] . '" tabindex="-1" role="dialog" aria-labelledby="editModalLabel' . $row['id'] . '" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editModalLabel' . $row['id'] . '">Edit Worker Profile</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form method="post">
                                                            <input type="hidden" name="worker_id" value="' . $row['id'] . '">
                                                            <div class="form-group">
                                                                <label for="new_name">New Name</label>
                                                                <input type="text" class="form-control" name="new_name" value="' . $row['name'] . '">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="new_skill">New Skill</label>
                                                                <input type="text" class="form-control" name="new_skill" value="' . $row['skills'] . '">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="new_certification">New Certification</label>
                                                                <input type="text" class="form-control" name="new_certification" value="' . $row['certifications'] . '">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="new_work_history">New Work History</label>
                                                                <input type="text" class="form-control" name="new_work_history" value="' . $row['work_history'] . '">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="new_availability">New Availability</label>
                                                                <input type="text" class="form-control" name="new_availability" value="' . $row['availability'] . '">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="new_location">New Location</label>
                                                                <input type="text" class="form-control" name="new_location" value="' . $row['location'] . '">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="new_contact">New Contact</label>
                                                                <input type="number" class="form-control" name="new_contact" value="' . $row['contact'] . '">
                                                            </div>
                                                            <button type="submit" class="btn btn-primary" name="update">Update</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>';
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

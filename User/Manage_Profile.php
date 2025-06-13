<?php
include('config.php');
session_start();

$deleteSuccessMessage = $updateSuccessMessage = '';

$userId = $_SESSION['user_id'];
$query = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $userId);
$stmt->execute();
$result = $stmt->get_result();
$userData = $result->fetch_assoc();

$name = $userData['name'] ?? '';
$email = $userData['email'] ?? '';
$contact = $userData['contact'] ?? '';
$username = $userData['username'] ?? ''; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['delete'])) {

        $userIdToDelete = isset($_POST['user_id']) ? $_POST['user_id'] : null;

        if ($userIdToDelete !== null) {
            $deleteSql = "DELETE FROM users WHERE id = ?";
            $deleteStmt = $conn->prepare($deleteSql);
            $deleteStmt->bind_param('i', $userIdToDelete);
            $deleteStmt->execute();

            $deleteSuccessMessage = "User deleted successfully!";
        } else {
          
            echo '<div class="alert alert-danger">Error: User ID not provided for deletion.</div>';
        }
    } elseif (isset($_POST['update'])) {
        $userid = $_SESSION["user_id"]; 
        $newName = $_POST['name'];
        $newEmail = $_POST['email'];
        $newContact = $_POST['contact'];
        $newUsername = $_POST['username']; 

      
        $updateSql = "UPDATE users SET name = ?, email = ?, contact = ?, username = ? WHERE id = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param('ssssi', $newName, $newEmail, $newContact, $newUsername, $userid); // Corrected here
        $updateStmt->execute();

        $updateSuccessMessage = "Profile updated successfully!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Profile</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">

</head>

<body>
    <?php
    include('navbar.php');
    ?>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <h4 class="card-header text-center">Manage Profile</h4>
                    <div class="card-body">
                        <?php
                        if (!empty($deleteSuccessMessage)) {
                            echo '<div class="alert alert-success">' . $deleteSuccessMessage . '</div>';
                        } elseif (!empty($updateSuccessMessage)) {
                            echo '<div class="alert alert-success">' . $updateSuccessMessage . '</div>';
                        }
                        ?>

                        <form method="post">
                            <div class="form-group">
                                <label for="new_name">New Name</label>
                                <input type="text" class="form-control" name="name" value="<?php echo $name; ?>">
                            </div>
                            <div class="form-group">
                                <label for="new_email">New Email</label>
                                <input type="text" class="form-control" name="email" value="<?php echo $email; ?>">
                            </div>
                            <div class="form-group">
                                <label for="new_contact">New Contact</label>
                                <input type="text" class="form-control" name="contact" value="<?php echo $contact; ?>">
                            </div>
                            <div class="form-group">
                                <label for="new_username">New Username</label>
                                <input type="text" class="form-control" name="username" value="<?php echo $username; ?>">
                            </div>
                            <input type="hidden" name="user_id" value="<?php echo $userId; ?>">
                            <button type="submit" class="btn btn-primary" name="update">Update Profile</button>
                            <button type="submit" class="btn btn-danger" name="delete">Delete Profile</button>
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

<?php
include('config.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (
        isset($_POST['customer_name'], $_POST['customer_contact'], $_POST['customer_email'], $_POST['description'])
    ) {
        $customerName = $_POST['customer_name'];
        $customerContact = $_POST['customer_contact'];
        $customerEmail = $_POST['customer_email'];
        $description = $_POST['description'];

         if (empty($customerName) || empty($customerContact) || empty($customerEmail) || empty($description)) {
            $error_message = "All fields are required.";
        } else {
            $insertSql = "INSERT INTO service_requests (customer_name, customer_contact, customer_email, description) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($insertSql);


            $stmt->bind_param("ssss", $customerName, $customerContact, $customerEmail, $description);

            $stmt->execute();

            $_SESSION['Submit_success'] = true;
            header("Location: Worker_Profile.php?success=true&name=$customerName&contact=$customerContact&email=$customerEmail");
            exit();
        }
    } else {
        $error_message = "All fields are required.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service Request</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet">

</head>
<style>
    body {
        background-image: url('../imgs/background12.jpg');
        background-size: cover;
    }
</style>

<body>
    <?php include('navbar.php'); ?>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <h4 class="card-header text-center ">Service Request Form</h4>
                    <div class="card-body">
                        <form method="post" action="">
                            <div class="form-group">
                                <label for="customer_name">Your Name</label>
                                <input type="text" class="form-control" name="customer_name"
                                    placeholder="Enter Your Name" id="customer_name" required>
                            </div>
                            <div class="form-group">
                                <label for="customer_contact">Your Contact</label>
                                <input type="text" class="form-control" name="customer_contact"
                                    placeholder="Enter Your Contact" id="customer_contact" required>
                            </div>
                            <div class="form-group">
                                <label for="customer_email">Your Email</label>
                                <input type="email" class="form-control" name="customer_email"
                                    placeholder="Enter Your Email" id="customer_email" required>
                            </div>
                            <div class="form-group">
                                <label for="description ">Service Description</label>
                                <textarea class="form-control" name="description"
                                    placeholder="Enter Description Here Which Service You Want to Avail?"
                                    id="description" rows="4" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit Request</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {         
            const urlParams = new URLSearchParams(window.location.search);
            const successParam = urlParams.get('success');

                if (successParam === 'true') {
                alert('Request submitted successfully!');
            }
        });
    </script>
</body>

</html>
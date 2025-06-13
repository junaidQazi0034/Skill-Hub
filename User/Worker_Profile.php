<?php
include('config.php');
session_start();


if (!isset($_SESSION['user_id'])) {

    header("Location: login.php");
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $searchTerm = isset($_POST['searchTerm']) ? $_POST['searchTerm'] : '';
    $selectedSkill = isset($_POST['selectedSkill']) ? $_POST['selectedSkill'] : '';


    $searchSql = "SELECT * FROM workerprofile WHERE (name LIKE ? OR skills LIKE ?) AND (skills = ? OR ? = '')";
    $stmt = $conn->prepare($searchSql);
    $searchTerm = "%$searchTerm%"; 
    $stmt->bind_param('ssss', $searchTerm, $searchTerm, $selectedSkill, $selectedSkill);
    $stmt->execute();
    $result = $stmt->get_result();
    $workers = $result->fetch_all(MYSQLI_ASSOC);
} else {

    $sql = "SELECT * FROM workerprofile WHERE status = 'active'";
    $result = $conn->query($sql);

   
    if ($result->num_rows > 0) {
        $workers = $result->fetch_all(MYSQLI_ASSOC);
    } else {
        $workers = array(); 
    }
}

$skillSql = "SELECT DISTINCT skills FROM workerprofile";
$skillResult = $conn->query($skillSql);


if ($skillResult->num_rows > 0) {
    $skills = $skillResult->fetch_all(MYSQLI_ASSOC);
} else {
    $skills = array(); 
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['rateWorker'])) {
    $workerId = $_POST['workerId'];
    $rating = $_POST['rating'];

    
    $checkRatingSql = "SELECT * FROM ratings WHERE worker_id = ?";
    $checkStmt = $conn->prepare($checkRatingSql);
    $checkStmt->bind_param('i', $workerId);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows == 0) {
     
        $insertRatingSql = "INSERT INTO ratings (worker_id, rating) VALUES (?, ?)";
        $insertStmt = $conn->prepare($insertRatingSql);
        $insertStmt->bind_param('ii', $workerId, $rating);
        $insertStmt->execute();
    } else {
        
        $updateRatingSql = "UPDATE ratings SET rating = ? WHERE worker_id = ?";
        $updateStmt = $conn->prepare($updateRatingSql);
        $updateStmt->bind_param('ii', $rating, $workerId);
        $updateStmt->execute();
    }
}


$ratingsSql = "SELECT worker_id, AVG(rating) AS average_rating FROM ratings GROUP BY worker_id";
$ratingsResult = $conn->query($ratingsSql);


$workerRatings = array();
while ($row = $ratingsResult->fetch_assoc()) {
    $workerRatings[$row['worker_id']] = $row['average_rating'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Skilled Workers</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php
    include('navbar.php');
    ?>
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h4 class="card-header text-center bg-dark text-light">Skilled Worker Profiles</h4>

                <form method="post" class="mb-3">
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label for="searchTerm">Search by Name or Skill:</label>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Enter search term"
                                    name="searchTerm">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-primary" type="submit" name="search">Search</button>
                                    <a type="submit" href="service_request.php" class="btn btn-success ml-2"
                                        name="selectWorker">Select</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

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
                            <th>Rate Worker</th>
                            <th>Rating</th>
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

                                <td>
                                    <form method="post">
                                        <input type="hidden" name="workerId" value="<?php echo $worker['id']; ?>">
                                        <div class="form-row align-items-center">
                                            <div class="col-auto">
                                                <label for="rating" class="sr-only">Rate Worker</label>
                                                <select class="custom-select" name="rating" id="rating">
                                                    <option value="1">1 - Poor</option>
                                                    <option value="2">2 - Fair</option>
                                                    <option value="3">3 - Average</option>
                                                    <option value="4">4 - Good</option>
                                                    <option value="5">5 - Excellent</option>
                                                </select>
                                            </div>
                                            <div class="col-auto">
                                                <button type="submit" class="btn btn-primary" name="rateWorker">Rate
                                                    Worker</button>
                                            </div>
                                        </div>
                                    </form>
                                </td>
                                <td>
                                    <?php echo isset($workerRatings[$worker['id']]) ? number_format($workerRatings[$worker['id']], 1) : 'Not rated yet'; ?>
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
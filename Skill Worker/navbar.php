<?php
include('config.php');
$userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
if ($userId !== null) {
    $userNameSql = "SELECT username FROM worker WHERE id = ?";
    $userNameStmt = $conn->prepare($userNameSql);

    $userNameStmt->bind_param('i', $userId);
    $userNameStmt->execute();

    $userNameResult = $userNameStmt->get_result();

    if ($userNameRow = $userNameResult->fetch_assoc()) {
        $userName = $userNameRow['username'];
    }
}
?>
<nav class="navbar navbar-expand-lg stickynavbar-fixed-top navbar-dark bg-dark" style="background-color: rgba(0, 0, 0, 0.3) !important; border: none;">
    <img src="../imgs/logo3.png" alt="Skill Hub Logo" class="mr-2" style="border-radius: 50%; width: 15%;">

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="../index.php">Home</a>
            </li>
            <?php if (!isset($userId)): ?>
            
                <li class="nav-item">
                    <a class="nav-link" href="../Admin/Admin_login.php">Admin Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../User/user_login.php">User Login</a>
                </li>
            <?php endif; ?>
            <?php if (isset($userId)): ?>
               
                <li class="nav-item">
                    <a class="nav-link" href="approved_request.php">Approved Requests</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="SkillWoerkerPanel.php">Worker Panel</a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item float-right">
            <?php if (isset($userId)): ?>
                <a class="nav-link text-danger" href="logout.php" style="font-size: 23px;">
                    <?php
                    echo 'Welcome! ' . $userName . ' (' . $userId . ')';
                    ?> Logout</a>
            <?php endif; ?>
        </li>
    </ul>
</nav>

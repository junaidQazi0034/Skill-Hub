<nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="background-color: rgba(0, 0, 0, 0.3) !important; border: none;">
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
            <?php if (!isset($_SESSION['user_id'])): ?>
                <li class="nav-item ">
                    <a class="nav-link" href="../User/user_login.php">User Login</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" href="../Skill_Worker/Worker_login.php">Skill Worker Login</a>
                </li>
            <?php endif; ?>
            <?php if (isset($_SESSION['user_id'])): ?>
                <li class="nav-item">
                    <a class="nav-link" href="ManageService_request.php">Manage Service Request</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="dashboard.php">Manage Skilled Worker Profile</a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item float-right">
            <?php if (isset($_SESSION['user_id'])): ?>
                <a class="nav-link text-danger" href="logout.php" style="font-size: 23px;">
                <?php
                $userId = $_SESSION['user_id'];
                $userNameSql = "SELECT username FROM admins WHERE id = ?";
                $userNameStmt = $conn->prepare($userNameSql);
                $userNameStmt->bind_param('i', $userId);
                $userNameStmt->execute();
                $userNameResult = $userNameStmt->get_result();
                if ($userNameRow = $userNameResult->fetch_assoc()) {
                    $userName = $userNameRow['username'];
                    echo 'Welcome! ' . $userName . ' (' . $_SESSION['user_id'] . ')';
                }
            ?> Logout</a>
            <?php endif; ?>
        </li>
    </ul>
</nav>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Our Website</title>
    <style>
   
        body {
            background: url('imgs/background.PNG') no-repeat center center fixed;
            background-size: cover;
            height: 95vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
        }

        .welcome-container {
            text-align: center;
        }

        .welcome-text {
            font-size: 2em;
            margin-bottom: 20px;
            color: black;
            font-weight: bold;
        }

        .btn {
            font-size: 1.5em;
            padding: 10px 20px;
            background:#3352FF;
            border-radius:5px;
            color: black;
          
            
        }
    </style>
</head>

<body>

    <div class="container welcome-container">
        <div class="welcome-text">
            <h1>Welcome to Our Skill-Hub</h1>
            <p>Your tagline or additional information can go here.</p>
        </div>
        <a href="User/user_login.php"class="btn btn-login">Login</a>
       <a href="User/create_account.php" class="btn btn-signup">Sign Up</a>
    </div>

</body>

</html>

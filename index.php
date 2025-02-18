<?php
session_start();
require_once('assets/constants/config.php');
require_once('assets/constants/fetch-my-info.php');

$sql = "SELECT * FROM manage_website WHERE status='0'";
$statement = $conn->prepare($sql);
$statement->execute();
$row = $statement->fetch(PDO::FETCH_ASSOC);
extract($row);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="admin/assets/vendor/bootstrap/css/bootstrap.min.css">
    <link href="admin/assets/vendor/fonts/circular-std/style.css" rel="stylesheet">
    <link rel="stylesheet" href="admin/assets/libs/css/style.css">
    <link rel="stylesheet" href="admin/assets/vendor/fonts/fontawesome/css/fontawesome-all.css">

    <style>
        body {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-image: url('assets/uploadImage/Logo/<?php echo $background_login_image; ?>');
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            margin: 0;
        }
        .splash-container {
            width: 100%;
            max-width: 400px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            background-color: rgba(255, 255, 255, 0.95);
            margin: 0 auto; /* Center horizontally */
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
        .card-body {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
        }
        .card-body form {
            width: 100%;
        }
        .form-group input {
            padding: 12px;
            font-size: 16px;
        }
    </style>
</head>

<body>
    <div class="splash-container">
        <div class="card">
            <div class="card-header text-center">
                <a href="../index.php">
                    <img class="img-fluid" src="assets/uploadImage/Logo/<?php echo $logo; ?>" style="width:300px;height:auto;" alt="Theme-Logo">
                </a>
            </div>
            <div class="card-body">
                <?php require_once('assets/constants/check-reply.php'); ?>
                <form action="assets/app/auth.php" method="POST" autocomplete="OFF">
                    <div class="form-group">
                        <input class="form-control form-control-lg" type="text" placeholder="Email" name="email" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <input class="form-control form-control-lg" type="password" placeholder="Password" name="password">
                    </div>
                    <div class="form-group text-center">
                        <label class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox">
                            <span class="custom-control-label">Remember Me</span>
                        </label>
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg btn-block">Sign in</button>
                </form>
            </div>
        </div>
    </div>

    <script src="admin/assets/vendor/jquery/jquery-3.3.1.min.js"></script>
    <script src="admin/assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
</body>
</html>

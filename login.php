<?php

session_start();
require 'config/db.php';

if ($_SERVER["REQUEST_METHOD"] === 'POST') {
    if (isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM `users` WHERE username= ? AND password = ? ";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $username, $password);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $rows = mysqli_num_rows($result);

        echo "Rows: " . $rows . "<br>";
        echo "Username: " . $username . "<br>";

        if ($rows === 1) {
            $user = mysqli_fetch_assoc($result);
            session_regenerate_id(true);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['court_name'] = $user['court_name'];
            header("Location:welcome.php");
            exit();
        } else {
            echo "<script>alert('Invalid Login');</script>";
        }
    }
}



?>
<?php require "includes/header.php"; ?>

<div class="login-page">
    <div class="card shadow text-center" id="loginCard">
        <div class="card-header">
            <h3 class="text-light">District Court Kohima</h3>
            <p class="fw-bold text-light">Login</p>
        </div>

        <div class="card-body p-5">
            <form method="post">

                <!-- Username -->
                <div class="mb-3 text-start">
                    <label class="username text-light" required>USER NAME</label>
                    <input type="text" class="form-control" name="username" id="username" maxlength="50" required>
                </div>

                <!-- Password -->
                <div class="mb-3 text-start">
                    <label class="password text-light" required>PASSWORD</label>
                    <input type="password" class="form-control" name="password" id="password" maxlength="50" required>
                </div>

                <!-- Button -->
                <button type="submit" class="btn btn-box w-100" name="login">Log In</button>
            </form>
        </div>
    </div>
</div>



<?php require "includes/script.php"; ?>
<?php require "includes/footer.php"; ?>
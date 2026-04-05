<?php

session_start();

// 🔒 If already logged in → go to welcome page
if (isset($_SESSION['user_id'])) {
    header("Location: welcome.php");
    exit();
}

require 'config/db.php';

// 🔁 Initialize attempts
if (!isset($_SESSION['attempts'])) {
    $_SESSION['attempts'] = 0;
    $_SESSION['last_attempt_time'] = time();
}

// 🚫 Block after 4 attempts
if ($_SESSION['attempts'] >= 4) {
    $wait = 300; // 5 minutes

    if (time() - $_SESSION['last_attempt_time'] < $wait) {
        die("Too many login attempts. Please wait 5 minutes.");
    } else {
        // Reset after wait time
        $_SESSION['attempts'] = 0;
    }
}

// 🔐 Handle login
if ($_SERVER["REQUEST_METHOD"] === 'POST') {

    if (isset($_POST['login'])) {

        $username = trim($_POST['username']);
        $password = trim($_POST['password']);

        $sql = "SELECT * FROM users WHERE username = ? AND password = ?";
        $stmt = mysqli_prepare($conn, $sql);

        mysqli_stmt_bind_param($stmt, "ss", $username, $password);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) === 1) {

            // ✅ Reset attempts
            $_SESSION['attempts'] = 0;

            $user = mysqli_fetch_assoc($result);

            // 🔐 Secure session
            session_regenerate_id(true);

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['court_name'] = $user['court_name'];
            $_SESSION['court_id'] = $user['court_id'];

            header("Location: welcome.php");
            exit();

        } else {

            // ❌ Increase attempts
            $_SESSION['attempts']++;
            $_SESSION['last_attempt_time'] = time();

            echo "<script>alert('Invalid Login');</script>";
        }
    }
}
?>

<!-- LOGIN UI -->
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
                    <label class="text-light">USER NAME</label>
                    <input type="text" class="form-control" name="username" maxlength="50" required>
                </div>

                <!-- Password -->
                <div class="mb-3 text-start">
                    <label class="text-light">PASSWORD</label>
                    <input type="password" class="form-control" name="password" maxlength="50" required>
                </div>

                <!-- Button -->
                <button type="submit" class="btn btn-box w-100" name="login">
                    Log In
                </button>

            </form>
        </div>

    </div>
</div>
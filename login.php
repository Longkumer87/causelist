<?php require 'config/db.php'; ?>
<?php require "includes/header.php"; ?>


<div class="card login-card shadow text-center" style="background-color: antiquewhite; max-width:400px; margin:80px auto;">
    
    <div class="card-header">
        <h3>District Court Kohima</h3>
        <p class="fw-bold">Login</p>
    </div>

    <div class="card-body p-5">
        <form>

            <!-- Username -->
            <div class="mb-3 text-start">
                <label class="uname">Username</label>
                <input type="text" class="form-control" name="uname" id="uname">
            </div>

            <!-- Password -->
            <div class="mb-3 text-start">
                <label class="password">Password</label>
                <input type="password" class="form-control" name="password" id="password">
            </div>

            <!-- Button -->
            <button type="submit" class="btn btn-secondary w-100">Log In</button>

        </form>
    </div>

</div>


<?php require "includes/script.php"; ?>
<?php require "includes/footer.php"; ?>
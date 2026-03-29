
<nav class="navbar navbar-dark bg-secondary px-3">
    <div class="container-fluid p-0">

        <!-- Court Name -->
        <span class="navbar-brand fw-bold mb-0">
            <i class="bi bi-building me-1"></i><?= htmlspecialchars($_SESSION['court_name'] ?? ''); ?>
        </span>

        <!-- Hamburger toggle (mobile only) -->
        <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Desktop buttons (always visible on large screens) -->
        <div class="d-none d-lg-flex align-items-center gap-3">
            <a href="history.php" class="btn btn-info">
                <i class="bi bi-binoculars"></i> View Cause Lists
            </a>
            <button type="submit" class="btn btn-success">
                <i class="bi bi-bookmark-check"></i> Save Cause List
            </button>
            <a href="logout.php" class="btn btn-danger">
                <i class="bi bi-power"></i> Logout
            </a>
        </div>

        <!-- Mobile collapse menu -->
        <div class="collapse navbar-collapse d-lg-none" id="navbarContent">
            <div class="d-flex flex-column gap-2 py-2">
                <a href="history.php" class="btn btn-info btn-sm">
                    <i class="bi bi-binoculars"></i> View Cause Lists
                </a>
                <button type="submit" class="btn btn-success btn-sm">
                    <i class="bi bi-bookmark-check"></i> Save Cause List
                </button>
                <a href="logout.php" class="btn btn-danger btn-sm">
                    <i class="bi bi-power"></i> Logout
                </a>
            </div>
        </div>

    </div>
</nav>

<h5 class="fw-bold text-center mt-2"><?= htmlspecialchars($court_name); ?></h5>
<h5 class="text-center">KOHIMA : NAGALAND</h5>

<div class="container-fluid">

    <form action="save.php" method="post" onsubmit="return confirm('Are you sure you want to save?')">

        <!-- Cause Date -->
        <div class="row mb-3 justify-content-center align-items-center">
            <div class="col-12 col-md-4 text-center">
                <label class="form-label fw-bold">ADD CAUSE LIST DATE : </label>
            </div>

            <div class="col-12 col-md-4">
                <input type="date" class="form-control" name="cause_date" id="cause_date" required>
            </div>
        </div>


        <!-- Table -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="causeTable">
                <thead class="table-dark">
                    <tr>
                        <th class="text-center">S.No</th>
                        <th class="text-center">Case No</th>
                        <th class="text-center">Parties</th>
                        <th class="text-center">Counsel</th>
                        <th class="text-center">Remark</th>
                        <th class="text-center">Next Date</th>
                        <th class="text-center" style="min-width:120px;">Action</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td class="text-center fw-bold">1</td>
                        <td><input type="text" class="form-control" name="case_no[]" required></td>
                        <td><textarea class="form-control" name="parties[]" style="min-width: 180px;" required></textarea></td>
                        <td><input type="text" class="form-control" name="counsel[]"></td>
                        <td><input type="text" class="form-control" name="remark[]"></td>
                        <td><input type="date" class="form-control" name="next_date[]"></td>
                       <td class="text-center">
    <div class="d-flex gap-2 justify-content-center">
        <button type="button" class="btn btn-primary btn-sm" onclick="addRow()">
            <i class="bi bi-file-plus"></i> Add
        </button>
        <button type="button" class="btn btn-danger btn-sm" onclick="deleteRow(this)">
            <i class="bi bi-trash3"></i> Delete
        </button>
    </div>
</td>
                    </tr>
                </tbody>
            </table>
        </div>

    </form>

</div>
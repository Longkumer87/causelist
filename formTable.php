<nav class="navbar navbar-dark bg-secondary px-3">
    <div class="container-fluid p-0 d-flex justify-content-between align-items-center">

        <!-- Court Name -->
        <span class="navbar-brand fw-bold mb-0 text-truncate" style="max-width: 70%;">
            <i class="bi bi-building me-1"></i><?= htmlspecialchars($court_name); ?>
        </span>

        <!-- Logout -->
        <a href="logout.php" class="btn btn-danger btn-sm px-3">
            <i class="bi bi-power"></i> Logout
        </a>

    </div>
</nav>

<h5 class="fw-bold text-center mt-2"><?= htmlspecialchars($court_name); ?></h5>
<h5 class="text-center">KOHIMA : NAGALAND</h5>

<div class="container-fluid">

    <form action="save.php" method="post" onsubmit="return confirm('Are you sure you want to save?')">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
        <!-- <input type="hidden" name="cause_date" value="<?= htmlspecialchars($date); ?>"> -->

        <!-- Cause Date -->
        <div class="row mb-3 justify-content-center align-items-center">
            <div class="col-12 col-md-4 text-center">
                <label class="form-label fw-bold">ADD CAUSE LIST DATE : </label>
            </div>

            <div class="col-12 col-md-4">
                <input type="date" class="form-control" name="cause_date" id="cause_date" min="<?php echo date('Y-m-d'); ?>" required>
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
                        <td>
                            <input type="text" class="form-control" name="case_no[]" list="caseTypeList" required>
                            <datalist id="caseTypeList">
                                <?php foreach ($case_types as $type): ?>
                                    <option value="<?php echo $type['type_name']; ?>">
                                    <?php endforeach; ?>
                            </datalist>
                        </td>
                        <td><textarea class="form-control" name="parties[]" style="min-width: 180px;" required></textarea></td>
                        <td><textarea class="form-control" name="counsel[]" style="min-width: 180px;" required></textarea></td>
                        <td><textarea class="form-control" name="remarks[]" style="min-width: 180px;" required></textarea></td>

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

        <div class="row mb-3 mt-3">

            <!-- View Button -->
            <div class="col-12 col-md-6 text-md-start mb-2 mb-md-0">
                <a href="history.php" class="btn btn-info">
                    <i class="bi bi-binoculars"></i> View Cause Lists
                </a>
            </div>

            <!-- Save Button -->
            <div class="col-12 col-md-6 text-md-end">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-bookmark-check"></i> Save Cause List
                </button>
            </div>

        </div>

    </form>

</div>
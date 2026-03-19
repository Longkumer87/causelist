<div class="container-fluid">

    <form action="save.php" method="post">

        <!-- Cause Date -->
        <div class="row mb-3 justify-content-center align-items-center">
            <div class="col-12 col-md-4 text-center">
                <label class="form-label fw-bold">CAUSE LIST DATE : </label>
            </div>

            <div class="col-12 col-md-4">
                <input type="date" class="form-control" name="cause_date" id="cause_date" required>
            </div>
        </div>

        <!-- Buttons -->
        <div class="row mb-3 g-2 text-center">
            <div class="col-12 col-md-4">
                <button type="button" class="btn btn-primary w-100" onclick="addRow()">Add Row</button>
            </div>

            <div class="col-12 col-md-4">
                <a href="history.php" class="btn btn-info w-100">View Cause Lists</a>
            </div>

            <div class="col-12 col-md-4">
                <button type="submit" class="btn btn-success w-100">Save Cause List</button>
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
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>1</td>
                        <td><input type="text" class="form-control" name="case_no[]" required></td>
                        <td><textarea class="form-control" name="parties[]" required></textarea></td>
                        <td><input type="text" class="form-control" name="counsel[]"></td>
                        <td><input type="text" class="form-control" name="remark[]"></td>
                        <td><input type="date" class="form-control" name="next_date[]"></td>
                    </tr>
                </tbody>
            </table>
        </div>

    </form>

</div>
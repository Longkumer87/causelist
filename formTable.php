  <form action="save.php" method="post">
      <div class="container mb-2">
          <label for="causeListDate"><h3 class="text-center"> CAUSE LIST DATE :</h3></label>
          <input type="date" class="form-control" name="cause_date" id="cause_date" required>
      </div>

      <div class="mb-2">
          <button type="button" class="btn btn-primary" onclick="addRow()">Add Row</button>
          <button type="submit" class="btn btn-success">Save Cause List</button>
          <a href="history.php" class="btn btn-info">View Available Cause Lists</a>
      </div>

      <table class="table table-bordered" id="causeTable">
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
                  <td><textarea class="form-control" name="parties[]"></textarea required></td>
                  <td><input type="text" class="form-control" name="counsel[]"></td>
                  <td> <input type="text" class="form-control" name="remark[]"></td>
                  <td><input type="date" class="form-control" name="next_date[]"></td>
              </tr>
          </tbody>
      </table>
  </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>

    <script>
        function addRow() {

            let table = document.getElementById("causeTable").getElementsByTagName('tbody')[0];

            let rowCount = table.rows.length;

            let row = table.insertRow();

            row.innerHTML = `
<td>${rowCount + 1}</td>

<td><input type="text" class="form-control" name="case_no[]"></td>

<td><input type="text" class="form-control" name="parties[]"></td>

<td><input type="text" class="form-control" name="counsel[]"></td>

<td><input type="text" class="form-control" name="remark[]"></td>

<td><input type="date" class="form-control" name="next_date[]"></td>
`;

        }
    </script>

    <!-- <script>
        document.querySelector("form").addEventListener("keydown", function(e) {
            if (e.key === "Enter") {
                e.preventDefault();
            }
        });
    </script> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>

    <script>
        function addRow() {

            let table = document.getElementById("causeTable").getElementsByTagName('tbody')[0];

            let rowCount = table.rows.length;

            let row = table.insertRow();

            row.innerHTML = `
<td class="text-center fw-bold">${rowCount + 1}</td>

<td><input type="text" class="form-control" name="case_no[]" required></td>

<td><textarea class="form-control" name="parties[]" style="min-width: 180px;" required></textarea></td>

<td><input type="text" class="form-control" name="counsel[]"></td>

<td><input type="text" class="form-control" name="remark[]"></td>

<td><input type="date" class="form-control" name="next_date[]"></td>
<td class="text-center"><button type="button" class="btn btn-danger btn-sm" onclick="deleteRow(this)">Delete</button></td>`;

        }
    </script>

    <script>
        function deleteRow(btn){
            let row = btn.closest("tr");
            row.remove();

            updateSerialNumbers();
        }
    </script>

    <script>
        function updateSerialNumbers(){
           let rows =  document.querySelectorAll("#causeTable tbody tr");
           rows.forEach((row, index)=>{
            row.cells[0].innerText = index + 1;
           });
        }
    </script>

    <script>
document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");

    form.addEventListener("keydown", function (e) {
        if (e.key === "Enter") {

            // Allow Enter in textarea (new line)
            if (e.target.tagName.toLowerCase() === "textarea") {
                return;
            }

            // Prevent form submit
            e.preventDefault();

            // Move to next field
            const inputs = Array.from(form.querySelectorAll("input, textarea"));
            const index = inputs.indexOf(e.target);

            if (index > -1 && index < inputs.length - 1) {
                inputs[index + 1].focus();
            }
        }
    });
});
</script>


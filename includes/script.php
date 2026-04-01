    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>

    <!-- Adds a new row to the cause list table -->
    <script>
        function addRow() {
            let table = document.getElementById("causeTable").getElementsByTagName('tbody')[0];
            let rowCount = table.rows.length;
            let row = table.insertRow();
            row.innerHTML = `
        <td class="text-center fw-bold">${rowCount + 1}</td>
        <td><input type="text" class="form-control form-control-sm" name="case_no[]" required></td>
        <td><textarea class="form-control form-control-sm" name="parties[]" rows="2" required></textarea></td>
        <td><input type="text" class="form-control form-control-sm" name="counsel[]"></td>
        <td><input type="text" class="form-control form-control-sm" name="remark[]"></td>
        <td><input type="date" class="form-control form-control-sm" name="next_date[]"></td>
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
    `;
        }
    </script>

    <!-- Permanently removes a row from the table and updates serial numbers -->
    <script>
        function deleteRow(btn) {
            let row = btn.closest("tr");
            row.remove();
            updateSerialNumbers();
        }
    </script>

    <!-- Renumbers the S.No column after a row is deleted -->
    <script>
        function updateSerialNumbers() {
            let rows = document.querySelectorAll("#causeTable tbody tr");
            rows.forEach((row, index) => {
                row.cells[0].innerText = index + 1;
            });
        }
    </script>

    <!-- Prevents accidental form submission on Enter key; moves focus to next field instead -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const form = document.querySelector("form");

            form.addEventListener("keydown", function(e) {
                if (e.key === "Enter") {

                    // Allow Enter in textarea (for new lines)
                    if (e.target.tagName.toLowerCase() === "textarea") {
                        return;
                    }

                    // Prevent form submit on Enter
                    e.preventDefault();

                    // Move focus to the next input/textarea field
                    const inputs = Array.from(form.querySelectorAll("input, textarea"));
                    const index = inputs.indexOf(e.target);

                    if (index > -1 && index < inputs.length - 1) {
                        inputs[index + 1].focus();
                    }
                }
            });
        });
    </script>

    <!-- Soft-deletes a row: marks it for deletion on the server and hides it visually -->
    <!-- Used when rows need to be tracked server-side (e.g. editing existing saved records) -->
    <script>
        function markDelete(btn) {
            let row = btn.closest("tr");

            // Set the hidden delete flag to 1 so server knows to delete this row
            row.querySelector('input[name="delete[]"]').value = "1";

            // Hide the row visually without removing it from the DOM
            row.style.display = "none";
        }
    </script>

    <script>
        function shareWhatsApp(date, courtName) {

    fetch("generate_pdf.php?cause_date=" + date)
        .then(res => res.text())
        .then(filePath => {

            let baseUrl = "https://unexplorable-ashlee-ineffable.ngrok-free.dev/causelist";
            let pdfLink = baseUrl + "/" + filePath;

            let d = new Date(date);
            let formattedDate = d.getDate().toString().padStart(2, '0') + '-' +
                (d.getMonth() + 1).toString().padStart(2, '0') + '-' +
                d.getFullYear();

            let message = encodeURIComponent(
                "🏛️ District Court Kohima\n\n" +
                "⚖️ " + courtName + "\n" +
                "📄 CAUSE LIST FOR : " + formattedDate + "\n\n" +
                pdfLink
            );

            // ✅ Detect device
            let isMobile = /Android|iPhone|iPad|iPod/i.test(navigator.userAgent);

            if (isMobile) {
                window.open("https://wa.me/?text=" + message, "_blank");
            } else {
                window.open("https://web.whatsapp.com/send?text=" + message, "_blank");
            }

        });

}
    </script>
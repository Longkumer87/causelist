<script>
    function addRow() {
        let table = document.getElementById("causeTable").getElementsByTagName('tbody')[0];
        let rowCount = table.rows.length;
        let row = table.insertRow();
        row.innerHTML = `
        <td class="text-center fw-bold">${rowCount + 1}</td>
        <td><textarea class="form-control" name="case_no[]" rows="2" required></textarea></td>
        <td><textarea class="form-control" name="parties[]" rows="2"></textarea></td>
        <td><textarea class="form-control" name="counsel[]" rows="2"></textarea></td>
        <td><textarea class="form-control" name="remark[]" rows="2"></textarea></td>
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

    function deleteRow(btn) {
        let row = btn.closest("tr");
        row.remove();
        updateSerialNumbers();
    }

    function updateSerialNumbers() {
        let rows = document.querySelectorAll("#causeTable tbody tr");
        rows.forEach((row, index) => {
            row.cells[0].innerText = index + 1;
        });
    }

    document.addEventListener("DOMContentLoaded", function() {
        const form = document.querySelector("form");
        if (form) {
            form.addEventListener("keydown", function(e) {
                if (e.target.tagName.toLowerCase() === "textarea") return;
                if (e.key === "Enter" && e.target.tagName.toLowerCase() === "input") {
                    e.preventDefault();
                }
            });
        }
    });

    function markDelete(btn) {
        let row = btn.closest("tr");
        row.querySelector('input[name="delete[]"]').value = "1";
        row.style.display = "none";
    }


    function shareWhatsApp(date, courtName) {
        fetch("generate_pdf.php?cause_date=" + date)
            .then(res => res.text())
            .then(filePath => {
                let baseUrl = "https://unexplorable-ashlee-ineffable.ngrok-free.dev";
                let pdfLink = baseUrl + "/causelist/" + filePath;

                let d = new Date(date);
                let formattedDate = d.getDate().toString().padStart(2, '0') + '-' +
                    (d.getMonth() + 1).toString().padStart(2, '0') + '-' +
                    d.getFullYear();

               let meetLink = getMeetLink(typeof court_id !== 'undefined' ? court_id : 0);

                let message = encodeURIComponent(
                    "🏛️ District Court Kohima\n\n" +
                    "⚖️ " + courtName + "\n" +
                    "📄 CAUSE LIST FOR : " + formattedDate + "\n\n" +
                    pdfLink + "\n\n" +
                    "🎥 Google Meet:\n" + meetLink
                );

                let isMobile = /Android|iPhone|iPad|iPod/i.test(navigator.userAgent);
                if (isMobile) {
                    window.open("https://wa.me/?text=" + message, "_blank");
                } else {
                    window.open("https://web.whatsapp.com/send?text=" + message, "_blank");
                }
            });
    }


</script>
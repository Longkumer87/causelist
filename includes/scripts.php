<script>
    //on adding new
    function addRow() {
        let table = document.getElementById("causeTable").getElementsByTagName('tbody')[0];
        let rowCount = table.rows.length;
        let row = table.insertRow();
        row.innerHTML = `
        <td class="text-center fw-bold">
         <input type="hidden" name="id[]">
        <input type="hidden" name="delete[]" value="0">
        ${rowCount + 1}</td>
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

    //for edit
    function insertRow(btn, position) {
    let table = document.getElementById("causeTable").getElementsByTagName('tbody')[0];
    let currentRow = btn.closest("tr");
    let currentIndex = currentRow.rowIndex - 1; // subtract thead

    let newRow = table.insertRow(position === 'above' ? currentIndex : currentIndex + 1);

    newRow.innerHTML = `
        <td class="text-center fw-bold">
            <input type="hidden" name="id[]">
            <input type="hidden" name="delete[]" value="0">
        </td>
        <td><textarea class="form-control" name="case_no[]" rows="2" required></textarea></td>
        <td><textarea class="form-control" name="parties[]" rows="2"></textarea></td>
        <td><textarea class="form-control" name="counsel[]" rows="2"></textarea></td>
        <td><textarea class="form-control" name="remark[]" rows="2"></textarea></td>
        <td><input type="date" class="form-control form-control-sm" name="next_date[]"></td>
        <td class="text-nowrap">
            <div class="d-flex gap-1 justify-content-center flex-wrap">
                <button type="button" class="btn btn-primary btn-sm" onclick="insertRow(this, 'above')">
                    <i class="bi bi-arrow-up"></i> Above
                </button>
                <button type="button" class="btn btn-primary btn-sm" onclick="insertRow(this, 'below')">
                    <i class="bi bi-arrow-down"></i> Below
                </button>
                <button type="button" class="btn btn-danger btn-sm" onclick="markDelete(this)">
                    <i class="bi bi-trash3"></i> Delete
                </button>
            </div>
        </td>
    `;

    updateSerialNumbers();
}

function updateSerialNumbers() {
    let rows = document.querySelectorAll("#causeTable tbody tr");
    let counter = 1;
    rows.forEach((row) => {
        if (row.style.display === "none") return; // skip hidden/deleted rows
        let cell = row.cells[0];
        Array.from(cell.childNodes).forEach(node => {
            if (node.nodeType === Node.TEXT_NODE) {
                node.remove();
            }
        });
        cell.appendChild(document.createTextNode(counter));
        counter++;
    });
}


    function deleteRow(btn) {
        let row = btn.closest("tr");
        row.remove();
        updateSerialNumbers();
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
    row.querySelectorAll('[required]').forEach(el => el.removeAttribute('required'));
     updateSerialNumbers();
}


    function shareWhatsApp(date, courtName) {
        fetch("generate_pdf.php?cause_date=" + date)
            .then(res => res.text())
            .then(() => {
                return fetch("generate_whatsapp.php?cause_date=" + date + "&court_name=" + encodeURIComponent(courtName));
            })
            .then(res => res.text())
            .then(message => {
                let isMobile = /Android|iPhone|iPad|iPod/i.test(navigator.userAgent);
                if (isMobile) {
                    window.open("https://wa.me/?text=" + message, "_blank");
                } else {
                    window.open("https://web.whatsapp.com/send?text=" + message, "_blank");
                }
            });
    }
</script>
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
        <td><textarea class="form-control case_no" name="case_no[]" rows="2" required></textarea></td>
        <td><textarea class="form-control parties" name="parties[]" rows="2"></textarea></td>
        <td><textarea class="form-control counsel" name="counsel[]" rows="2"></textarea></td>
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

    
    //double or duplicate entry
const form = document.querySelector("form");
if (form) {
    form.addEventListener("submit", function(e) {

        let seen = {};
        let duplicateGroups = [];
        let reported = {};

        document.querySelectorAll(".case_no").forEach(textarea => {
            let row = textarea.closest("tr");
            if (row.style.display === "none") return; // skip deleted rows

            let raw = textarea.value.trim();
            let val = raw.toLowerCase().replace(/\s+/g, '');
            if (val === "") return;

            let parties = row.querySelector(".parties")?.value.trim() || '-';
            let counsel = row.querySelector(".counsel")?.value.trim() || '-';

            if (seen[val]) {
                if (!reported[val]) {
                    duplicateGroups.push({
                        case_no: raw,
                        first: seen[val],
                        second: { parties, counsel }
                    });
                    reported[val] = true;
                }
            } else {
                seen[val] = { parties, counsel };
            }
        });

        if (duplicateGroups.length > 0) {
            let message = "This case number appears more than once for this date:\n\n";
            duplicateGroups.forEach(d => {
                message += `Case No: ${d.case_no}\n`;
                message += `Entry 1 - Parties: ${d.first.parties} | Advocate: ${d.first.counsel}\n`;
                message += `Entry 2 - Parties: ${d.second.parties} | Advocate: ${d.second.counsel}\n\n`;
            });
            message += "Click OK to save both entries anyway, or Cancel to stay on this page.";

            if (!confirm(message)) {
                e.preventDefault();
            }
        }

    });
}


    //for edit
    function insertRow(btn, position) {
        let table = document.getElementById("causeTable").getElementsByTagName('tbody')[0];
        let currentRow = btn.closest("tr");
        let currentIndex = currentRow.rowIndex - 1;

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
            if (row.style.display === "none") return;
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

    //to import case details to the table
    document.addEventListener("blur", function(e) {
        if (e.target.classList.contains("case_no")) {
            let caseNo = e.target.value.trim();
            if (caseNo === "") return;

            let row = e.target.closest("tr");

            fetch("get_case.php?case_no=" + encodeURIComponent(caseNo))
                .then(res => res.json())
                .then(data => {
                    if (data) {
                        row.querySelector(".parties").value = data.parties || '';
                        row.querySelector(".counsel").value = data.counsel || '';
                    }
                });
        }
    }, true);

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
    let newWindow = window.open("", "_blank");
    fetch("generate_whatsapp.php?cause_date=" + date + "&court_name=" + encodeURIComponent(courtName))
        .then(res => res.text())
        .then(message => {
            let encodedMessage = encodeURIComponent(message);
            let isMobile = /Android|iPhone|iPad|iPod/i.test(navigator.userAgent);
            let url = isMobile
                 ? "whatsapp://send?text=" + encodedMessage
                : "https://web.whatsapp.com/send?text=" + encodedMessage;
                // ? "https://wa.me/?text=" + encodedMessage
                // : "https://web.whatsapp.com/send?text=" + encodedMessage;
            newWindow.location.href = url;
        })
        .catch(err => {
            newWindow.close();
            alert("Error: " + err.message);
        });
}

</script>
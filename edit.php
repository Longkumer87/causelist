<?php require 'config/db.php'; ?>
<?php require "includes/header.php"; ?>

<?php
$date = $_GET['cause_date'] ?? '';

if (empty($date)) {
    header("Location: history.php");
    exit;
}

$sql = "SELECT * FROM causelist WHERE cause_date='$date'";
$result = mysqli_query($conn, $sql);
$rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<div class="container mt-3">

    <h4 class="text-center">Edit Cause List</h4>
    <h5 class="text-center">
        <?= date("d F Y", strtotime($date)); ?>
    </h5>

    <form action="save.php" method="post">
        <input type="hidden" name="cause_date" value="<?= $date; ?>">

        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>S.No</th>
                    <th>Case No</th>
                    <th>Parties</th>
                    <th>Counsel</th>
                    <th>Remark</th>
                    <th>Next Date</th>
                </tr>
            </thead>

            <tbody>
                <?php $i = 1; ?>
                <?php foreach ($rows as $row): ?>
                    <tr>

                        <!-- hidden id -->
                        <input type="hidden" name="id[]" value="<?= $row['id']; ?>">

                        <td><?= $i++; ?></td>

                        <td>
                            <input type="text" name="case_no[]" class="form-control" value="<?= $row['case_no']; ?>">
                        </td>

                        <td>
                            <textarea name="parties[]" class="form-control"><?= $row['parties']; ?></textarea>
                        </td>

                        <td>
                            <input type="text" name="counsel[]" class="form-control" value="<?= $row['counsel']; ?>">
                        </td>

                        <td>
                            <input type="text" name="remark[]" class="form-control" value="<?= $row['remark']; ?>">
                        </td>

                        <td>
                            <input type="date" name="next_date[]" class="form-control" value="<?= $row['next_date']; ?>">
                        </td>

                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="text-end">
            <button type="submit" class="btn btn-success">Save</button>
        </div>

    </form>

</div>

<?php require "includes/footer.php"; ?>
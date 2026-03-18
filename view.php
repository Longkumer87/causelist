<?php require 'config/db.php'; ?>
<?php


$date = $_GET['cause_date'] ?? '';
if(empty($date)){
    header("Location: history.php");
    exit;
}
$sql = "SELECT * FROM `causelist` WHERE cause_date='$date'";
$result = mysqli_query($conn, $sql);
$rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<?php require "includes/header.php"; ?>

<?php if(empty($rows)):?>
    <?="No cause list Listed ";?>
    <?php else:?>

<div class="container mt-3">

    <h4 class="text-center">IN THE COURT OF THE</h4>
    <h4 class="text-center">PRINCIPAL DISTRICT & SESSIONS JUDGE</h4>
    <h4 class="text-center">KOHIMA : NAGALAND</h4>
    <br>

    <h5 class="text-center">CAUSE LIST FOR : <?=!empty($date) ? date("d F Y", strtotime($date)):'No Date Selected'; ?></h5>

    <table class="table table-bordered">
        <thead class="table-secondary">
            <tr>
                  <th class="text-center">S.No</th>
                  <th class="text-center">Case No</th>
                  <th class="text-center">Parties</th>
                  <th class="text-center">Counsel</th>
                  <th class="text-center">Remark</th>
                  <th class="text-center">Next Date</th>
              </tr>>
        </thead>

        <tbody>
            <?php $i=1; ?>
            <?php foreach ($rows as $row): ?>
                <tr>
                    <td><?= $i++; ?></td>
                    <td><?= $row['case_no']; ?></td>
                    <td><?= $row['parties']; ?></td>
                    <td><?= $row['counsel']; ?></td>
                    <td><?= $row['remark']; ?></td>
                    <td><?= ($row['next_date'] === '0000-00-00' || $row['next_date'] === '') ? '' : $row['next_date']; ?></td>

                </tr>
            <?php endforeach; ?>
        </tbody>

    </table>
</div>
<?php endif;?>

<?php require "includes/script.php"; ?>
<?php require "includes/footer.php"; ?>
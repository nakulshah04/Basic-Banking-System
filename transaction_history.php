<?php
require 'db.php';
include 'header.php';

$result = $conn->query("SELECT * FROM transaction ORDER BY id DESC");
?>
<h2 class="text-center mb-4">Transaction History</h2>
<table class="table table-bordered">
    <thead><tr><th>ID</th><th>Sender</th><th>Receiver</th><th>Amount</th></tr></thead>
    <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['sender']) ?></td>
                <td><?= htmlspecialchars($row['receiver']) ?></td>
                <td>$<?= number_format($row['amount'], 2) ?></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>
<?php include 'footer.php'; ?>
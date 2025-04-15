<?php
require 'db.php';
require 'functions.php';
include 'header.php';

$result = getAllCustomers($conn);
?>
<h2 class="text-center mb-4">All Customers</h2>
<table class="table table-bordered">
    <thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Balance</th><th>Action</th></tr></thead>
    <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td>$<?= number_format($row['balance'], 2) ?></td>
                <td><a href="money_transfer.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-success">Transfer</a></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>
<?php include 'footer.php'; ?>
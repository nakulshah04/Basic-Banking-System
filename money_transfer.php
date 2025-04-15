<?php
require 'db.php';
require 'functions.php';
include 'header.php';

if (!isset($_GET['id'])) {
    header('Location: user_details.php');
    exit;
}

$sender = getCustomerById($conn, $_GET['id']);
$receivers = getOtherCustomers($conn, $_GET['id']);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $receiver_id = $_POST['to'];
    $amount = floatval($_POST['amount']);

    $receiver = getCustomerById($conn, $receiver_id);

    if ($amount > 0 && $amount <= $sender['balance']) {
        $conn->begin_transaction();
        try {
            updateBalance($conn, $sender['id'], -$amount);
            updateBalance($conn, $receiver_id, $amount);
            recordTransaction($conn, $sender['name'], $receiver['name'], $amount);
            $conn->commit();
            echo "<div class='alert alert-success'>Transfer successful!</div>";
        } catch (Exception $e) {
            $conn->rollback();
            echo "<div class='alert alert-danger'>Transfer failed.</div>";
        }
    } else {
        echo "<div class='alert alert-warning'>Invalid amount.</div>";
    }
}
?>

<h2>Transfer Money from <?= htmlspecialchars($sender['name']) ?></h2>
<form method="post">
    <div class="form-group">
        <label>To:</label>
        <select name="to" class="form-control" required>
            <?php while ($row = $receivers->fetch_assoc()): ?>
                <option value="<?= $row['id'] ?>"><?= htmlspecialchars($row['name']) ?> ($<?= number_format($row['balance'], 2) ?>)</option>
            <?php endwhile; ?>
        </select>
    </div>
    <div class="form-group">
        <label>Amount:</label>
        <input type="number" name="amount" class="form-control" min="0.01" step="0.01" required>
    </div>
    <button type="submit" class="btn btn-primary">Transfer</button>
</form>
<?php include 'footer.php'; ?>
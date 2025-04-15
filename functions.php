<?php
function getAllCustomers($conn) {
    return $conn->query("SELECT * FROM users");
}

function getCustomerById($conn, $id) {
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function getOtherCustomers($conn, $exclude_id) {
    $stmt = $conn->prepare("SELECT * FROM users WHERE id != ?");
    $stmt->bind_param("i", $exclude_id);
    $stmt->execute();
    return $stmt->get_result();
}

function recordTransaction($conn, $sender, $receiver, $amount) {
    $stmt = $conn->prepare("INSERT INTO transaction (sender, receiver, amount) VALUES (?, ?, ?)");
    $stmt->bind_param("ssd", $sender, $receiver, $amount);
    return $stmt->execute();
}

function updateBalance($conn, $id, $delta) {
    $stmt = $conn->prepare("UPDATE users SET balance = balance + ? WHERE id = ?");
    $stmt->bind_param("di", $delta, $id);
    return $stmt->execute();
}
?>
<?php
session_start();
require '../../app/helpers/cart.php';

header('Content-Type: application/json');

$id = $_POST['id'] ?? null;
$action = $_POST['action'] ?? null;

if (!$id || !$action) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid data']);
    exit;
}

// Eksekusi aksi
if ($action === 'plus') {
    addToCart($id);
} elseif ($action === 'minus') {
    decreaseCart($id);
}

// Ambil qty item yang baru saja diupdate
$qty = $_SESSION['cart'][$id] ?? 0;

// HITUNG TOTAL QTY KERANJANG (Penting untuk update badge di Header secara real-time)
$totalQty = 0;
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $itemQty) {
        $totalQty += $itemQty;
    }
}

echo json_encode([
    'status' => 'ok',
    'qty' => $qty,
    'totalQty' => $totalQty // Data ini dibutuhkan oleh JavaScript yang kita buat tadi
]);
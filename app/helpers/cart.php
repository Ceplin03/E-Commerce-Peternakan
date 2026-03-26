<?php

function getCart() {
    return $_SESSION['cart'] ?? [];
}

function addToCart($id) {
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    $_SESSION['cart'][$id] = ($_SESSION['cart'][$id] ?? 0) + 1;
}

function decreaseCart($id) {
    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]--;

        if ($_SESSION['cart'][$id] <= 0) {
            unset($_SESSION['cart'][$id]);
        }
    }
}

function removeFromCart($id) {
    if (isset($_SESSION['cart'][$id])) {
        unset($_SESSION['cart'][$id]);
    }
}

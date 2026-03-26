<?php
function adminOnly() {
    if (!isset($_SESSION['admin'])) {
        header('Location: ?page=login');
        exit;
    }
}

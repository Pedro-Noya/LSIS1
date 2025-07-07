<?php
require_once __DIR__ . '../BLL/voucher_bll.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create'])) {
    $date = $_POST['date'] ?? null;

    if ($date) {
        createVoucher($date);
    }

    header('Location: voucher.php');
    exit;
}

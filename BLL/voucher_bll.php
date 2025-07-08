<?php
require_once __DIR__ . "/../DAL/voucher_dal.php";

function listAllVouchers(){
    $dal=new DAL_Voucher();
    $vouchers=$dal->getAllVouchers();
    $disponiveis = 0;
    $atribuidos = 0;
    foreach ($vouchers as $voucher) {
        if ($voucher['estado'] == 0) {
            $disponiveis++;
        } else {
            $atribuidos++;
        }
    }
    echo '
    <div class="voucher-summary">
        <div class="summary-box disponiveis">
            Nº de Vouchers Disponíveis: <strong>' . $disponiveis . '</strong>
        </div>
        <div class="summary-box atribuidos">
            Nº de Vouchers Atribuídos: <strong>' . $atribuidos . '</strong>
        </div>
    </div>
    <div style="text-align: center; margin-top: 30px;">
        <h1>Vouchers</h1>
        <button class="add-btn" onclick="openModal()">Add Voucher</button>
    </div>';
    echo '
    <div class="voucher-container">';
        foreach ($vouchers as $voucher){
            $estado = htmlspecialchars($voucher["estado"]);
            $data = htmlspecialchars($voucher["voucherNos"]);
            $idVoucher = htmlspecialchars($voucher["idVoucherNos"]);
            if ($estado == 0) {
                $classBtn = "status-btn status-disponivel";
                $icon = "✅";
                $text = "Disponível";
            } else {
                $classBtn = "status-btn status-atribuido";
                $icon = "❌";
                $text = "Atribuído";
            }
            echo '
            <div class="voucher-card" data-estado="'.$estado.'">
                <p><strong>Date: </strong>' . $data . '</p>
                <button class="' . $classBtn . '" onclick="handleVoucherAction(' . $estado . ', ' . $idVoucher . ')">' . $icon . ' ' . $text . '</button>
            </div>';
        }
        echo '
    </div>';
}

function createVoucher($voucher){
    $dal=new DAL_Voucher();
    $dal->insertVoucher($voucher);
}


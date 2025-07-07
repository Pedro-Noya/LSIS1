<?php
require_once __DIR__ . "/../DAL/voucher_dal.php";

function listAllVouchers(){
    $dal=new DAL_Voucher();
    $vouchers=$dal->getAllVouchers();
    echo '
    <div style="text-align: center; margin-top: 30px;">
        <h1>Vouchers</h1>
        <button class="add-btn" onclick="openModal()">Add Voucher</button>
    </div>';
    echo '
    <div class="voucher-container">';
        foreach ($vouchers as $voucher){
            echo '
            <div class="voucher-card"data-estado="',htmlspecialchars($voucher["estado"]),'">
                <p><strong>Date: </strong>',htmlspecialchars($voucher["voucherNos"],),'</p>
            </div>';
        }
        echo '
    </div>';
}

function createVoucher($voucher){
    $dal=new DAL_Voucher();
    $dal->insertVoucher($voucher);
}


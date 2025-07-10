<?php
require_once "BLL/voucher_bll.php";
require_once __DIR__ . "/verificar_acesso.php";
verificarAcesso([3]);
?>
<!DOCTYPE html>
<html lang="pt">
    <head>
        <meta charset="UTF-8">
        <title>Portal do Colaborador - Dashboard</title>
        <link href="CSS/voucher.css" rel="stylesheet">
        <meta charset="UTF-8" />
        <title>Portal do Colaborador - Vouchers</title>
    </head>
    <body>
      <?php include "cabecalho.php"; ?>
      
      <div class="filter-container">
        <label for="estadoFilter">Filter:</label>
        <select id="estadoFilter" onchange="filterVouchers()">
          <option value="all">Todos</option>
          <option value="0">Disponíveis</option>
          <option value="1">Atribuídos</option>
        </select>
      </div>
      <?php
      listAllVouchers();
      ?>

      <!-- Modal -->
      <div id="voucherModal" class="modal">
        <div class="modal-content">
          <span class="close" onclick="closeModal()">&times;</span>
          <h2>Add Voucher</h2>
          <form method="POST" action="voucherController.php">
            <label>Data de Expiração:</label>
            <input type="date" name="voucherNos">

            <label>Descrição:</label>
            <input type="text" name="descricao" required>

            <label>Empresa:</label>
            <input type="text" name="empresa" required>
            <button type="submit" name="create" class="add-btn">Criar novo voucher NOS</button>
          </form>
        </div>
      </div>

      <script>
        function openModal() {
          document.getElementById("voucherModal").style.display = "flex";
        }

        function closeModal() {
          document.getElementById("voucherModal").style.display = "none";
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
          const modal = document.getElementById("voucherModal");
          if (event.target === modal) {
            closeModal();
          }
        };

        function filterVouchers() {
          const selected = document.getElementById("estadoFilter").value;
          const cards = document.querySelectorAll(".voucher-card");

          cards.forEach(card => {
              const estado = card.getAttribute("data-estado");
              if (selected === "all" || selected === estado) {
                  card.style.display = "block";
              } else {
                  card.style.display = "none";
              }
          });
        }

        function handleVoucherAction(estado, id) {
          if (estado === 0) {
            // Disponível → associar
            window.location.href = "atribuir_voucher.php?id=" + id;
          } else {
            // Atribuído → desassociar
            window.location.href = "remover_voucher.php?id=" + id;
          }
        }
      </script>

</body>
</html>

    </body>
</html>

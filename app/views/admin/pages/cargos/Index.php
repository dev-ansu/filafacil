<?php component("breadcrumb", ['title' => $title ? $title:'Sem título']); ?>

<?php 
component("form_cargos",[
    "idForm" => "form-cargos-store",
    "route" => "admin.cargos.store",
    "formTitle" => "Cadastrar cargo",
    "csrf" => $csrf,
]); 
?>

<div class="mt-4">
    <?php component("simple_table", [
        'headers' => ['#', 'Cargos', 'Salário'],
        'tableId' => 'cargos-table',
        'title' => 'Lista de cargos', 
    ]);
    ?>
</div>

<div class="modal fade" id="editarCargo" tabindex="-1" aria-labelledby="editarCargoLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="editarCargoLabel">Atualizar cargo</h1>
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">X</button>
      </div>
      <div class="modal-body">
        <?php 
        component("form_cargos",[
          "idForm" => "form-cargos-update",
          "route" => "admin.cargos.update",
          "formTitle" => "Atualizar cargo",
          'idCargo' => "<input data-validation='false' type='hidden' name='id' id='idcargo'>",
          'textButton' => "Atualizar",
        ]); ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>

<script type="module" src="<?= asset("js/store.cargos.validation.js") ?>"></script>
<script type="module" src="<?= asset("js/update.cargos.validation.js") ?>"></script>
<?php component("breadcrumb", ['title' => $title ? $title:'Sem título']); ?>
<?php 
    component('form_guiches',[
        'idForm' => "form-guiche-store",
        "route" => route("admin.guiches.store"),
        "formTitle" => "Cadastro de guichês",
        'textButton' => '<i class="fa-solid fa-plus"></i> Adicionar',
        'csrf' => $csrf,
    ])
?>

<div class="mt-4">
    <?php component("simple_table", [
        'headers' => ['#', 'Guichê'],
        'tableId' => 'guiches-table',
        'title' => 'Lista de guichês', 
    ]);
    ?>
</div>

<div class="modal fade" id="editarGuiche" tabindex="-1" aria-labelledby="editarGuiche" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="editarGuiche">Atualizar guichê</h1>
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">X</button>
      </div>
      <div class="modal-body">
        <?php 
        component("form_guiches",[
          "idForm" => "form-guiche-update",
          "route" => "admin.guiches.update",
          "formTitle" => "Atualizar guichê",
          'id' => "<input data-validation='false' type='hidden' name='id' id='id'>",
          'textButton' => "Atualizar",
          'csrf' => $csrf,
        ]); ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>

<script type="module" src="<?= asset("js/store.guiche.validation.js") ?>"></script>
<script type="module" src="<?= asset("js/update.guiche.validation.js") ?>"></script>

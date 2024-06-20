<?php component("breadcrumb", ['title' => $title ? $title:'Sem título']); ?>

<div class="d-flex align-items-start w-100">
  <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
    <button class="nav-link active" id="v-pills-permissoes-tab" data-bs-toggle="pill" data-bs-target="#v-pills-permissoes" type="button" role="tab" aria-controls="v-pills-permissoes" aria-selected="true">Bloqueios por cargo</button>
  </div>
  <div class="tab-content w-100" id="v-pills-tabContent">
    <div class="tab-pane fade show active" id="v-pills-permissoes" role="tabpanel" aria-labelledby="v-pills-permissoes-tab" tabindex="0">
        <div class="d-flex flex-column">
            <span style="color:#999" class="fs-4">Bloqueios</span>
            <span>Atenção: todos cargos possuem todas as funções liberadas, cabe ao administrador ou responsável bloquear.</span>
        </div>
        <form id="form-block-permissions" action="<?= route("admin.configuracoes.blockPermission") ?>" class="d-flex mt-3 flex-column">
            <div class="form-group">
              <label for="idcargo">Cargo:</label>
              <select name="idcargo" id="idcargo" class="form-select">
                <option value="-1">Escolha um cargo</option>
                <?php foreach($cargos as $cargo): ?>
                  <option value="<?= $cargo->id ?>"><?= $cargo->cargo ?></option>
                <?php endforeach; ?>
              </select>                    
            </div>
            <div id="permissions_container_form" class="d-flex mt-2 flex-column gap-2">
              
            </div>
            <button class="btn btn-primary justify-self-start align-self-start mt-2"><i class="bi bi-floppy"></i> Salvar</button>
        </form>
    </div>
  </div>
</div>

<script type="module" src="<?= asset("js/store.blockpermission.validation.js") ?>"></script>
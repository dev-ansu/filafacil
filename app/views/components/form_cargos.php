<form id="<?= $idForm ?>" method="POST" action="<?= route($route) ?>">
    <span style="color:#999" class="fs-4"><?php echo $formTitle ?></span>
        <div class="d-flex w-100 gap-2 align-items-center">
            <div class="form-group w-100">
                <label for="cargo">Nome do cargo:</label>
                <input autofocus value="<?= isset($cargo) ? $cargo:getOld('cargo') ?>" data-validation="true" id="cargo" type="text" placeholder="Digite o nome do cargo" class="form-control w-100" name="cargo">
                <?php 
                    component("miniAlert", ['message' => getFlashText("cargo.required")]); 
                    component("miniAlert", ['message' => getFlashText("cargo.numberInt")]); 
                    component("miniAlert", ['message' => getFlashText("cargo.unique")]); 
                ?>
            </div>
            <div class="form-group w-100">
                <label for="salario">Salário:</label>
                <input value="<?= isset($salario) ? $salario:getOld('salario') ?>" data-validation="true" id="salario" type="text" placeholder="Digite o salário do cargo" class="form-control w-100" name="salario">
                <?php 
                    component("miniAlert", ['message' => getFlashText("salario.required")]); 
                    component("miniAlert", ['message' => getFlashText("salario.numeric")]); 
                ?>
            </div>
        </div>
        <?php echo isset($idCargo) ? $idCargo:'' ?>
        
        <?php echo isset($csrf) ? $csrf->Csrf()->render():'' ; ?>
    <button class="btn btn-success mt-2"><?php echo isset($textButton) ? $textButton:"<i class='fa-solid fa-plus'></i> Adicionar" ?> </button>
</form>

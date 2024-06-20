<form id="<?= $idForm ?>" method="POST" action="<?= $route ?>">
    <span style="color:#999" class="fs-4"><?= $formTitle ?></span>
    <div class="form-group ">
        <label for="guiche">Número do guichê</label>
        <input autofocus value="<?= getOld('guiche') ?>" data-validation="true" id="guiche" type="text" placeholder="Digite o número do guichê" class="form-control" name="guiche">
        <?php 
            component("miniAlert", ['message' => getFlashText("guiche.required")]); 
            component("miniAlert", ['message' => getFlashText("guiche.numberInt")]); 
            component("miniAlert", ['message' => getFlashText("guiche.unique")]); 
        ?>
    </div>
    <?php if(isset($id)): ?>
        <?php echo $id ?>
    <?php endif; ?>
    <?= $csrf->Csrf()->render() ; ?>
    <button class="btn btn-success mt-2"><?= $textButton ?></button>
</form>
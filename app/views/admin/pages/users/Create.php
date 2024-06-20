<?php component("breadcrumb", ['title' => $title ? $title:'Sem título']);  ?>


<div class="card shadow border d-flex p-4">
    <span>Os campos com asterisco(*) são obrigatórios.</span>
    <form id="form-store-user" action="<?= route("admin.users.store") ?>" class="d-flex gap-4 flex-column mt-4" method="POST">
        <div class="form-group d-flex flex-column gap-2 justify-content-start align-items-start">
            <span style="color:#999" class="fs-4">Informações pessoais</span>
            <div class="form-group d-flex gap-2 justify-content-between align-items-center w-100">
                <div class="form-group w-100">
                    <label for="firstname">Nome:*</label>
                    <input autofocus value="<?= getOld('firstname') ?>" data-validation="true" type="text" name="firstname"  class="form-control w-100" placeholder="Digite seu primeiro nome">
                    <?php echo getFlashText('firstname.required') ?>
                </div>
                <div class="form-group w-100">
                    <label for="lastname">Sobrenome:*</label>
                    <input value="<?= getOld('lastname') ?>" data-validation="true" type="text" name="lastname" class="form-control w-100" placeholder="Digite seu sobrenome nome">
                    <?php echo getFlashText('lastname.required') ?>
                </div>
            </div>
        </div>

        <div class="form-group d-flex flex-column gap-2 justify-content-start align-items-start">
            <span style="color:#999" class="fs-4">Acesso ao sistema</span>
            <div class="form-group d-flex gap-2 justify-content-between align-items-center w-100">
                <div class="form-group w-100">
                    <label for="user">Usuário:*</label>
                    <input id="user" value="<?= getOld('user') ?>" data-validation="true" type="text" name="user" class="form-control w-100" placeholder="Digite seu usuário">
                    <?php echo getFlashText('user.required') ?>
                    <?php echo getFlashText('user.unique') ?>

                </div>
                <div class="form-group w-100">
                    <label for="password">Senha:*</label>
                    <input value="<?= getOld('password') ?>" data-validation="true" type="password" name="password" class="form-control w-100" placeholder="Digite sua senha com no mínimo 6 caracteres">
                    <?php echo getFlashText('password.required') ?>
                    <?php echo getFlashText('password.minlen') ?>
                </div>
            </div>
        </div>

        <div class="form-group d-flex flex-column gap-2 justify-content-start align-items-start">
            <span style="color:#999" class="fs-4">Informações profissionais</span>
            <div class="form-group d-flex gap-2 justify-content-between align-items-center w-100">
                <div class="form-group w-100">
                    <label for="cargo">Cargo:*</label>
                    <select name="cargo" id="cargo" class="form-select">
                        <option value="-1">Qual é o cargo do usuário?</option>
                        <?php foreach($cargos as $cargo): ?>
                            <option value="<?php echo $cargo->id ?>"><?php echo $cargo->cargo ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?php echo getFlashText('cargo.required') ?>
                    <?php echo getFlashText('cargo.existe') ?>
                </div>
            </div>
        </div>
        <?= $csrf->Csrf()->render() ?>
        <button id="btn-create-user" class="btn btn-primary justify-self-start align-self-end" type="submit">Cadastrar</button>
    </form>
</div>

<script type="module" src="<?= asset("js/store.user.validation.js") ?>"></script>
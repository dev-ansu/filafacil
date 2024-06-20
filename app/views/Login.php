
<form id="form-login" method="POST" action="<?= route('login.auth') ?>" class="text-white h-100 bg-dark justify-content-between align-items-center p-5 d-flex gap-2">
    <div class="form_left_side">
        <i class="fa-solid fa-angles-right"></i>
        <h1 class="title_login">Seja bem-vindo</h1>
    </div>
    <div class="login_form_groups d-flex flex-column gap-4">
        <?php component('logo'); ?>
        <div class="form-group">
            <label for="user" class="fw-bold fs-4">Usuário:</label>
            <input id="user" autofocus data-validation="true" type="text" class="form-control" name="user" placeholder="Digite seu usuário">
            <?php echo component('miniAlert', ['message' => getFlashText('user.required')]) ?>
            <?php echo component('miniAlert', ['message' => getFlashText('user.existe')]) ?>
        </div>
        <div class="form-group">
            <label for="password" class="fw-bold fs-4">Senha:</label>
            <input data-validation="true" type="password" class="form-control" name="password" placeholder="Digite sua senha">
            <?php echo component('miniAlert', ['message' => getFlashText('password.required')]) ?>
            <?php echo component('miniAlert', ['message' => getFlashText('password.existe')]) ?>
        </div>
        <?= $csrf->Csrf()->render() ?>
        <button id="btn-login" class="btn btn-primary">LOGAR</button>
    </div>
</form>



<script type="module" src="<?= asset("js/login.validation.js") ?>"></script>
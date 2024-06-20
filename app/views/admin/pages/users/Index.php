<?php component("breadcrumb", ['title' => $title ? $title:'Sem título']); ?>

<?php component("simple_table", [
    'headers' => ['#', 'Nome', 'Sobrenome', 'Usuário','Cargo','Salário'],
    'tableId' => 'users-table',
    'title' => $title, 
    '_csrf' => $csrf->getCSRF(),
]);

?>

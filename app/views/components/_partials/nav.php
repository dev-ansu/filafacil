<?php

    if(isPermissionBlocked("admin/home/getNewPass", $session->idcargo)){
        component("modalGerarSenha");
    }
    if(isPermissionBlocked("admin/home/callNewPass", $session->idcargo)){
        component("modalChamarSenha");
    }
?>
<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
<!-- Navbar Brand-->
<a class="navbar-brand ps-3" href="<?= route('admin') ?>">
    <?php component('logo', ['fs' => 'fs-4']) ?>
</a>
<!-- Sidebar Toggle-->
<button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
<!-- Navbar Search-->
<div class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">

</div>
<!-- Navbar-->
<ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
            <?php 
                $route = route("admin.configuracoes");
                isPermissionBlocked("admin/configuracoes/index", $session->idcargo, 
                "
                <li>
                <a class='dropdown-item' href='$route'>
                <i class='fa-solid fa-gear'>
                </i> Configurações
                </a>
                </li>
                <li><hr class='dropdown-divider' /></li>

                "
                );            
            ?>
            <!-- <li><a class="dropdown-item" href="#!"><i class="fa-solid fa-circle-info"></i> Logs</a></li> -->
            <li><a class="dropdown-item" href="<?= route('login.logout') ?>"><i class="fa-solid fa-right-from-bracket"></i> Sair</a></li>
        </ul>
    </li>
</ul>
</nav>
<div id="layoutSidenav">
<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Core</div>
                <a class="nav-link" href="<?= route('admin') ?>">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>
                <div class="sb-sidenav-menu-heading">Páginas</div>
                <?php if(isPermissionBlocked('admin/users/index', $session->idcargo) || isPermissionBlocked('admin/users/create', $session->idcargo)):?>                
                <a class="nav-link collapsed cursor-pointer" href="#!" data-bs-toggle="collapse" data-bs-target="#collapseUsers" aria-expanded="false" aria-controls="collapseUsers">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    Usuários
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <?php endif; ?>
                <div class="collapse" id="collapseUsers" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <?php 
                        $route = route("admin.users");
                        isPermissionBlocked('admin/users/index', $session->idcargo, 
                        "<a class='nav-link d-flex align-items-center gap-2' href='$route'><i class='fa-solid fa-list'></i> Lista</a>");

                        $route = route("admin/users/create");
                        isPermissionBlocked("admin/users/create", $session->idcargo, 
                        "<a class='nav-link d-flex align-items-center gap-2' href='$route'><i class='fa-solid fa-list'></i> Novo</a>");
                        ?>
                    </nav>
                </div>

                <?php 
                    $route = route("admin.guiches");
                    isPermissionBlocked("admin/guiches/index", $session->idcargo, 
                    "
                    <a class='nav-link' href='$route'>
                        <div class='sb-nav-link-icon'><i class='fas fa-chart-area'></i></div>
                        Guichês
                    </a>
                    "
                    );
                    $route = route("admin.cargos");
                    isPermissionBlocked("admin/cargos/index", $session->idcargo, 
                    "
                        <a class='nav-link' href='$route'>
                        <div class='sb-nav-link-icon'><i class='fa-solid fa-briefcase'></i></div>
                            Cargos
                        </a>
                    "
                    );
                ?>                    
                 
                <?php
        
                isPermissionBlocked("admin/home/getNewPass", $session->idcargo, 
                '<button id="btnGerarNovaSenha" class="nav-link" data-bs-toggle="modal" data-bs-target="#gerarNovaSenha">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-ticket"></i></div>
                    Gerar nova senha
                </button>');

                isPermissionBlocked("admin/home/callNewPass", $session->idcargo, 
                '<button id="btnChamarSenha" class="nav-link" data-bs-toggle="modal" data-bs-target="#chamarSenha">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-ticket"></i></div>
                    Chamar senha
                </button>');
                ?>
          
           
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logado como:</div>
            <?php echo $session->firstname ?>
        </div>
    </nav>
</div>
<div id="layoutSidenav_content">



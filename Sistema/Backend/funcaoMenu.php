<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

function montaMenu($n1,$n2){
    
    $menuAdmin = '';
    $acaoAdmin = '';
    $menuForms = '';
    $acaoForms = '';

    $opcPainel        = '';
    $opcPainelSimples = '';
    $opcPainelFiltro  = '';
    $opcUsuarios      = '';
    $opcFornecedores  = '';
    $opcProdutos      = '';
    $opcPerfil        = '';
    
    //Primeiro nível do menu
    switch ($n1) {
        case 'administrador':
            $menuAdmin = 'menu-open';
            $acaoAdmin = 'active';
            break;        
            
        case 'forms':
            $menuForms = 'menu-open';
            $acaoForms = 'active';
            break;
        
        default:
            # code...
            break;
    }

    //Segundo nível do menu
    switch ($n2) {
        case 'painel':
            $opcPainel = 'active';
            break;
            
        case 'painel-simples':
            $opcPainelSimples = 'active';
            break;
            
        case 'painel-filtro':
            $opcPainelFiltro = 'active';
            break;

        case 'usuarios':
            $opcUsuarios = 'active';
            break;       
            
        case 'fornecedores':
            $opcFornecedores = 'active';
            break;  
        
        case 'produtos':
            $opcProdutos = 'active';
            break;  
        
        case 'perfil':
            $opcPerfil = 'active';
            break;
        
        default:
            # code...
            break;
    }
    
    $html = 
    '<nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
                with font-awesome or any other icon font library -->
            <li class="nav-item '.$menuAdmin.'">
                <a href="#" class="nav-link '.$acaoAdmin.'">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>
                        Administrador
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>

                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="./painel.php" class="nav-link '.$opcPainel.'">
                        <i class="ion ion-pie-graph nav-icon"></i>
                        <p>Dashboard</p>
                        </a>
                    </li>              
                </ul>

                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="./painel-simples.php" class="nav-link '.$opcPainelSimples.'">
                        <i class="ion ion-pie-graph nav-icon"></i>
                        <p>Dashboard Simples</p>
                        </a>
                    </li>              
                </ul>

                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="./painel-filtro.php" class="nav-link '.$opcPainelFiltro.'">
                        <i class="ion ion-pie-graph nav-icon"></i>
                        <p>Dashboard Filtro</p>
                        </a>
                    </li>              
                </ul>

                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="./usuarios.php" class="nav-link '.$opcUsuarios.'">
                        <i class="far fa-user nav-icon"></i>
                        <p>Usuários</p>
                        </a>
                    </li>              
                </ul>

                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="./fornecedores.php" class="nav-link '.$opcFornecedores.'">
                        <i class="fab fa-houzz nav-icon"></i>
                        <p>Fornecedores</p>
                        </a>
                    </li>              
                </ul>

                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="./produtos.php" class="nav-link '.$opcProdutos.'">
                        <i class="ion ion-bag nav-icon"></i>
                        <p>Produtos</p>
                        </a>
                    </li>              
                </ul>

            </li>
            
            <li class="nav-item '.$menuForms.'">
                <a href="#" class="nav-link '.$acaoForms.'">
                <i class="nav-icon fas fa-edit"></i>
                <p>
                    Forms
                    <i class="fas fa-angle-left right"></i>
                </p>
                </a>
                <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="#" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>General Elements</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Advanced Elements</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Editors</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Validation</p>
                    </a>
                </li>
                </ul>
            </li>

            <li class="nav-item">
                <a href="./perfil.php" class="nav-link '.$opcPerfil.'">
                <i class="nav-icon fas fa-user"></i>
                <p>Meu Perfil</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="php/validaLogoff.php" class="nav-link text-danger">
                <i class="nav-icon fas fa-power-off"></i>
                <p>Sair</p>
                </a>
            </li>
        
        </ul>
    </nav>';

    return $html;
}

?>
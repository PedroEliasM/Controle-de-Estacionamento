<!DOCTYPE html>
<html>
    <head lang="pt-br">

        <meta charset="UTF-8">
        <title>Admin</title>

        <!-- INÍCIO CSS -->
        <!-- INÍCIO Sidebar CSS -->
        <!-- Fonte do texto -->
        <link href="/Estacionamento/Sistema/Frontend/sidebar/fonts/font.css" rel="stylesheet">
        <!-- Icones dos campos da sidebar -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

		<link rel="stylesheet" href="/Estacionamento/Sistema/Frontend/sidebar/css/style.css">
        <!-- FIM Sidebar CSS -->
        <link rel="stylesheet" href="/Estacionamento/Sistema/Frontend/css/style-adm.css">
        <?php include("imports/css.php"); ?>
        <!-- FIM CSS -->

    </head>

    <body class="hold-transition sidebar-mini layout-fixed">
        <div class="wrapper d-flex align-items-stretch">
            <!-- Sidebar -->
            <?php 
                //$_SESSION['menu-n1'] = 'administrador';
                //$_SESSION['menu-n2'] = 'painel';
                include('sidebar/sidebar.php'); 
            ?>
            <!-- Fim Sidebar -->

            <!-- Navbar -->
            <?php 
                include('navbar.php'); 
            ?>
            <!-- Fim Navbar -->
            
            <!-- Navbar -->
            <?php 
                include('vagas.php'); 
            ?>
            <!-- Fim Navbar -->
            <!-- Conteúdo principal -->
            <div id="content" class="p-4 p-md-5 pt-5">
                <h1 class="mb-4 content">Vagas</h1>
            </div>

        </div>

        <!-- INÍCIO Sidebar JavaScript -->
        <script src="/Estacionamento/Sistema/Frontend/sidebar/js/jquery.min.js"></script>
        <script src="/Estacionamento/Sistema/Frontend/sidebar/js/popper.js"></script>
        <script src="/Estacionamento/Sistema/Frontend/sidebar/js/bootstrap.min.js"></script>
        <script src="/Estacionamento/Sistema/Frontend/sidebar/js/main.js"></script>
        <!-- FIM Sidebar JavaScript -->
    </body>
</html
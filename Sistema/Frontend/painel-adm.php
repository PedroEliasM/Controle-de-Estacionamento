<!DOCTYPE html>
<html>
    <head lang="pt-br">

        <meta charset="UTF-8">
        <title>PHP</title>

        <!-- Fonte do texto -->
        <link href="/Estacionamento/Sistema/Frontend/sidebar/fonts/font.css" rel="stylesheet">
        <!-- Icones dos campos da sidebar -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

		<link rel="stylesheet" href="/Estacionamento/Sistema/Frontend/sidebar/css/style.css">

    </head>

    <body>





        <!-- Sidebar -->
        <div class="wrapper d-flex align-items-stretch">
            <?php 
                //$_SESSION['menu-n1'] = 'administrador';
                //$_SESSION['menu-n2'] = 'painel';
                include('sidebar/sidebar.php'); 
            ?>
            <div id="content" class="p-4 p-md-5 pt-5">
                <h1 class="mb-4">Conteúdo da Página Principal</h1>
            </div>
        </div>
        <!-- Fim Sidebar -->

        <script src="/Estacionamento/Sistema/Frontend/sidebar/js/jquery.min.js"></script>
        <script src="/Estacionamento/Sistema/Frontend/sidebar/js/popper.js"></script>
        <script src="/Estacionamento/Sistema/Frontend/sidebar/js/bootstrap.min.js"></script>
        <script src="/Estacionamento/Sistema/Frontend/sidebar/js/main.js"></script>
    </body>
</html
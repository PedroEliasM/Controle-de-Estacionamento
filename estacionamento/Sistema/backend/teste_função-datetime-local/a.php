<?php
date_default_timezone_set('America/Sao_Paulo'); // Define o fuso horário para Brasília (ou outro fuso horário desejado)

$data_hora_local = date('Y-m-d H:i:s'); // Obtém a data e hora no formato desejado
var_dump ("Data e hora local: " . $data_hora_local);
die();
?>
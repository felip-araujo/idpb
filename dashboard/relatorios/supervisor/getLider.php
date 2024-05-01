<?php
require '/opt/bitnami/apache/htdocs/idpb/dashboard/relatorios/conexao.php';

if(isset($_POST['numero_celula'])) {
    $numeroCelula = $_POST['numero_celula'];
    $query = "SELECT Nome_Lider FROM Celulas_X WHERE Numero_Celula = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$numeroCelula]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo $result['Nome_Lider'] ?? ''; // Retorna o nome do líder ou vazio se não encontrado
}

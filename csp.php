<?php
    require_once "connection.php";
    $stmt = $conn->prepare('SELECT comp_csp FROM company ORDER BY comp_name');
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_NUM);
    echo json_encode($result);
?>
<?php
    session_start();
    require_once "connection.php";
    $stmt = $conn->prepare('SELECT company.comp_name,shares.no_stocks,company.comp_csp,shares.buy_price FROM shares INNER JOIN company ON shares.comp_id = company.comp_id WHERE shares.user_id=:userid and shares.no_stocks>0 ORDER BY comp_name');
    $stmt->bindParam(':userid', $_SESSION['login_id']);
    $stmt->execute();

    $i=1;
    foreach ($stmt as $row) {
        $dif=$row[2]-$row[3];
        $dif=intval($dif);
        if($dif>=0)
        {
            echo "<tr><th scope='row'> $i </th><td>".$row[0]."</td><td>".$row[1]."</td><td style='color:green !important;'>+".$dif."</td><td>".$row[3]."</td><td>".$row[2]."</td></tr>";
        }
        else{
            echo "<tr><th scope='row'> $i </th><td>".$row[0]."</td><td>".$row[1]."</td><td style='color:red !important;'>".$dif."</td><td>".$row[3]."</td><td>".$row[2]."</td></tr>";
        }
    $i++;
    }
?>
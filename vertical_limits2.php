<?php
    include_once ("connection.php");
    try
    {
        $stmt = $conn->prepare("SELECT user_name FROM user WHERE user_id!=9999 ORDER BY total_assets desc LIMIT 10");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_NUM);
        if($stmt->rowCount() > 0)
        {
            echo "<ol>";
            foreach ($stmt as $row)
            {
                echo "<li><span>".$row[0]."</span></li>";
            }
            echo "</ol>";
        }
    }
    catch (PDOException $exception)
    {
        echo $exception->getMessage();
    }
?>
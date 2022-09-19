<?php
    include_once ("connection.php");
    try
    {
        $stmt = $conn->prepare("SELECT user_name FROM user WHERE user_id!=1 ORDER BY total_assets desc LIMIT 10");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_NUM);
        if($stmt->rowCount() > 0)
        {   echo "<table><tr><th>LEADERBOARD</th></tr>";
            foreach ($stmt as $row)
            {
                echo "<tr><td>".$row[0]."</td></tr>";
            }
            echo "</table>";
        }
    }
    catch (PDOException $exception)
    {
        echo $exception->getMessage();
    }
?>
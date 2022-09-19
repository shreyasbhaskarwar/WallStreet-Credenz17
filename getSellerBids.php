<?php 
session_start();
	require_once("connection.php");
	try{
		$id=$_SESSION["login_id"];
		
		$stmt=$conn->query("select sell_id,seller_id,c.comp_name,sell_stocks,min_sellp from seller_bids s,company c where s.comp_id=c.comp_id and seller_id=$id order by sell_id desc;");
		$stmt->execute();
		foreach($stmt as $row){
		    ?>
						<tr><th> <input type='button' class="bbidbtn" value='Cancel' id='<?php echo $row[0]; ?>' onclick="delSellBid(this.id);"> </th><td><?php echo $row[2]; ?></td><td><?php echo $row[3]; ?></td><td><?php echo $row[4]; ?></td> </tr>
            <?php
            }
	}catch(Exception $e){
		echo "Error buyers bid: " + $e->getMessage();	
	}
?>
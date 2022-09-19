<?php
	require_once("connection.php");
	
	$news = $conn->prepare("SELECT news_title FROM news WHERE news_status='1' order by news_time desc limit 5");
	$news->execute();
	if($news)
	{	
	$i=1;
		foreach($news as $tmp_news){
			echo '<tr>
			<th scope="row">'.$i.'</th>
			<td>'.$tmp_news['news_title'].'</td>
			</tr>';
			$i++;
		}
	}
?>

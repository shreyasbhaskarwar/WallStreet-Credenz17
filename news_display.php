<?php
	require_once("connection.php");
	$news = $conn->prepare("SELECT news_title,news_description FROM news WHERE news_status='1' order by news_time desc");
	$news->execute();
	if($news)
	{	$i=1;
		foreach($news as $tmp_news)
		{		
		if($i==1) {
			echo '<div class="panel">
                                            <div class="panel-heading" role="tab" id="headingOne_1" style="background-color: #f44336; color: white;">
                                                <h4 class="panel-title">
                                                    <a role="button" data-toggle="collapse" data-parent="#accordion_1" href="#collapseOne_1" aria-expanded="true" aria-controls="collapseOne_1">
                                                          #1 '.$tmp_news['news_title'].'
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseOne_1" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne_1">
                                                <div class="panel-body">
                                                    '.$tmp_news['news_description'].'
                                                </div>
                                            </div>
                                        </div>';	
                                        $i++;
                                        continue;
		}
											echo ' <div class="panel">
                                            <div class="panel-heading" role="tab" id="headingTwo_'.$i.'"style="background-color: #f44336; color: white;">
                                                <h4 class="panel-title">
                                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion_'.$i.'" href="#collapseTwo_'.$i.'" aria-expanded="false"
                                                       aria-controls="collapseTwo_'.$i.'">
                                                         #'.$i.' '.$tmp_news['news_title'].'
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseTwo_'.$i.'" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo_'.$i.'">
                                                <div class="panel-body">
                                                    '.$tmp_news['news_description'].'
                                                </div>
                                            </div>
                                        </div>';
                                        $i++;
		}
		
	}
?>

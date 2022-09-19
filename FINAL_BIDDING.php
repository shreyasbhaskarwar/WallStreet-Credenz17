<?php
/**
 * Created by PhpStorm.
 * User: Rama
 * Date: 9/6/2017
 * Time: 6:12 AM
 */

//include_once("connection.php");

class bid{

    public $buy_id=null;
    public $buyer_id=null;
    public $comp_idb=null;
    public $buy_stocks=null;
    public $max_buyp=null;

    public $sell_id=null;
    public $seller_id=null;
    public $comp_ids=null;
    public $sell_stocks=null;
    public $min_sellp=null;


    public function buyfn()
    {

        try {

            $conn = new PDO("mysql:host=localhost;dbname=wallstreet_credenz17", "admin_wallstreet", "admin@wallstreet17");


            $sql1 = "SELECT * FROM buyer_bids ORDER BY buy_time DESC";

            $stmt1 = $conn->prepare($sql1);

            $stmt1->execute();

            if ($stmt1->rowCount()>0) {
                $i=$stmt1->rowCount();
                while ($i>0)
                {

                    $sql1 = "SELECT * FROM buyer_bids ORDER BY buy_time DESC";
                    $stmt1 = $conn->prepare($sql1);
                    $stmt1->execute();

                    $row=$stmt1->fetch(PDO::FETCH_ASSOC);
                    $buy_id=$row["buy_id"];
                    $buyer_id=$row["buyer_id"];
                    $comp_idb=$row["comp_id"];
                    $buy_stocks=$row["buy_stocks"];
                    $max_buyp=$row["max_buyp"];


                    $sql19="SELECT total_cash from user where user_id=$buyer_id";           //imp
                    $sql20="SELECT comp_csp from company where comp_id=$comp_idb";
                    $smt16=$conn->prepare($sql20);
                    $rowcsp=$smt16->fetch(PDO::FETCH_ASSOC);
                    $csp=$rowcsp["comp_csp"];
                    $smt15=$conn->prepare($sql19);
                    

                        $sql2 = "SELECT * FROM seller_bids WHERE comp_id=? ORDER BY min_sellp, sell_time DESC";
                        $stmt2 = $conn->prepare($sql2);
                        $stmt2->bindParam(1,$comp_idb);
                        $stmt2->execute();

                        $j=$stmt2->rowCount();


                        if($stmt2->rowCount()>0)
                        {
                            $j=0;
                            $j=$stmt2->rowCount();
                            while($j>0)
                            {
                                $row1=null;
                                $stmt2=null;
                                $sql2 = "SELECT * FROM seller_bids WHERE comp_id=? ORDER BY min_sellp, sell_time DESC";
                                $stmt2 = $conn->prepare($sql2);
                                $stmt2->bindParam(1,$comp_idb);
                                $stmt2->execute();


                                $row1=$stmt2->fetch(PDO::FETCH_ASSOC);



                                $sell_id=$row1["sell_id"];
                                $seller_id=$row1["seller_id"];
                                $comp_ids=$row1["comp_id"];
                                $sell_stocks=$row1["sell_stocks"];
                                $min_sellp=$row1["min_sellp"];





                                $sql22 = "SELECT * FROM seller_bids WHERE comp_id=? and seller_id=1";
                                $stmt22 = $conn->prepare($sql22);
                                $stmt22->bindParam(1,$comp_idb);
                                $stmt22->execute();
                                  //$row42=$stmt22->fetch(PDO::FETCH_ASSOC);

                                if($stmt22->rowCount()>0 )

                             
                                {$row22=$stmt22->fetch(PDO::FETCH_ASSOC);

                                    $sell_id=$row22["sell_id"];
                                    $seller_id=$row22["seller_id"];
                                    $comp_ids=$row22["comp_id"];
                                    $sell_stocks=$row22["sell_stocks"];
                                    $min_sellp=$row22["min_sellp"];

                                }

                                try{
//                                   $conn->beginTransaction();
                                    if($seller_id==1) {

                                        //complete transaction for superuser

                                        if($max_buyp>=$min_sellp)
                                        {

                                            if($sell_stocks==$buy_stocks)
                                            {

                                                $sql3=" DELETE FROM seller_bids WHERE sell_id=$sell_id";
                                                $sql4=" DELETE FROM buyer_bids WHERE buy_id=$buy_id";
                                                $sql5= "UPDATE shares SET no_stocks=? WHERE user_id=$seller_id AND comp_id=$comp_ids";
                                                $sql6= "UPDATE shares SET no_stocks=? WHERE user_id=$buyer_id AND comp_id=$comp_idb";
                                                $sql7= "INSERT INTO all_transactions(buyer_id,seller_id,comp_id,no_stocks,stock_price) VALUES(:buyer_id,:seller_id,:comp_id,:no_stocks,:stock_price) ";

                                                $stmt3=$conn->prepare($sql3);
                                                if($stmt3->execute())
                                                {
                                                    $stmt4=$conn->prepare($sql4);
                                                    if($stmt4->execute())
                                                    {




                                                        $st=$conn->prepare("SELECT no_stocks FROM shares WHERE user_id=$seller_id AND comp_id=$buyer_id");
                                                        $st->execute();
                                                        $r= $st->fetch(PDO::FETCH_ASSOC);
                                                        $count1=$r["no_stocks"];
                                                        $count1=$count1-$sell_stocks;
                                                        $stmt5=$conn->prepare($sql5);
                                                        $stmt5->bindParam(1,$count1);
                                                        if($stmt5->execute()) {


                                                            $sql8 = "SELECT * FROM shares WHERE user_id=$buyer_id AND comp_id=$comp_idb";   //seller
                                                            $sm = $conn->prepare($sql8);
                                                            $sm->execute();
                                                            echo $count = $sm->rowCount();

                                                            if ($count == 0) {
                                                                echo "fk";
                                                                $stmt6 = $conn->prepare("INSERT INTO shares (user_id,comp_id,no_stocks) VALUES(:user_id,:comp_id,:no_stocks)");
                                                                $stmt6->bindParam(':user_id', $buyer_id);
                                                                $stmt6->bindParam(':comp_id', $comp_idb);         //buyer user
                                                                $stmt6->bindParam(':no_stocks', $buy_stocks);
                                                            } else {

                                                                echo "fkR";

                                                                $stmt6 = $conn->prepare("UPDATE shares SET no_stocks=no_stocks+$buy_stocks WHERE user_id=$buyer_id AND comp_id=$comp_idb");


                                                            }
                                                            if ($stmt6->execute()) {

                                                                $stmt7 = $conn->prepare($sql7);
                                                                $stmt7->bindParam(':buyer_id', $buyer_id);
                                                                $stmt7->bindParam(':seller_id', $seller_id);
                                                                $stmt7->bindParam(':comp_id', $comp_ids);    // Transaction
                                                                $stmt7->bindParam(':no_stocks', $sell_stocks);
                                                                $stmt7->bindParam(':stock_price', $min_sellp);
                                                                if ($stmt7->execute()) {

                                                $smt12=$conn->prepare("UPDATE shares SET buy_price=$min_sellp where user_id=$buyer_id and comp_id=$comp_idb");
                                                                        $smt12->execute();
                                                                        

                                                                    //$trans_cash=(($min_sellp*$buy_stocks)-($min_sellp*$buy_stocks*0.02));
                                                                     $trans_fee=($min_sellp*$buy_stocks*0.02);
                                                                      $trans=($min_sellp*$buy_stocks);
                                                                      $trans_refund=(($max_buyp - $min_sellp)* $buy_stocks);

                                                                    $sql21="UPDATE user SET total_cash = total_cash+ $trans- $trans_fee WHERE  user_id= $seller_id";   //seller
                                                                    $smt17=$conn->prepare($sql21);
                                                                    if($smt17->execute())
                                                                    {
                                                                        echo "yoo";

                                                                    }

                                                                    //buyer
                                                                    $sql21="UPDATE user SET total_cash = total_cash+ $max_buyp * $buy_stocks*0.02- $trans_fee + $trans_refund  WHERE  user_id= $buyer_id ";
                                                                    $smt17=$conn->prepare($sql21);
                                                                    if($smt17->execute())
                                                                    {
                                                                        echo "yoo";
//                                                                        $conn->commit();
                                                                        break;
                                                                    }

//                                                                    $stmt2=null;
//                                                                    $sql2 = "SELECT * FROM seller_bids WHERE comp_id=? ORDER BY min_sellp, sell_time DESC";
//                                                                    $stmt2 = $conn->prepare($sql2);
//                                                                    $stmt2->bindParam(1,$comp_idb);
//                                                                    $stmt2->execute();



                                                                }
                                                            }

                                                        }
                                                    }
                                                }
                                            }
                                            else if($sell_stocks>$buy_stocks)
                                            {

                                                $stock1=$sell_stocks-$buy_stocks;
                                                $sql3="UPDATE seller_bids SET sell_stocks=sell_stocks-$buy_stocks where sell_id=$sell_id";
                                                
                                                $sql4="DELETE FROM buyer_bids WHERE buy_id=$buy_id";

                                                $sql5= "UPDATE shares SET no_stocks=? WHERE user_id=$seller_id AND comp_id=$comp_ids";
                                                $sql6= "UPDATE shares SET no_stocks=? WHERE user_id=$buyer_id AND comp_id=$comp_idb";
                                                $sql7= "INSERT INTO all_transactions(buyer_id,seller_id,comp_id,no_stocks,stock_price) VALUES(:buyer_id,:seller_id,:comp_id,:no_stocks,:stock_price) ";

                                                $stmt3=$conn->prepare($sql3);
                                                if($stmt3->execute())
                                                {
                                                    $stmt4=$conn->prepare($sql4);
                                                    if($stmt4->execute())
                                                    {

                                                        echo "deleted";




                                                        $st=$conn->prepare("SELECT no_stocks FROM shares WHERE user_id=$seller_id AND comp_id=$comp_ids");
                                                        $st->execute();
                                                        $r= $st->fetch(PDO::FETCH_ASSOC);
                                                        $count1=$r["no_stocks"];
                                                        $count1=$count1-$buy_stocks;
                                                        $stmt5=$conn->prepare($sql5);
                                                        $stmt5->bindParam(1,$count1);
                                                        if($stmt5->execute()) {

                                                            $sql8 = "SELECT * FROM shares WHERE user_id=$buyer_id AND comp_id=$comp_idb";
                                                            $sm = $conn->prepare($sql8);
                                                            $sm->execute();
                                                            echo $count = $sm->rowCount();

                                                            if ($count == 0) {
                                                                echo "fk";
                                                                $stmt6 = $conn->prepare("INSERT INTO shares (user_id,comp_id,no_stocks) VALUES(:user_id,:comp_id,:no_stocks)");
                                                                $stmt6->bindParam(':user_id', $buyer_id);
                                                                $stmt6->bindParam(':comp_id', $comp_idb);         //buyer user
                                                                $stmt6->bindParam(':no_stocks', $buy_stocks);
                                                            } else {

                                                                echo "fkR";
                                                                $stmt6 = $conn->prepare("UPDATE shares SET no_stocks=no_stocks+$buy_stocks WHERE user_id=$buyer_id AND comp_id=$comp_idb");

                                                            }
                                                            if ($stmt6->execute()) {

                                                                $stmt7 = $conn->prepare($sql7);
                                                                $stmt7->bindParam(':buyer_id', $buyer_id);
                                                                $stmt7->bindParam(':seller_id', $seller_id);
                                                                $stmt7->bindParam(':comp_id', $comp_ids);    // Transaction
                                                                $stmt7->bindParam(':no_stocks', $buy_stocks);
                                                                $stmt7->bindParam(':stock_price', $min_sellp);
                                                                if ($stmt7->execute()) {
                                                                
                                                                
                                                                                                                $smt12=$conn->prepare("UPDATE shares SET buy_price=$min_sellp where user_id=$buyer_id and comp_id=$comp_idb");
                                                                        $smt12->execute();
                                                                        
                                                                
                                                                
                                                                
                                                                    //$trans_cash=(($min_sellp*$buy_stocks)-($min_sellp*$buy_stocks*0.02));
                                                                    $trans_cash=(($min_sellp*$buy_stocks)-($min_sellp*$buy_stocks*0.02));
                                                                      $trans_fee=($min_sellp*$buy_stocks*0.02);
                                                                      $trans=($min_sellp*$buy_stocks);
                                                                      $trans_refund=(($max_buyp - $min_sellp)* $buy_stocks);

                                                                    $sql21="UPDATE user SET total_cash = total_cash-$trans_fee+$trans WHERE  user_id=$seller_id";   //seller
                                                                    $smt17=$conn->prepare($sql21);
                                                                    if($smt17->execute())
                                                                    {
                                                                        echo "yoo";

                                                                    }

                                                                    //buyer
                                                                    $sql21="UPDATE user SET total_cash = total_cash+$trans_refund+(($max_buyp*$buy_stocks*0.02)-$trans_fee) WHERE  user_id=$buyer_id";
                                                                    $smt17=$conn->prepare($sql21);
                                                                    if($smt17->execute())
                                                                    {
                                                                        echo "yoo";
//                                                                        $conn->commit();
                                                                        break;
                                                                    }


//                                                                    $stmt2=null;
//                                                                    $sql2 = "SELECT * FROM seller_bids WHERE comp_id=? ORDER BY min_sellp, sell_time DESC";
//                                                                    $stmt2 = $conn->prepare($sql2);
//                                                                    $stmt2->bindParam(1,$comp_idb);
//                                                                    $stmt2->execute();



                                                                }
                                                            }

                                                        }
                                                    }

                                                }
                                            }
                                            else if($buy_stocks>$sell_stocks)
                                            {
                                                $stock2=$buy_stocks-$sell_stocks;

                                                $sql4= "DELETE FROM seller_bids WHERE sell_id=$sell_id";
                                                $sql3= "UPDATE buyer_bids SET buy_stocks=buy_stocks-$sell_stocks where buy_id=$buy_id";

                                                $sql5= "UPDATE shares SET no_stocks=? WHERE user_id=$seller_id AND comp_id=$comp_ids";
                                                $sql6= "UPDATE shares SET no_stocks=? WHERE user_id=$buyer_id AND comp_id=$comp_idb";
                                                $sql7= "INSERT INTO all_transactions(buyer_id,seller_id,comp_id,no_stocks,stock_price) VALUES(:buyer_id,:seller_id,:comp_id,:no_stocks,:stock_price) ";


                                                $stmt3=$conn->prepare($sql3);
                                                if($stmt3->execute())
                                                {
                                                    $stmt4=$conn->prepare($sql4);
                                                    if($stmt4->execute())
                                                    {



                                                        $st=$conn->prepare("SELECT no_stocks FROM shares WHERE user_id=$seller_id AND comp_id=$comp_ids");
                                                        $st->execute();
                                                        $r= $st->fetch(PDO::FETCH_ASSOC);
                                                        $count1=$r["no_stocks"];
                                                        $count1=$count1-$sell_stocks;
                                                        $stmt5=$conn->prepare($sql5);
                                                        $stmt5->bindParam(1,$count1);
                                                        if($stmt5->execute()) {

                                                            $sql8 = "SELECT * FROM shares WHERE user_id=$buyer_id AND comp_id=$comp_idb";
                                                            $sm = $conn->prepare($sql8);
                                                            $sm->execute();
                                                            echo $count = $sm->rowCount();

                                                            if ($count == 0) {
                                                                echo "fk";
                                                                $stmt6 = $conn->prepare("INSERT INTO shares (user_id,comp_id,no_stocks) VALUES(:user_id,:comp_id,:no_stocks)");
                                                                $stmt6->bindParam(':user_id', $buyer_id);
                                                                $stmt6->bindParam(':comp_id', $comp_idb);         //buyer user
                                                                $stmt6->bindParam(':no_stocks', $sell_stocks);
                                                            } else {

                                                                echo "fkR";
                                                                $stmt6 = $conn->prepare("UPDATE shares SET no_stocks=no_stocks+$sell_stocks WHERE user_id=$buyer_id AND comp_id=$comp_idb");

                                                            }
                                                            if ($stmt6->execute()) {

                                                                $stmt7 = $conn->prepare($sql7);
                                                                $stmt7->bindParam(':buyer_id', $buyer_id);
                                                                $stmt7->bindParam(':seller_id', $seller_id);
                                                                $stmt7->bindParam(':comp_id', $comp_ids);    // Transaction
                                                                $stmt7->bindParam(':no_stocks', $sell_stocks);
                                                                $stmt7->bindParam(':stock_price', $min_sellp);
                                                                if ($stmt7->execute()) {
                                                                
                                                                
                                                                                                                $smt12=$conn->prepare("UPDATE shares SET buy_price=$min_sellp where user_id=$buyer_id and comp_id=$comp_idb");
                                                                        $smt12->execute();
                                                                        
                                                                
                                                                      $trans_cash=(($min_sellp*$buy_stocks)-($min_sellp*$buy_stocks*0.02));
                                                                      $trans_fee=($min_sellp*$buy_stocks*0.02);
                                                                      $trans=($min_sellp*$buy_stocks);
                                                                      $trans_refund=(($max_buyp - $min_sellp)* $sell_stocks);

                                                                    $sql21="UPDATE user SET total_cash = total_cash-$trans_fee+$trans WHERE  user_id=$seller_id";   //seller
                                                                    $smt17=$conn->prepare($sql21);
                                                                    if($smt17->execute())
                                                                    {
                                                                        echo "yoo";

                                                                    }

                                                                    //buyer
                                                                    $sql21="UPDATE user SET total_cash = total_cash+ $max_buyp* $buy_stocks*0.02- $trans_fee+ $trans_refund WHERE  user_id= $buyer_id";
                                                                    $smt17=$conn->prepare($sql21);
                                                                    if($smt17->execute())
                                                                    {
                                                                        echo "yoo";
//                                                                        $conn->commit();
                                                                        break;

                                                                    }
//
//                                                                    $stmt2=null;
//                                                                    $sql2 = "SELECT * FROM seller_bids WHERE comp_id=? ORDER BY min_sellp, sell_time DESC";
//                                                                    $stmt2 = $conn->prepare($sql2);
//                                                                    $stmt2->bindParam(1,$comp_idb);
//                                                                    $stmt2->execute();





                                                                }
                                                            }
                                                        }
                                                    }

                                                }
                                            }
                                        }

                                    }
                                    else{

                                        //complete transaction for superuser

                                        if($max_buyp>=$min_sellp)
                                        {

                                            if($sell_stocks==$buy_stocks)
                                            {

                                                $sql3=" DELETE FROM seller_bids WHERE sell_id=$sell_id";
                                                $sql4=" DELETE FROM buyer_bids WHERE buy_id=$buy_id";
                                                $sql5= "UPDATE shares SET no_stocks=? WHERE user_id=$seller_id AND comp_id=$comp_ids";
                                                $sql6= "UPDATE shares SET no_stocks=? WHERE user_id=$buyer_id AND comp_id=$comp_idb";
                                                $sql7= "INSERT INTO all_transactions(buyer_id,seller_id,comp_id,no_stocks,stock_price) VALUES(:buyer_id,:seller_id,:comp_id,:no_stocks,:stock_price) ";

                                                $stmt3=$conn->prepare($sql3);
                                                if($stmt3->execute())
                                                {
                                                    $stmt4=$conn->prepare($sql4);
                                                    if($stmt4->execute())
                                                    {






                                                        $st=$conn->prepare("SELECT no_stocks FROM shares WHERE user_id=$seller_id AND comp_id=$comp_ids");
                                                        $st->execute();
                                                        $r= $st->fetch(PDO::FETCH_ASSOC);
                                                        $count1=$r["no_stocks"];
                                                        $count1=$count1-$sell_stocks;
                                                        $stmt5=$conn->prepare($sql5);
                                                        $stmt5->bindParam(1,$count1);
                                                        if($stmt5->execute()) {

                                                            $sql8 = "SELECT * FROM shares WHERE user_id=$buyer_id AND comp_id=$comp_idb";   //seller
                                                            $sm = $conn->prepare($sql8);
                                                            $sm->execute();
                                                            echo $count = $sm->rowCount();

                                                            if ($count == 0) {
                                                                echo "fk";
                                                                $stmt6 = $conn->prepare("INSERT INTO shares (user_id,comp_id,no_stocks) VALUES(:user_id,:comp_id,:no_stocks)");
                                                                $stmt6->bindParam(':user_id', $buyer_id);
                                                                $stmt6->bindParam(':comp_id', $comp_idb);         //buyer user
                                                                $stmt6->bindParam(':no_stocks', $buy_stocks);
                                                            } else {

                                                                echo "fkR";

                                                                $stmt6 = $conn->prepare("UPDATE shares SET no_stocks=no_stocks+$buy_stocks WHERE user_id=$buyer_id AND comp_id=$comp_idb");


                                                            }
                                                            if ($stmt6->execute()) {

                                                                $stmt7 = $conn->prepare($sql7);
                                                                $stmt7->bindParam(':buyer_id', $buyer_id);
                                                                $stmt7->bindParam(':seller_id', $seller_id);
                                                                $stmt7->bindParam(':comp_id', $comp_ids);    // Transaction
                                                                $stmt7->bindParam(':no_stocks', $sell_stocks);
                                                                $stmt7->bindParam(':stock_price', $min_sellp);
                                                                if ($stmt7->execute()) {
                                                                    $sql12="UPDATE company SET comp_csp=$min_sellp WHERE comp_id=$comp_ids";
                                                                    $smt=$conn->prepare("UPDATE company SET comp_csp=$min_sellp WHERE comp_id=$comp_ids");
                                                                    if($smt->execute())
                                                                    {
                                                                        //$trans_cash=(($min_sellp*$buy_stocks)-($min_sellp*$buy_stocks*0.02));
                                                                        $trans_cash=(($min_sellp*$buy_stocks)-($min_sellp*$buy_stocks*0.02));
                                                                      $trans_fee=($min_sellp*$buy_stocks*0.02);
                                                                      $trans=($min_sellp*$buy_stocks);
                                                                      $trans_refund=(($max_buyp - $min_sellp)* $buy_stocks);

                                                                        $sql21="UPDATE user SET total_cash = total_cash-$trans_fee+$trans WHERE  user_id=$seller_id";   //seller
                                                                        $smt17=$conn->prepare($sql21);
                                                                                                                        $smt12=$conn->prepare("UPDATE shares SET buy_price=$min_sellp where user_id=$buyer_id and comp_id=$comp_idb");
                                                                        $smt12->execute();
                                                                        
                                                                        if($smt17->execute())
                                                                        {
                                                                            echo "yoo";

                                                                        }

                                                                        //buyer
                                                                        $sql21="UPDATE user SET total_cash = total_cash+$trans_refund+(($max_buyp*$buy_stocks*0.02)-$trans_fee) WHERE  user_id=$buyer_id";
                                                                        $smt17=$conn->prepare($sql21);
                                                                        if($smt17->execute())
                                                                        {
                                                                            echo "yoo";
//                                                                            $conn->commit();
                                                                            break;

                                                                        }

//                                                                        $stmt2=null;
//                                                                        $sql2 = "SELECT * FROM seller_bids WHERE comp_id=? ORDER BY min_sellp, sell_time DESC";
//                                                                        $stmt2 = $conn->prepare($sql2);
//                                                                        $stmt2->bindParam(1,$comp_idb);
//                                                                        $stmt2->execute();
//


                                                                    }

                                                                }
                                                            }

                                                        }
                                                    }
                                                }
                                            }
                                            else if($sell_stocks>$buy_stocks)
                                            {

                                                $stock1=$sell_stocks-$buy_stocks;
                                                $sql3="UPDATE seller_bids SET sell_stocks=sell_stocks-$buy_stocks where sell_id=$sell_id";
                                                $sql4="DELETE FROM buyer_bids WHERE buy_id=$buy_id";

                                                $sql5= "UPDATE shares SET no_stocks=? WHERE user_id=$seller_id AND comp_id=$comp_ids";
                                                $sql6= "UPDATE shares SET no_stocks=? WHERE user_id=$buyer_id AND comp_id=$comp_idb";
                                                $sql7= "INSERT INTO all_transactions(buyer_id,seller_id,comp_id,no_stocks,stock_price) VALUES(:buyer_id,:seller_id,:comp_id,:no_stocks,:stock_price) ";

                                                $stmt3=$conn->prepare($sql3);
                                                if($stmt3->execute())
                                                {
                                                    $stmt4=$conn->prepare($sql4);
                                                    if($stmt4->execute())
                                                    {




                                                        echo "deleted 2";


                                                        $st=$conn->prepare("SELECT no_stocks FROM shares WHERE user_id=$seller_id AND comp_id=$comp_ids");
                                                        $st->execute();
                                                        $r= $st->fetch(PDO::FETCH_ASSOC);
                                                        $count1=$r["no_stocks"];
                                                        $count1=$count1-$buy_stocks;
                                                        $stmt5=$conn->prepare($sql5);
                                                        $stmt5->bindParam(1,$count1);
                                                        if($stmt5->execute()) {

                                                            $sql8 = "SELECT * FROM shares WHERE user_id=$buyer_id AND comp_id=$comp_idb";
                                                            $sm = $conn->prepare($sql8);
                                                            $sm->execute();
                                                            echo $count = $sm->rowCount();

                                                            if ($count == 0) {
                                                                echo "fk";
                                                                $stmt6 = $conn->prepare("INSERT INTO shares (user_id,comp_id,no_stocks) VALUES(:user_id,:comp_id,:no_stocks)");
                                                                $stmt6->bindParam(':user_id', $buyer_id);
                                                                $stmt6->bindParam(':comp_id', $comp_idb);         //buyer user
                                                                $stmt6->bindParam(':no_stocks', $buy_stocks);
                                                            } else {

                                                                echo "fkR";
                                                                $stmt6 = $conn->prepare("UPDATE shares SET no_stocks=no_stocks+$buy_stocks WHERE user_id=$buyer_id AND comp_id=$comp_idb");

                                                            }
                                                            if ($stmt6->execute()) {

                                                                $stmt7 = $conn->prepare($sql7);
                                                                $stmt7->bindParam(':buyer_id', $buyer_id);
                                                                $stmt7->bindParam(':seller_id', $seller_id);
                                                                $stmt7->bindParam(':comp_id', $comp_ids);    // Transaction
                                                                $stmt7->bindParam(':no_stocks', $buy_stocks);
                                                                $stmt7->bindParam(':stock_price', $min_sellp);
                                                                if ($stmt7->execute()) {
                                                                    
                                                                    
                                                                                                                                        $sql12="UPDATE company SET comp_csp=$min_sellpE comp_id=$cos";
                                                                    $smt=$conn->prepare("UPDATE company SET comp_csp=$min_sellp WHERE comp_id=$comp_ids");
$smt->execute();
                    
                    
                    
                                                                    $smt12=$conn->prepare("UPDATE shares SET buy_price=$min_sellp where user_id=$buyer_id and comp_id=$comp_idb");
                                                                        $smt12->execute();
                                                                                                                        
                                                                    //$trans_cash=(($min_sellp*$buy_stocks)-($min_sellp*$buy_stocks*0.02));
                                                                    $trans_cash=(($min_sellp*$buy_stocks)-($min_sellp*$buy_stocks*0.02));
                                                                      $trans_fee=($min_sellp*$buy_stocks*0.02);
                                                                      $trans=($min_sellp*$buy_stocks);
                                                                      $trans_refund=(($max_buyp - $min_sellp)* $buy_stocks);

                                                                    $sql21="UPDATE user SET total_cash = total_cash-$trans_fee+$trans WHERE  user_id=$seller_id";   //seller



                                                                    $smt17=$conn->prepare($sql21);
                                                                    if($smt17->execute())
                                                                    {
                                                                        echo "yoo";

                                                                    }

                                                                    //buyer
                                                                    $sql21="UPDATE user SET total_cash = total_cash+ $trans_refund+ $max_buyp*$buy_stocks*0.02- $trans_fee WHERE  user_id=$buyer_id";
                                                                    $smt17=$conn->prepare($sql21);
                                                                    if($smt17->execute())
                                                                    {
                                                                        echo "yoo";
//                                                                        $conn->commit();
                                                                        break;
                                                                    }

//
//                                                                    $stmt2=null;
//                                                                    $sql2 = "SELECT * FROM seller_bids WHERE comp_id=? ORDER BY min_sellp, sell_time DESC";
//                                                                    $stmt2 = $conn->prepare($sql2);
//                                                                    $stmt2->bindParam(1,$comp_idb);
//                                                                    $stmt2->execute();



                                                                }
                                                            }



                                                        }
                                                    }

                                                }
                                            }
                                            else if($buy_stocks>$sell_stocks)
                                            {
                                                $stock2=$buy_stocks-$sell_stocks;

                                                $sql4= "DELETE FROM seller_bids WHERE sell_id=$sell_id";
                                                $sql3= "UPDATE buyer_bids SET buy_stocks=buy_stocks-$sell_stocks where buy_id=$buy_id";

                                                $sql5= "UPDATE shares SET no_stocks=? WHERE user_id=$seller_id AND comp_id=$comp_ids";
                                                $sql6= "UPDATE shares SET no_stocks=? WHERE user_id=$buyer_id AND comp_id=$comp_idb";
                                                $sql7= "INSERT INTO all_transactions(buyer_id,seller_id,comp_id,no_stocks,stock_price) VALUES(:buyer_id,:seller_id,:comp_id,:no_stocks,:stock_price) ";


                                                $stmt3=$conn->prepare($sql3);
                                                if($stmt3->execute())
                                                {
                                                    $stmt4=$conn->prepare($sql4);
                                                    if($stmt4->execute())
                                                    {




                                                        $st=$conn->prepare("SELECT no_stocks FROM shares WHERE user_id=$seller_id AND comp_id=$comp_ids");
                                                        $st->execute();
                                                        $r= $st->fetch(PDO::FETCH_ASSOC);
                                                        $count1=$r["no_stocks"];
                                                        $count1=$count1-$sell_stocks;
                                                        $stmt5=$conn->prepare($sql5);
                                                        $stmt5->bindParam(1,$count1);
                                                        if($stmt5->execute()) {

                                                            $sql8 = "SELECT * FROM shares WHERE user_id=$buyer_id AND comp_id=$comp_idb";   //seller
                                                            $sm = $conn->prepare($sql8);
                                                            $sm->execute();
                                                            echo $count = $sm->rowCount();

                                                            if ($count == 0) {
                                                                echo "fk";
                                                                $stmt6 = $conn->prepare("INSERT INTO shares (user_id,comp_id,no_stocks) VALUES(:user_id,:comp_id,:no_stocks)");
                                                                $stmt6->bindParam(':user_id', $buyer_id);
                                                                $stmt6->bindParam(':comp_id', $comp_idb);         //buyer user
                                                                $stmt6->bindParam(':no_stocks', $sell_stocks);
                                                            } else {

                                                                echo "fkR";
                                                                $stmt6 = $conn->prepare("UPDATE shares SET no_stocks=no_stocks+$sell_stocks WHERE user_id=$buyer_id AND comp_id=$comp_idb");

                                                            }
                                                            if ($stmt6->execute()) {

                                                                $stmt7 = $conn->prepare($sql7);
                                                                $stmt7->bindParam(':buyer_id', $buyer_id);
                                                                $stmt7->bindParam(':seller_id', $seller_id);
                                                                $stmt7->bindParam(':comp_id', $comp_ids);    // Transaction
                                                                $stmt7->bindParam(':no_stocks', $sell_stocks);
                                                                $stmt7->bindParam(':stock_price', $min_sellp);
                                                                if ($stmt7->execute()) {
                                                                    
                                                                    
                                                                                                                                        $sql12="UPDATE company SET comp_csp=$min_sellp WHERE comp_id=$comp_ids";
                                                                    $smt=$conn->prepare("UPDATE company SET comp_csp=$min_sellp WHERE comp_id=$comp_ids");
$smt->execute();
                                                                    
                                                                    
                                                                                                                    $smt12=$conn->prepare("UPDATE shares SET buy_price=$min_sellp where user_id=$buyer_id and comp_id=$comp_idb");
                                                                        $smt12->execute();
                                                                        
                                                                    
                                                                    
                                                                      $trans_cash=(($min_sellp*$buy_stocks)-($min_sellp*$buy_stocks*0.02));
                                                                      $trans_fee=($min_sellp*$buy_stocks*0.02);
                                                                      $trans=($min_sellp*$buy_stocks);
                                                                      $trans_refund=(($max_buyp - $min_sellp)* $sell_stocks);

                                                                    $sql21="UPDATE user SET total_cash = total_cash-$trans_fee+$trans WHERE  user_id=$seller_id";   //seller
                                                                    $smt17=$conn->prepare($sql21);
                                                                    if($smt17->execute())
                                                                    {
                                                                        echo "yoo";

                                                                    }

                                                                    //buyer
                                                                    $sql21="UPDATE user SET total_cash = total_cash+ $max_buyp* $buy_stocks*0.02- $trans_fee + $trans_refund WHERE  user_id=$buyer_id";
                                                                    $smt17=$conn->prepare($sql21);
                                                                    if($smt17->execute())
                                                                    {
                                                                        echo "yoo";
//                                                                        $conn->commit();
                                                                        break;

                                                                    }
//
//                                                                    $stmt2=null;
//                                                                    $sql2 = "SELECT * FROM seller_bids WHERE comp_id=? ORDER BY min_sellp, sell_time DESC";
//                                                                    $stmt2 = $conn->prepare($sql2);
//                                                                    $stmt2->bindParam(1,$comp_idb);
//                                                                    $stmt2->execute();



                                                                }
                                                            }
                                                        }
                                                    }

                                                }
                                            }
                                        }
                                    }

                                }catch (Exception $exception){
//                                    $conn->rollBack();
                                    echo "Failed: " . $exception->getMessage();
                                }
                                $j--;
                            }


                        }
                        else{

                        }

                    

                    $i--;
                }

            } else
            {
                echo "NO Buyer Bids";
            }
        }
        catch (PDOException $exception)
        {
            echo $exception->getMessage();
        }
    }
}

$obj=new bid();
$obj->buyfn();

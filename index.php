<?php
//include('session.php');
require_once 'connection.php';
session_start();
if(!isset($_SESSION['login_id'])){
    header("location: sign-in.php");
}
$stmt = $conn->prepare('select user_name from user where user_id=:userid');
$stmt->bindParam(':userid',$_SESSION['login_id']);
$stmt->execute();
$result=$stmt->fetch(PDO::FETCH_NUM);
$_SESSION['login_name']=$result[0];
?>

    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <title>WallStreet | Credenz '17</title>

        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">

        <!-- Bootstrap Select Css -->
        <link href="plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />

        <!-- Bootstrap Core Css -->
        <link href="plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

        <!-- Waves Effect Css -->
        <link href="plugins/node-waves/waves.css" rel="stylesheet" />

        <!-- Animation Css -->
        <link href="plugins/animate-css/animate.css" rel="stylesheet" />

        <!-- Custom Css -->
        <link href="css/style.css" rel="stylesheet">

        <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
        <link href="css/themes/all-themes.css" rel="stylesheet" />

    </head>

    <body class="theme-red">
        <!-- Page Loader -->
        <div class="page-loader-wrapper">
            <div class="loader">
                <div class="preloader">
                    <div class="spinner-layer pl-red">
                        <div class="circle-clipper left">
                            <div class="circle"></div>
                        </div>
                        <div class="circle-clipper right">
                            <div class="circle"></div>
                        </div>
                    </div>
                </div>
                <p>Please wait...</p>
            </div>
        </div>
        <!-- #END# Page Loader -->
        <!-- Overlay For Sidebars -->
        <div class="overlay"></div>
        <!-- #END# Overlay For Sidebars -->
        <!-- #END# Search Bar -->
        <!-- Top Bar -->
        <nav class="navbar">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a href="javascript:void(0);" class="js-right-sidebar pull-right navbar-toggle collapsed" aria-expanded="false"></a>
                    <a href="javascript:void(0);" class="bars"></a>
                    <a class="navbar-brand" href="index.php">WALLSTREET</a>
                </div>
                <div class="collapse navbar-collapse" id="navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="pull-right"><a href="javascript:void(0);" class="js-right-sidebar" data-close="true"><i class="material-icons">trending_up</i></a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- #Top Bar -->
        <section>
            <!-- Left Sidebar -->
            <aside id="leftsidebar" class="sidebar">
                <!-- User Info -->
                <div class="user-info">
                    <div class="image">
                        <img src="images/user.png" width="48" height="48" alt="User" />
                    </div>
                    <div style="display: -webkit-box;">
                        <div class="info-container">
                            <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?php echo $_SESSION["login_name"] ; ?>
                            </div>
                            <div class="email">Game ID :
                                <?php echo $_SESSION["login_id"]; ?>
                            </div>
                        </div>
                        <div class="col-xs-4 col-xs-offset-3 info-container">
                            <button onclick="location.href='logout.php';" type="button" class="btn btn-info waves-effect">
                            <i class="material-icons">input</i>
                            <span>Sign Out</span>
                        </button>
                        </div>
                    </div>
                </div>
                <!-- #User Info -->
                <!-- Menu -->
                <div class="menu">
                    <ul class="list">
                        <li id="m_home">
                            <a onclick="d_home()">
                                <i class="material-icons">home</i>
                                <span>Home</span>
                            </a>
                        </li>
                        <li id="m_market">
                            <a href="javascript:void(0);" onclick="d_market()">
                                <i class="material-icons">local_grocery_store</i>
                                <span>Buy/Sell</span>
                            </a>
                        </li>
                        <li id="m_bids">
                            <a href="javascript:void(0);" onclick="d_bids()">
                                <i class="material-icons">receipt</i>
                                <span>My Bids</span>
                            </a>
                        </li>
                        <li id="m_trans">
                            <a onclick="d_trans()">
                                <i class="material-icons">swap_vert</i>
                                <span>Transaction History</span>
                            </a>
                        </li>
                        <li id="m_news">
                            <a onclick="d_news()">
                                <i style="margin-top: 6px;font-size:24px" class="fa fa-newspaper-o" aria-hidden="true"></i>
                                <span>News</span>
                            </a>
                        </li>
                        <li id="m_comp">
                            <a onclick="d_comp()">
                                <i class="material-icons">business</i>
                                <span>Leadersboard</span>
                            </a>
                        </li>
                        <li id="m_rules" class="active">
                            <a onclick="d_rules()">
                                <i class="material-icons">edit</i>
                                <span>Rules</span>
                            </a>
                        </li>
                        <li id="m_dev">
                            <a onclick="d_dev()">
                                <i class="material-icons">code</i>
                                <span>Developers</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- #Menu -->
                <!-- Footer -->
                <div class="legal">
                    <div class="copyright">
                        &copy; Wallstreet <a href="javascript:void(0);">Credenz '17</a>.
                    </div>
                    <div class="version">
                        PICT IEEE Student Branch
                    </div>
                </div>
                <!-- #Footer -->
            </aside>
            <!-- #END# Left Sidebar -->
            <!-- Right Sidebar -->
            <aside id="rightsidebar" class="right-sidebar">
                <div class="row clearfix">
                    <div class="col-xs-12">
                        <div class="card">
                            <div class="header">
                                <h2>
                                    <span style="color:green;">LIVE</span> STOCK MARKET
                                </h2>
                            </div>
                            <div class="body table-responsive" style="height: calc(100vh - 125px);overflow-y:scroll;">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>COMPANY</th>
                                            <th>PRICE</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th scope="row">1</th>
                                            <td>AIRTEL</td>
                                            <td id="csp_1">0</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">2</th>
                                            <td>AXIS</td>
                                            <td id="csp_2">0</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">3</th>
                                            <td>BAJAJ ELECTRICALS</td>
                                            <td id="csp_3">0</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">4</th>
                                            <td>BALAJI TELEFILMS</td>
                                            <td id="csp_4">0</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">5</th>
                                            <td>BANK OF BARODA</td>
                                            <td id="csp_5">0</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">6</th>
                                            <td>BRITANNIA</td>
                                            <td id="csp_6">0</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">7</th>
                                            <td>CIPLA</td>
                                            <td id="csp_7">0</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">8</th>
                                            <td>DABUR</td>
                                            <td id="csp_8">0</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">9</th>
                                            <td>DHFL</td>
                                            <td id="csp_9">0</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">10</th>
                                            <td>DR.REDDY'S</td>
                                            <td id="csp_10">0</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">11</th>
                                            <td>EMAMI</td>
                                            <td id="csp_11">0</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">12</th>
                                            <td>GODREJ CONSUMER PRDUCTS</td>
                                            <td id="csp_12">0</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">13</th>
                                            <td>HINDUSTN PETROLEUM</td>
                                            <td id="csp_13">0</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">14</th>
                                            <td>HUL</td>
                                            <td id="csp_14">0</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">15</th>
                                            <td>IDEA</td>
                                            <td id="csp_15">0</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">16</th>
                                            <td>INDIABULLS</td>
                                            <td id="csp_16">0</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">17</th>
                                            <td>INFOSYS</td>
                                            <td id="csp_17">0</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">18</th>
                                            <td>ITC HOTELS</td>
                                            <td id="csp_18">0</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">19</th>
                                            <td>JIO</td>
                                            <td id="csp_19">0</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">20</th>
                                            <td>MAHINDRA AND MAHINDRA</td>
                                            <td id="csp_20">0</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">21</th>
                                            <td>MARUTI SUZUKI</td>
                                            <td id="csp_21">0</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">22</th>
                                            <td>MINDTREE</td>
                                            <td id="csp_22">0</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">23</th>
                                            <td>MUTHOOT FINANCE</td>
                                            <td id="csp_23">0</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">24</th>
                                            <td>NESTLE</td>
                                            <td id="csp_24">0</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">25</th>
                                            <td>OBEROI</td>
                                            <td id="csp_25">0</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">26</th>
                                            <td>PEPSICO</td>
                                            <td id="csp_26">0</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">27</th>
                                            <td>POWER GRID CORPORATION</td>
                                            <td id="csp_27">0</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">28</th>
                                            <td>SBI</td>
                                            <td id="csp_28">0</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">29</th>
                                            <td>SUZLON</td>
                                            <td id="csp_29">0</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">30</th>
                                            <td>TAJ HOTELS</td>
                                            <td id="csp_30">0</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">31</th>
                                            <td>TATA MOTORS</td>
                                            <td id="csp_31">0</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">32</th>
                                            <td>TCS</td>
                                            <td id="csp_32">0</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">33</th>
                                            <td>TV18</td>
                                            <td id="csp_33">0</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">34</th>
                                            <td>VIDEOCON</td>
                                            <td id="csp_34">0</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">35</th>
                                            <td>WHIRLPOLL</td>
                                            <td id="csp_35">0</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">36</th>
                                            <td>ZEE ENTERTAINMENT</td>
                                            <td id="csp_36">0</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </aside>
            <!-- #END# Right Sidebar -->
        </section>
        <!-- Home -->
        <section id="homep" class="content" style="display:none">
            <div class="container-fluid">
                <div class="block-header">
                    <h2>DASHBOARD</h2>
                </div>
                <!-- Widgets -->
                <div class="row clearfix">
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                        <div class="info-box-3 bg-pink hover-expand-effect">
                            <div class="icon">
                                <i style="margin-bottom: 4px;" class="fa fa-rupee" aria-hidden="true"></i>
                            </div>
                            <div class="content" id="t1">
                                <div class="text">TOTAL CASH</div>
                                <div class="number cash">0</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                        <div class="info-box-3 bg-cyan hover-expand-effect">
                            <div class="icon">
                                <i style="margin-bottom: 4px;" class="fa fa-briefcase" aria-hidden="true"></i>
                            </div>
                            <div class="content">
                                <div class="text">TOTAL ASSETS</div>
                                <div class="number assets">0</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 newcom">
                        <div class="info-box-3 bg-light-green hover-expand-effect">
                            <div class="icon">
                                <i class="material-icons">forum</i>
                            </div>
                            <div class="content cmpcsp">

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 totplay">
                        <div class="info-box-3 bg-orange hover-expand-effect">
                            <div class="icon">
                                <i class="material-icons">people</i>
                            </div>
                            <div class="content">
                                <div class="text">ACTIVE PLAYERS</div>
                                <div class="number actuse">0</div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- #END# Widgets -->
                <div class="row clearfix">
                    <!-- Transaction -->
                    <div class="col-md-8 col-sm-8 col-xs-12">
                        <div class="card">
                            <div class="header">
                                <h2>
                                    MY SHARES
                                </h2>
                            </div>
                            <div class="body table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>COMPANY</th>
                                            <th>STOCKS</th>
                                            <th>STATUS</th>
                                            <th>BUY PRICE</th>
                                            <th>CURR. PRICE</th>
                                        </tr>
                                    </thead>
                                    <tbody id="myshares">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!--#Transaction-->
                    <!--News Alerts-->
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <div class="card">
                            <div class="header">
                                <h2>
                                    NEWS ALERTS
                                </h2>
                            </div>
                            <div class="body table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>TITLE</th>
                                        </tr>
                                    </thead>
                                    <tbody id="newsTitleHere">
                                        <tr>
                                            <th scope="row">1</th>
                                            <td>Mark</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">2</th>
                                            <td>Jacob</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">3</th>
                                            <td>Larry</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">4</th>
                                            <td>Larry</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">5</th>
                                            <td>Larry</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!--#News Alerts-->
                </div>
            </div>
        </section>
        <!-- Market -->
        <section id="marketp" class="content" style="display:none">
            <div class="container-fluid">
                <div class="block-header">
                    <h2>MARKET</h2>
                </div>
                <!-- Widgets -->
                <div class="row clearfix">
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                        <div class="info-box-3 bg-pink hover-expand-effect">
                            <div class="icon">
                                <i style="margin-bottom: 4px;" class="fa fa-rupee" aria-hidden="true"></i>
                            </div>
                            <div class="content" id="t1">
                                <div class="text">TOTAL CASH</div>
                                <div class="number cash">0</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                        <div class="info-box-3 bg-cyan hover-expand-effect">
                            <div class="icon">
                                <i style="margin-bottom: 4px;" class="fa fa-briefcase" aria-hidden="true"></i>
                            </div>
                            <div class="content">
                                <div class="text">TOTAL ASSETS</div>
                                <div class="number assets">0</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 newcom">
                        <div class="info-box-3 bg-light-green hover-expand-effect">
                            <div class="icon">
                                <i class="material-icons">forum</i>
                            </div>
                            <div class="cmpcsp content">

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 totplay">
                        <div class="info-box-3 bg-orange hover-expand-effect">
                            <div class="icon">
                                <i class="material-icons">people</i>
                            </div>
                            <div class="content">
                                <div class="text">TOTAL LIVE PLAYERS</div>
                                <div class="number actuse">0</div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- #END# Widgets -->
                <!-- Buy Stocks -->
                <div class="row clearfix">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="card">
                            <div class="header">
                                <h2>
                                    BUY STOCKS
                                </h2>
                            </div>
                            <div class="body">
                                <div class="row clearfix">
                                    <form id="form_advanced_validation" class="form1" method="POST" action="">
                                        <div class="col-md-3" id="buy_list1">

                                        </div>
                                        <div class="col-md-3 col-xs-6">
                                            <div class="form-group form-float" style="margin-top: 22px;padding-left:15px;">
                                                <div class="form-line">
                                                    <input type="number" class="form-control" name="nostocks" min="0" max="30" required>
                                                    <label class="form-label">No. of Stocks</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-xs-6">
                                            <div class="form-group form-float" style="margin-top: 22px;padding-right:15px;">
                                                <div class="form-line">
                                                    <input type="number" class="form-control" name="bprice" min="0" required>
                                                    <label class="form-label">Price</label>
                                                </div>
                                            </div>
                                        </div>
                                        <button id="buy_btnid" class="btn btn-primary waves-effect buy_btn" name="submit" type="reset">BUY</button>
                                        <div id="errbox" class="error"></div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- #END# Buy Stocks -->
                <!-- Sell Stocks -->
                <div class="row clearfix">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="card">
                            <div class="header">
                                <h2>
                                    SELL STOCKS
                                </h2>
                            </div>
                            <div class="body">
                                <div class="row clearfix">
                                    <form id="form_advanced_validation1" class="form2" method="POST">
                                        <div id="sell_list1" class="col-md-3">

                                        </div>
                                        <div class="col-md-3 col-xs-6">
                                            <div class="form-group form-float" style="margin-top: 22px;padding-left:15px;">
                                                <div class="form-line">
                                                    <input type="number" class="form-control" name="snostocks" min="0" max="30" required>
                                                    <label class="form-label">No. of Stocks</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-xs-6">
                                            <div class="form-group form-float" style="margin-top: 22px;padding-right:15px;">
                                                <div class="form-line">
                                                    <input type="number" class="form-control" name="sprice" min="0" required>
                                                    <label class="form-label">Price</label>
                                                </div>
                                            </div>
                                        </div>
                                        <button id="sell_btnid" class="btn btn-primary waves-effect buy_btn" name="submit" type="reset" style="">SELL</button>
                                        <div id="errbox1" class="error"></div>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- #END# Sell Stocks -->
            </div>
        </section>
        <!-- My Bids -->
        <section id="bidsp" class="content" style="display:none">
            <div class="container-fluid">
                <div class="block-header">
                    <h2>MY BIDS</h2>
                </div>
                <!-- Widgets -->
                <div class="row clearfix">
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                        <div class="info-box-3 bg-pink hover-expand-effect">
                            <div class="icon">
                                <i style="margin-bottom: 4px;" class="fa fa-rupee" aria-hidden="true"></i>
                            </div>
                            <div class="content" id="t1">
                                <div class="text">TOTAL CASH</div>
                                <div class="number cash">0</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                        <div class="info-box-3 bg-cyan hover-expand-effect">
                            <div class="icon">
                                <i style="margin-bottom: 4px;" class="fa fa-briefcase" aria-hidden="true"></i>
                            </div>
                            <div class="content">
                                <div class="text">TOTAL ASSETS</div>
                                <div class="number assets">0</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 newcom">
                        <div class="info-box-3 bg-light-green hover-expand-effect">
                            <div class="icon">
                                <i class="material-icons">forum</i>
                            </div>
                            <div class="cmpcsp content">

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 totplay">
                        <div class="info-box-3 bg-orange hover-expand-effect">
                            <div class="icon">
                                <i class="material-icons">people</i>
                            </div>
                            <div class="content">
                                <div class="text">TOTAL PLAYERS</div>
                                <div class="number actuse">0</div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- #END# Widgets -->
                <!-- Transaction -->
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="card">
                            <div class="body">
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs tab-nav-right tab-col-red" role="tablist">
                                    <li role="presentation" class="active"><a href="#home" data-toggle="tab">BUY BIDS</a></li>
                                    <li role="presentation"><a href="#profile" data-toggle="tab">SELL BIDS</a></li>
                                </ul>
                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane fade in active" id="home">
                                        <div class="row clearfix">
                                            <div class="col-xs-12">
                                                <div class="body table-responsive">
                                                    <table class="table table-bordered table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>CANCEL</th>
                                                                <th>COMPANY</th>
                                                                <th>STOCKS</th>
                                                                <th>PRICE</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="buybids">
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div role="tabpanel" class="tab-pane fade" id="profile">
                                        <div class="row clearfix">
                                            <div class="col-xs-12">
                                                <div class="body table-responsive">
                                                    <table class="table table-bordered table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>CANCEL</th>
                                                                <th>COMPANY</th>
                                                                <th>STOCKS</th>
                                                                <th>PRICE</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="sellbids">
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--#Transaction-->
            </div>
        </section>
        <!-- Transaction History -->
        <section id="transp" class="content" style="display:none;">
            <div class="row clearfix">
                <div class="col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                TRANSACTION HISTORY
                            </h2>
                        </div>
                        <div class="body table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>COMPANY</th>
                                        <th>NO. OF STOCKS</th>
                                        <th>TOTAL PRICE</th>
                                        <th>STATUS</th>
                                    </tr>
                                </thead>
                                <tbody id="givemetrans">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- News -->
        <section id="newsp" class="content" style="display:none;">
            <div class="row clearfix">
                <div class="col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                NEWS SUMMARY
                            </h2>
                        </div>
                        <div class="body">
                            <div class="row clearfix">
                                <div class="col-xs-12 ol-sm-12 col-md-12 col-lg-12">
                                    <div class="panel-group" id="accordion_1" role="tablist" aria-multiselectable="true">
                                        <div id="newsHere">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Company Details -->
        <section id="companyp" class="content" style="display:none;">
            <div class="container-fluid"> 
            <div class="row clearfix">
                <div class="col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                LEADERSBOARD
                            </h2>
                        </div>
                        <div id="leader" class="body">
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </section>
        <!--  Rules  -->
         
        <section id="rulep" class="content active">
            <div class="container-fluid">
                <div class="block-header">
                    <h2>RULES</h2>
                </div>
                <!-- Body Copy -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                RULES PAGE
                            </h2>
                        </div>
                        <div class="body">
                            <ol>
                        <li>This document is a step by step guide to Wall Street and its basic rules.</li>
                        <li> The participants are expected to follow the rules and regulations in this document.</li>
                        <li>It is highly advised that the user has a thorough understanding of the rules before starting the game, as it won’t just increase the chances of the user to make more money but it will also ensure that the user takes home some useful knowledge on trading and the Stock Market.
                        </li>
                        <h5>Impact of News-</h5>
                        <li> Wall Street is a game that is greatly dependent and impacted by news. Like any stock market, the prices and behavior of stocks vary in real time depending on the sentiment the news evokes.</li>
                        <li> Hence it is highly advised that the participants buy and sell their stocks after reading the kind of changes that the news might bring about in the market.
                        </li>

                        <h5>Starting The Game-</h5>
                        <li>Every player starts the game with Rs.1,40,000.</li>


                        <li>The player is supposed to buy shares of his choice.</li>
                        Buying Shares-
                        <li>The participant is supposed to put a buying bid (the maximum price the participant is willing to pay) in order to make a purchase (of shares).</li>
                        <li>The algorithm will find the lowest possible share price and make the transaction with one or multiple sellers depending upon the number of shares that they’ve put up for sale, starting from the lowest price.</li>
                        <li>And the purchase amount (max. price per share * no. of shares) with 1% transaction charges while buying and 2.5% while selling will be blocked until the purchase is made or till the buying bid is cancelled.</li>
                        Selling Shares-
                        <li>The participant is expected to decide the number of shares and the price per share that he/she is willing to sell at.</li>


                        <li>The selling price per share cannot be more/less than 5% of the share’s current price.
                        </li>

                        <h5>Transaction Charges-</h5>
                        <li>Every transaction will attract transaction charges on the total transaction amount.</li>
                        <li>1% while buying and 2.5% while selling.</li>
                        <li>This will be charged from the seller and the buyer.</li>
                        <li>It will be charged from the seller regardless of the profit/loss that the seller is making.</li>

                        <h5>Judging The Winner-</h5>
                        <li>At the end of the day, every player’s net worth will be calculated.</li>
                        <li>60% of the money and 40% of the assets will be considered while calculating a player’s net worth.</li>



                        <li>And the player with the highest net worth will be judged the winner.</li>

                    </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Body Copy -->
            </div>

        </section>
        <!-- Devlopers -->

        <!-- Jquery Core Js -->
        <script src="plugins/jquery/jquery.min.js"></script>

        <!-- Bootstrap Core Js -->
        <script src="plugins/bootstrap/js/bootstrap.js"></script>

        <!-- Select Plugin Js -->
        <script src="plugins/bootstrap-select/js/bootstrap-select.js"></script>

        <!-- Jquery Validation Plugin Css -->
        <script src="plugins/jquery-validation/jquery.validate.js"></script>

        <!-- Waves Effect Plugin Js -->
        <script src="plugins/node-waves/waves.js"></script>

        <!-- Custom Js -->
        <script src="js/admin.js"></script>
        <script src="js/pages/index.js"></script>
        <script src="js/pages/forms/form-validation.js"></script>
        <script src="js/pages/forms/advanced-form-elements.js"></script>

        <script>
            setInterval(function getCash() {
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        var obj = JSON.parse(this.responseText);
                        for (i = 0; i < 3; i++) {
                            document.getElementsByClassName('cash')[i].innerHTML = obj.total_cash;
                            document.getElementsByClassName('assets')[i].innerHTML = obj.total_assets;
                        }
                    }
                };
                xhttp.open("GET", "cash.php", true);
                xhttp.send();
            }, 2000);

            var i = 1;
            setInterval(function getcsp() {
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        var obj = JSON.parse(this.responseText);
                        for (i = 1; i <= 36; i++) {
                            document.getElementById("csp_" + i).innerHTML = obj[i - 1];
                        }
                    }
                };
                xhttp.open("GET", "csp.php", true);
                xhttp.send();
            }, 1000);

            function getmyshare() {
                $('#myshares').load('myshares.php');
                setInterval(function() {
                    $('#myshares').load('myshares.php');
                }, 5000)
            };
            getmyshare();

            function getTrans() {
                $('#givemetrans').load('transaction.php');
                setInterval(function() {
                    $('#givemetrans').load('transaction.php');
                }, 5000)
            };
            getTrans();

            function getNews() {
                $('#newsHere').load('news_display.php');
                setInterval(function() {
                    $('#newsHere').load('news_display.php');
                }, 60000)
            };
            getNews();

            function getTitleNews() {
                $('#newsTitleHere').load('news_title_display.php');
                setInterval(function() {
                    $('#newsTitleHere').load('news_title_display.php');
                }, 60000)
            };
            getTitleNews();

            function getcmpcsp() {
                $('.cmpcsp').load('getCompCsp.php');
                setInterval(function() {
                    $('.cmpcsp').load('getCompCsp.php');
                }, 3000)
            };
            getcmpcsp();

            function getactiveusers() {
                $('.actuse').load('activeusers.php');
                setInterval(function() {
                    $('.actuse').load('activeusers.php');
                }, 1000)
            };
            getactiveusers();

            function getmybcomp() {
                $('#buy_list1').load('buysellcompany_display.php');
                setInterval(function() {
                    $('#buy_list1').load('buysellcompany_display.php');
                }, 60000)
            };
            getmybcomp();

            function getmyscomp() {
                $('#sell_list1').load('buysellcompany_display1.php');
                setInterval(function() {
                    $('#sell_list1').load('buysellcompany_display1.php');
                }, 60000)
            };
            getmyscomp();

            $('.form1').on("submit", function(e) {
                e.preventDefault();
            });
            $('.form2').on("submit", function(e) {
                e.preventDefault();
            });
            $('#buy_btnid').click(function() {
                $.ajax({
                    type: "POST",
                    data: $(".form1").serialize(),
                    async: true,
                    dataType: "html",
                    url: "addBuyBid.php",
                    success: function(data) {
                        if (data == "0") {
                            document.getElementById('errbox').innerHTML = "Buy price not in range.";
                        }
                        if (data == "1") {
                            document.getElementById('errbox').innerHTML = "Insufficient Balance";
                        }
                        if (data == "2") {
                            document.getElementById('errbox').innerHTML = "Bid has been placed";
                        }
                        if (data == "4") {
                            document.getElementById('errbox').innerHTML = "Fields cannot be Empty";
                        }
                        if (data == "3") {
                            document.getElementById('errbox').innerHTML = "Stocks cannot be greater than 30";
                        }
                    }
                });
            });

            $('#sell_btnid').click(function() {
                $.ajax({
                    type: "POST",
                    data: $(".form2").serialize(),
                    async: true,
                    dataType: "html",
                    url: "addSellBid.php",
                    success: function(data) {
                        if (data == "0") {
                            document.getElementById('errbox1').innerHTML = "Sell price not in range.";
                        }
                        if (data == "1") {
                            document.getElementById('errbox1').innerHTML = "Not enough stocks";
                        }
                        if (data == "2") {
                            document.getElementById('errbox1').innerHTML = "Bid has been placed";
                        }
                        if (data == "4") {
                            document.getElementById('errbox1').innerHTML = "Fields cannot be Empty";
                        }
                        if (data == "3") {
                            document.getElementById('errbox1').innerHTML = "Stocks cannot be greater than 30";
                        }

                    }
                });
            });

            function mybuybids() {
                $('#buybids').load('getBuyerBids.php');
                setInterval(function() {
                    $('#buybids').load('getBuyerBids.php');
                }, 5000)
            };
            mybuybids();

            function mysellbids() {
                $('#sellbids').load('getSellerBids.php');
                setInterval(function() {
                    $('#sellbids').load('getSellerBids.php');
                }, 5000)
            };
            mysellbids();

            function delBuyBid(id) {
                //id=$(this).attr("id");
                var data = "buy_id=" + id;
                $.ajax({
                    type: "GET",
                    data: data,
                    async: true,
                    dataType: "html",
                    url: "delBuyBid.php",
                    success: function(data) {
                        if (data == "0") {
                            alert("No Bid Found");
                        }
                        if (data == "1") {
                            alert("Bid Removed");
                        }
                    }
                });
            };


            function delSellBid(id) {
                //id=$(this).attr("id");
                var data = "sell_id=" + id;
                $.ajax({
                    type: "GET",
                    data: data,
                    async: true,
                    dataType: "html",
                    url: "delSellBid.php",
                    success: function(data) {
                        if (data == "0") {
                            alert("No Bid Found");
                        }
                        if (data == "1") {
                            alert("Bid Removed");
                        }
                    }
                });
            };

        </script>


    </body>

    </html>

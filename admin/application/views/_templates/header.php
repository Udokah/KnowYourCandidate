<html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta name="robots" content="noindex, nofollow">
        <meta name="googlebot" content="noindex, nofollow">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, maximum-scale=1, user-scalable=no" />
	<meta name="mobile-web-app-capable" content="yes" />
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="apple-mobile-web-app-status-bar-style" content="black" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title><?php echo $this->title ?> </title>
        <meta name="description" value="<?php echo $this->description ?>" >

        <link rel="stylesheet" href="<?php echo URL ?>/public/css/bootstrap.min.css">
        <style>
            body {
                padding-top: 50px;
                padding-bottom: 20px;
            }
        </style>
        <link rel="stylesheet" href="<?php echo URL ?>/public/css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="<?php echo URL ?>/public/css/main.css">

        <style type="text/css">
body { margin-top:0px; }
.fa { font-size: 50px;text-align: right;position: absolute;top: 7px;right: 27px;outline: none; }
a { transition: all .3s ease;-webkit-transition: all .3s ease;-moz-transition: all .3s ease;-o-transition: all .3s ease; }


.panel-body .btn:not(.btn-block) { width:120px;margin-bottom:10px; }
        </style>

        <!--[if lt IE 9]>
            <script src="public/js/vendor/html5-3.6-respond-1.1.0.min.js"></script>
        <![endif]-->
        
        <script>window.jQuery || document.write('<script src="<?php echo URL ?>/public/js/vendor/jquery-1.11.0.min.js"><\/script>')</script>

       <script type="text/javascript" src="<?php echo URL ?>/public/js/datatables.min.js"></script>
       <script type="text/javascript" src="<?php echo URL ?>/public/js/datatables-bootstrap.js"></script>

         <script type="text/javascript">
          var URL = "<?php echo URL ?>" ;
         </script>
         
         <script src="<?php echo URL ?>/public/js/main.js"></script>

        <!-- Inject css files here -->
         <?php echo $this->getCssLinks() ?>

        <!-- Inject Javascript files here -->
        <?php echo $this->getScripts() ?>

        <!-- Inject external css links here -->
        <?php echo $this->getExtCss() ?>

        <style>
            .bodyOverlay {
                background-color: rgba(0, 0, 0, 0.5);
                color: #333;
                position: fixed;
                width: 100%;
                z-index: 900;
                height: 100%;
                top: 0px;
                display:none;
            }

            .alertDialog{
                display: none;
                z-index: 1000;
                position: fixed;
                background-color: #ffffff;
                width:97%;
                margin: 15% auto;
                left: 0;
                right: 0;
                max-width: 400px;
            }

            .alertDialog span{
                padding:10px;
                font-size: 18px;
                line-height: 30px;
                font-family: 'PT Sans Narrow', Calibri, 'Myriad Pro', Tahoma, Arial;
                display: block;
                text-align: center;

            }

            .alertDialog a{
                display: block !important;
                text-align: center;
                border-radius: 0 0 0 0 !important;
            }

            .loading{
                display: none;
                position: fixed;
                width: 200px;
                text-align: center;
                margin: 15% auto;
                left: 0;
                right: 0;
                z-index: 1200;
            }
        </style>

    </head>
    <body>



    <div id="bodyOverlay" name="bodyOverlay" class="bodyOverlay">
    </div>

    <div class="loading">
        <img src="<?php echo URL ?>/public/img/facebook.gif" alt="Loading" />
    </div>

    <div class="alertDialog">
<span>
    this is an alert dialog
</span>
        <a href="#" class="btn-danger btn"><i class="fa fa-times fa-lg"></i> close</a>
    </div>



        <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="public/http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

        <?php echo $this->getnavBar() ?>   

    <script type="text/javascript">
    var Page = "<?php echo PAGE ?>" ;
    var URL = "<?php echo URL ?>" ;
    $(document).ready(function(){
        $('#navLinks').find('.' + Page ).addClass('active') ;
    });
    </script>

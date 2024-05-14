<!doctype html>
<html class="no-js" lang="en" dir="ltr">
    <head>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-9746991-1"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());

            gtag('config', 'UA-9746991-1');
        </script>

        <link rel="apple-touch-icon" sizes="57x57" href="favicon/apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="favicon/apple-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="favicon/apple-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="favicon/apple-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="favicon/apple-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="favicon/apple-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="favicon/apple-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="favicon/apple-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="favicon/apple-icon-180x180.png">
        <link rel="icon" type="image/png" sizes="192x192"  href="favicon/android-icon-192x192.png">
        <link rel="icon" type="image/png" sizes="32x32" href="favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="favicon/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="favicon/favicon-16x16.png">
        <link rel="manifest" href="/manifest.json">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="favicon/ms-icon-144x144.png">
        <meta name="theme-color" content="#ffffff">
        <meta charset="iso-8859-1">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Federaci&oacute; Catalana de Futbol Sala</title>
        <script src="https://use.fontawesome.com/93090f581b.js"></script>
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/foundation.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/foundation-icons.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/app.css">
        <link rel='stylesheet' id='ms-fonts'  href='https://fonts.googleapis.com/css?family=Open+Sans Condensed:700,300|Open+Sans:800' type='text/css' media='all' />
        <link rel='stylesheet' id='Open-Sans-Condensed-google-font-css'  href='https://fonts.googleapis.com/css?family=Open+Sans+Condensed%3A300%2C300italic%2C700&#038;subset=greek%2Ccyrillic-ext%2Ccyrillic%2Clatin%2Clatin-ext%2Cvietnamese%2Cgreek-ext&#038;ver=0fa92add012525b814a8dc2c48cfb26c' type='text/css' media='all' />
        <link rel='stylesheet' id='Open-Sans-google-font-css'  href='https://fonts.googleapis.com/css?family=Open+Sans%3A300%2C300italic%2Cregular%2Citalic%2C600%2C600italic%2C700%2C700italic%2C800%2C800italic&#038;subset=greek%2Ccyrillic-ext%2Ccyrillic%2Clatin%2Clatin-ext%2Cvietnamese%2Cgreek-ext&#038;ver=0fa92add012525b814a8dc2c48cfb26c' type='text/css' media='all' />

        <link rel="stylesheet" href="https://zurb.com/playground/projects/responsive-tables/responsive-tables.css">
    </head>
    <body>
        <div class="expanded row " id="logos">
            <div class="large-16 medium-16 colums">
                <div class="row collapse" >
                    <div id="address" class="large-4 medium-4 columns" style='background-color: transparent; '  ><strong>Federaci&oacute; Catalana de Futbol Sala</strong><br /> C/Guipuscoa 23-25 5e pis 08018 Barcelona 
                        <br />Tel. 93 244 44 03<br /> Fax 93 247 34 83</div>
                    <div id="logo" class="large-4 medium-4  columns" align="center" style='background-color: transparent;' >
                        <img width=150 src="<?php echo base_url(); ?>content/images/logos/logo_main_244.png" />
                    </div>
                    <div id="socialLogos" class="large-4 medium-4 columns" style='background-color: transparent; '  >
                        <ul>
                            <li><a href='https://www.facebook.com/futsalcat/' target='_blank'><i class="fi-social-facebook large"></i></a></li>
                            <li><a href='http://www.twitter.com/futsalcat' target='_blank'><i class="fi-social-twitter large"></i></a></li>
                            <li><a href='mailto:futsal@futsal.cat'><i class="fi-mail large"></i></a></li>
							 <li><a href='https://t.me/futsalcat'><i class="fi-comment large"></i></a></li>
							
							
							
                        </ul>

                    </div>
                </div>
                <div class="row">
                    <div class="title-bar" data-responsive-toggle="main-menu" data-hide-for="medium">
                        <button class="menu-icon" type="button" data-toggle></button>
                        <div class="title-bar-title">Menu</div>
                    </div>
                    <?php $this->load->view('templates/menu'); ?>
                </div>
            </div>
        </div>
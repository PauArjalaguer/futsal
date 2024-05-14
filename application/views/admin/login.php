<!doctype html>
<html class="no-js" lang="en" dir="ltr">
    <head>
        <meta charset="iso-8859-1">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Federaci&oacute; Catalana de Futbol Sala</title>
        <script src="https://use.fontawesome.com/93090f581b.js"></script>
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/foundation.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/foundation-icons.css">
        <link rel="stylesheet" href="<?php echo base_url();?>css/app.css">
        <link rel='stylesheet' id='ms-fonts'  href='//fonts.googleapis.com/css?family=Open+Sans Condensed:700,300|Open+Sans:800' type='text/css' media='all' />
        <link rel='stylesheet' id='Open-Sans-Condensed-google-font-css'  href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed%3A300%2C300italic%2C700&#038;subset=greek%2Ccyrillic-ext%2Ccyrillic%2Clatin%2Clatin-ext%2Cvietnamese%2Cgreek-ext&#038;ver=0fa92add012525b814a8dc2c48cfb26c' type='text/css' media='all' />
        <link rel='stylesheet' id='Open-Sans-google-font-css'  href='http://fonts.googleapis.com/css?family=Open+Sans%3A300%2C300italic%2Cregular%2Citalic%2C600%2C600italic%2C700%2C700italic%2C800%2C800italic&#038;subset=greek%2Ccyrillic-ext%2Ccyrillic%2Clatin%2Clatin-ext%2Cvietnamese%2Cgreek-ext&#038;ver=0fa92add012525b814a8dc2c48cfb26c' type='text/css' media='all' />
    </head>

    <body>
        <div class="row">
            <div class="large-12 medium-12 columns">
                <div class="row collapse" >
                    <?php echo validation_errors(); ?>
                    <?php $attr = array('class' => 'log-in-form');
                    echo form_open('admin/verifylogin', $attr);
                    ?>
                    <h4 class="text-center">Per entrar, introdueix el teu nom d'usuari i contrassenya.</h4>
                    <label>Email
                        <input type="text" name="username"  id="username" placeholder="somebody@example.com">
                    </label>
                    <label>Password
                        <input type="password" name="password" id="password" placeholder="Password">
                    </label>

                    <p><input type="submit" class="button expanded" value="Log in"></input></p>
                    <p class="text-center"><a href="#">Forgot your password?</a></p>
                
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
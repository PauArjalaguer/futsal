<div class='expanded row' id='footer'>
    <div class="row">
        <div class='small-12 medium-4 columns' style='height:100%;vertical-align:middle;'>
            <strong>Federaci&oacute; Catalana de Futbol Sala</strong><br /> C/Guipuscoa 23-25 5e pis 08018 Barcelona 
            <br />Tel. 93 244 44 03<br /> Fax 93 247 34 83
        </div>
        <div class="small-2 medium-1 columns" align='center'><a href='https://www.amfutsal.com.py/' target="_blank">  <img src="<?php echo base_url(); ?>content/images/logos/amf.png" width='100'></a></div>
        <div class="small-2 medium-1 columns" align='center'><a href='https://futsaleuropeanfederation.eu/' target="_blank">  <img src="<?php echo base_url(); ?>content/images/logos/fef.png" width='100'></a></div>
        <div class="small-2 medium-1 columns" align='center'><a href='https://gencat.cat/' target="_blank">  <img src="<?php echo base_url(); ?>content/images/logos/gencat.png" width='100'></a></div>
        <div class="small-2 medium-1 columns" align='center'> <a href='https://ufec.cat/' target="_blank"> <img src="<?php echo base_url(); ?>content/images/logos/ufec.png" width='100'></a></div>
        <div class='small-2 medium-4 columns' align='right'><img src="<?php echo base_url(); ?>content/images/logos/logo_main_244.png" width='100'></div>
    </div>
    <div>&nbsp;</div>
    <div class='row'>
        <div align='center'>
            &copy; Federació Catalana de Futbol Sala 2018 / <a href='<?php echo base_url(); ?>legal'>Avís legal </a>
        </div>
    </div>
</div>

<script src="<?php echo base_url(); ?>js/vendor/jquery.js"></script>
<script src="<?php echo base_url(); ?>js/vendor/what-input.js"></script>
<script src="<?php echo base_url(); ?>js/vendor/foundation.js"></script>
<script src="<?php echo base_url(); ?>js/app.js"></script>
<script src="https://cdn.rawgit.com/joequery/Stupid-Table-Plugin/master/stupidtable.min.js"></script>

<script src="https://zurb.com/playground/projects/responsive-tables/responsive-tables.js"></script>

<script>
    $(document).foundation();
    $(window).bind("load", function () {
        var footer = $("#footer");
        var pos = footer.position();
        var height = $(window).height();
        height = height - pos.top;
        height = height - footer.height();
        if (height > 0) {
            footer.css({
                'margin-top': height + 'px'
            });
        }
    });
    $(function () {
        $("#simpleTable").stupidtable();
    });
</script>

</body>
</html>


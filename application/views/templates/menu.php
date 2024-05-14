<div id="main-menu" >
    <ul class="vertical dropdown menu" data-dropdown-menu >
        <li><a href="<?php echo base_url(); ?>"><i style='font-size:19px; vertical-align: text-top;' class="fi-home"></i></a></li>
        <li><a <?php
            if ($this->uri->segment(1) == 'clubs') {
                echo "class=\"actiu\"";
            }
            ?> href="<?php echo base_url(); ?>clubs">Clubs</a></li>
        <li><a <?php
            if ($this->uri->segment(1) == 'competicio') {
                echo "class=\"actiu\"";
            }
            ?> href="<?php echo base_url(); ?>competicio">Competici&oacute;</a></li>
        <!--<li><a <?php
        if ($this->uri->segment(1) == 'junta') {
            echo "class=\"actiu\"";
        }
        ?> href="#">Junta</a></li>-->
        <li><a <?php
            if ($this->uri->segment(1) == 'noticies') {
                echo "class=\"actiu\"";
            }
            ?> href="<?php echo base_url(); ?>noticies">Not&iacute;cies</a></li>
        <li><a <?php
            if ($this->uri->segment(1) == 'documentacio' and !$this->uri->segment(2) == 'sancions') {
                echo "class=\"actiu\"";
            }
            ?>href="<?php echo base_url(); ?>documentacio">Documents</a></li>
        <li><a <?php
            if ($this->uri->segment(2) == 'sancions') {
                echo "class=\"actiu\"";
            }
            ?>href="<?php echo base_url(); ?>documentacio/sancions">Sancions</a></li>
       
        <li>
             <li><a <?php
            if ($this->uri->segment(1) == 'multimedia') {
                echo "class=\"actiu\"";
            }
            ?> href="<?php echo base_url(); ?>multimedia">Media</a></li>
        <li>
            <a href="http://futsal.playoffinformatica.net/">
                <i style='font-size:19px; vertical-align: text-top;' class="fi-lock">

                </i>
            </a>
        </li>
    </ul>
</div>
<section class="content-header">
    <h1><?php echo $title; ?>

    </h1>
    <ol class="breadcrumb">
        <li><?php echo "<a href='" . base_url() . "admin/index'>"; ?><i class="fa fa-dashboard"></i> Inici</a></li>
        <li><?php echo "<a href='" . base_url() . "admin/documents/nou'>"; ?>Documents</a></li>
        <li class="active"><?php echo $title; ?></li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12"> 
            <div class="box box-success">
                <div class="box-body">

                    <div  id="newsImageContainer" name="newsImageContainer" >
                        <label>Imatge</label><br />
                        <img height=200 id="newsImageContainerImage" src="<?php echo base_url(); ?>/images/dynamic/newsImages/<?php echo $pathImage; ?>" />
                           
                    </div>
                </div>
            </div>
        </div>
</section>
<script>
    CKEDITOR.replace('newsText', {toolbar: 'Basic'});
    $('#datepicker').datepicker({
        dateFormat: 'yy-mm-dd'
    }).val();
    var myDropzone3 = new Dropzone("div#myId", {
        url: "<?php echo base_url() . "admin/noticia/puja_imatge/$id"; ?>",
        dictDefaultMessage: "<span style='font-size:32px; color:#2a6496;'>\n\<i style='font-size:32px;' class=\"fa fa-cloud-upload fa-fw\"></i> Insertar foto de la notícia.",
        success: function (file, response) {
            //alert(file);
            document.getElementById('newsImage').value = response;

            document.getElementById("form").submit();
        }
    });

</script>
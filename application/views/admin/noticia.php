<section class="content-header">
    <h1><?php echo $title; ?>
        <?php
        /* $news = new News;
          if (isset($_GET['idNew'])) {
          $title = "Editar noticia";
          $news->idNew = $_GET['idNew'];
          $data = $news->newsGetById();
          } else {
          $title = "Nova not&iacute;cia";
          }
          echo $title; */
        // echo "<pre>";print_r(get_defined_vars()); echo "</pre>";
        ?>
    </h1>
    <ol class="breadcrumb">
        <li><?php echo "<a href='" . base_url() . "admin/index'>"; ?><i class="fa fa-dashboard"></i> Inici</a></li>
        <li><?php echo "<a href='" . base_url() . "admin/noticia/llista'>"; ?>Notícies</a></li>
        <li class="active"><?php echo $title; ?></li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12"> 
            <div class="box box-success">
                <div class="box-body">
                    <?php
                    $att = array('role' => 'form', 'id' => 'form');
                    echo form_open('admin/noticia/modifica/' . $id, $att);
                    ?>
                    <div class="col-lg-6">
                        <label>Títol</label>
                        <input name='newsTitle' class="form-control" value="<?php echo $title; ?>">
                    </div> 

                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Categor&iacute;a</label>
                            <select  id='newsCategory' name='newsCategory' class="form-control">
                                <?php
                                foreach ($get_news_categories as $cat) {
                                    if ($cat->id == $categoryId) {
                                        $s = "selected";
                                    } else {
                                        $s = "";
                                    }
                                    echo "\n\t\t\t\t\t\t<option $s value=\"" . $cat->id . "\">" . $cat->category . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>         

                    <div class="col-lg-12">
                        <?php
                        if (empty($pathImage)) {
                            $newsImageContainerDisplay = "none";
                            $newsLibraryContainerClass = "col-lg-12";
                            $newsUploaderContainer = "col-lg-12";
                        } else {
                            $newsImageContainerDisplay = "inline";
                            $newsImageContainerClass = "col-lg-2";
                            $newsLibraryContainerClass = "col-lg-7";
                            $newsUploaderContainer = "col-lg-3";
                        }
                        ?>
                        <div style='display:<?php echo $newsImageContainerDisplay; ?>;' id="newsImageContainer" name="newsImageContainer" >
                            <label>Imatge</label><br />
                            <img height=200 id="newsImageContainerImage" src="<?php echo base_url(); ?>/images/dynamic/newsImages/<?php echo $pathImage; ?>" />
                            <input type='hidden' name='newsImage' id='newsImage' value='<?php echo $pathImage; ?>' /><br />
                            <a href='<?php echo base_url(); ?>admin/noticia/elimina_imatge/<?php echo $id; ?>'>Elimina imatge</a>

                        </div>

                        <div style="display:<?php echo $newsUploaderContainer; ?>"  id="newsUploaderContainer">
                            <label>Pujar imatge</label>
                            <div id="imageUploader">
                                <div id="myId" class="dropzone"></div>
                            </div>

                        </div>
                    </div>
                    <div class='col-lg-12'>
                        <div class="form-group box">
                            <div class='box-header'>
                                <label>Text</label>
                                <textarea class="form-control" name="newsText" id="newsText" rows="20"><?php echo $content; ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class='col-lg-4'>
                        <input type="submit" class="btn btn-lg btn-info" ></input>
                        <?php echo form_close(); ?>
                        <?php
                        if ($draft == 1) {
                            echo "<a href=\"" . base_url() . "admin/noticia/publica/$id\"> <button type=\"button\" class=\"btn btn-lg btn-success\" >Publicar</button></a>";
                        } else {
                            echo "<a href=\"" . base_url() . "admin/noticia/esborrany/$id\"> <button type=\"button\" class=\"btn btn-lg btn-info\" >Esborrany</button></a>";
                        }
                        ?>
                        <a href="<?php echo base_url() . "admin/noticia/esborra/$id"; ?>"> <button type="button" class="btn btn-lg btn-danger" >Esborra</button></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>
<script>
    $(function () {
        $('#newsText').froalaEditor({
                    // Set the image upload parameter.
                    imageUploadParam: 'image_param',
                    // Set the image upload URL.
                    imageUploadURL: '<?php echo base_url() . "admin/noticia/froala_puja_imatge"; ?>',
                    // Additional upload params.
                  
                    // Set request type.
                    imageUploadMethod: 'POST',
                    // Set max image size to 5MB.
                    imageMaxSize: 5 * 1024 * 1024,
                    // Allow to upload PNG and JPG.
                    imageAllowedTypes: ['jpeg', 'jpg', 'png']
                })
                .on('froalaEditor.image.beforeUpload', function (e, editor, images) {
                    // Return false if you want to stop the image upload.
                })
                .on('froalaEditor.image.uploaded', function (e, editor, response) {
                    // Image was uploaded to the server.
                })
                .on('froalaEditor.image.inserted', function (e, editor, $img, response) {
                    // Image was inserted in the editor.
                })
                .on('froalaEditor.image.replaced', function (e, editor, $img, response) {
                    // Image was replaced in the editor.
                })
                .on('froalaEditor.image.error', function (e, editor, error, response) {
                    // Bad link.
                    if (error.code == 1) {}

                    // No link in upload response.
                    else if (error.code == 2) {}

                    // Error during image upload.
                    else if (error.code == 3) {}

                    // Parsing response failed.
                    else if (error.code == 4) {}

                    // Image too text-large.
                    else if (error.code == 5) {}

                    // Invalid image type.
                    else if (error.code == 6) {}

                    // Image can be uploaded only to same domain in IE 8 and IE 9.
                    else if (error.code == 7) {}

                    // Response contains the original server response to the request if available.
                });
    });
    // CKEDITOR.replace('newsText', {toolbar: 'Basic'});
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

        </aside>
    </div><!-- ./wrapper -->

    <!-- add new calendar event modal -->


</body>
</html>
<script>
    Dropzone.autoDiscover = false;

    Dropzone.options.myId = {
        maxFilesize: 100,
        init: function () {
            //this.on("drop", function(file) { alert("Dropped file."); });
            //this.on("success", function(file) { fillImageContainer(); });
        }
    };


    Dropzone.options.myId.addRemoveLinks = true;

    Dropzone.options.myId.dictDefaultMessage = "<span style='font-size:26px; color:#2a6496;'>\n\<i style='font-size:28px;' class=\"fa fa-cloud-upload fa-fw\"></i> Insertar arxiu per a pujar.";



</script>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <meta http-equiv="X-UA-Compatible" content="IE=8"/>
        <script>
            function script() {
                var text = document.getElementById('original').value;
                text = text.replace(/a/g, 'i');
                text = text.replace(/A/g, 'I');
                text = text.replace(/e/g, 'i');
                text = text.replace(/E/g, 'I');
                text = text.replace(/o/g, 'i');
                text = text.replace(/O/g, 'I');
                text = text.replace(/u/g, 'i');
                text = text.replace(/U/g, 'I');
                
                 text = text.replace(/à/g, 'i');
                text = text.replace(/À/g, 'I');
                text = text.replace(/è/g, 'i');
                text = text.replace(/È/g, 'I');
                text = text.replace(/ò/g, 'i');
                text = text.replace(/Ò/g, 'I');
                text = text.replace(/ù/g, 'i');
                text = text.replace(/Ù/g, 'I');
                
                 text = text.replace(/á/g, 'i');
                text = text.replace(/Á/g, 'I');
                text = text.replace(/é/g, 'i');
                text = text.replace(/É/g, 'I');
                text = text.replace(/ó/g, 'i');
                text = text.replace(/Ó/g, 'I');
                text = text.replace(/ú/g, 'i');
                text = text.replace(/Ú/g, 'I');
                document.getElementById('iriginil').innerHTML = text;
            }
        </script>
    </head>
    <body>
        <div>
            <textarea id='original' style='width:49%; height:300px;' onKeyUp='script()'></textarea>
            <textarea id='iriginil' style='width:49%; height:300px;'></textarea>
        </div>
    </body>
</html>
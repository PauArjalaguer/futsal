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
                
                 text = text.replace(/�/g, 'i');
                text = text.replace(/�/g, 'I');
                text = text.replace(/�/g, 'i');
                text = text.replace(/�/g, 'I');
                text = text.replace(/�/g, 'i');
                text = text.replace(/�/g, 'I');
                text = text.replace(/�/g, 'i');
                text = text.replace(/�/g, 'I');
                
                 text = text.replace(/�/g, 'i');
                text = text.replace(/�/g, 'I');
                text = text.replace(/�/g, 'i');
                text = text.replace(/�/g, 'I');
                text = text.replace(/�/g, 'i');
                text = text.replace(/�/g, 'I');
                text = text.replace(/�/g, 'i');
                text = text.replace(/�/g, 'I');
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
<?php
	if(isset($_GET['u'])){
		unlink($_GET['u']);
	}
  
      echo "<div id=\"menu_galeria\" align=center>";
      $directori = "newsImages/";
	  echo  "Tamany: ".disk_total_space ("/fcfs/newsImages");
      $dir = opendir($directori);
      while ($arxiu = readdir($dir)) {
          $tipus_arxiu = explode('.', $arxiu);
          if ($tipus_arxiu[1] == 'JPG' || $tipus_arxiu[1] == 'jpg' || $tipus_arxiu[1] == 'png' || $tipus_arxiu[1] == 'gif' || $tipus_arxiu[1] == 'bmp' || $tipus_arxiu[1] == 'tif') {
              if (!isset($array_imatges)) {
                  $array_imatges = array($arxiu);
              }
              else {
                  array_push($array_imatges, $arxiu);
              }
          }
      }
      if (!isset($_GET['o'])) {
          $o = 0;
      }
      $num_imatges = count($array_imatges);
      sort($array_imatges, SORT_STRING);
     for ($i = 0 + $o; $i < $num_imatges + $o; $i++) {
          if (isset($array_imatges[$i])) {
              $pb = $directori . "/" . $array_imatges[$i];
              //echo $pb;
              //redimensionar($pb);
              echo "<img class=\"imatge\" style=\"border:1px solid #000;\" src='$directori/$array_imatges[$i]' alt='$array_imatges[$i]";
               echo "' width=59 height=46  \"><br /><a href='?u=".$directori."".$array_imatges[$i]."'>Borrar</a><br />";
          }
      }
       echo "<div id=\"menu_galeria\" align=center>
<!--Scroll -->";
      echo "



<!--Imatge-->

</div>





<div align=center><img style=\"border:1px solid #000;\" id=\"imatge\" src='" . $directori . "/" . $array_imatges[$o] . "' width=600 border=0></div>







</div><div id=\"menu_galeria\" align=center>







<!--Menu galeria intern-->







<div align=center>Pag. ";
      
      
      
      
      
      
      
      for ($l = 0; $l < $num_imatges / 10; $l++) {
          $o = $l * 9;
          
          
          
          
          
          
          
          $li = $l + 1;
          
          
          
          
          
          
          
          echo "\n<a href='?s=imatges&dir=" . $_GET['dir'] . "&o=$o'>" . $li . "</a>,&nbsp";
      }
      
      
      
      
      
      
      
      echo "</div>  ";
  
?>





</div>
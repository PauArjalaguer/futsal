<div class="newHeader">
    <h1 id="sectionTitle"> <span style='color:#600;'>></span> Competicions</h1>
</div>
   <div class="newContainer">
<?
 $competition = new Competition;
 $data = $competition->getCompetitionsHistory();
 echo "<pre>";       
 //print_r($data);
 echo "</pre>";
        foreach ($data as $league) {
            if($season!=$league[3]){
                echo "\n</ul><h1 style='color:#232424;'>  Temporada ".$league[3]."</h1>";$a=0;}
            if($division!=$league[2]){
                
                if($a!=0){
                    echo "\n\t\t</ul>";
                }
                
                echo "\n\t<h2>Categoria ".$league[2]."</h2>\n\t\t<ul>"; }
            if($league[4]==1){
                $url= $serverUrl . "copa/" . $league[0] . "-" . str_replace(" ", "-", treuAccents($league[1]));
            }else{
                $url= $serverUrl . "divisio/" . $league[0]  . "-" . str_replace(" ", "-", treuAccents($league[1]));

            }
            echo "\n\t\t\t<li><a href='$url' style='font-size:16px;'>".$league[1]."</a></li>";
            //echo "&nbsp;<span style='color:#600;'>></span> <a href='$url' style='font-size:16px;'>".$league[1]."</a><br />";
            $season=$league[3];
            $division = $league[2];
            $a++;
        }
        ?>
   </div>
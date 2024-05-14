<?php
/*echo "<pre>";
print_r(get_defined_vars());
echo "</pre>";*/
foreach ($dni_search as $row):
    echo "<tr >";
    echo "<td class='pointer'><a href='".base_url()."admin/jugador/activa/".$row->id."/$idTeam'>" . utf8_decode($row->name) . "</a></td>";
    echo "</tr>";
endforeach;
?>  

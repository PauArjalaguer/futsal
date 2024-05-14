<?
include("../../Classes/db.inc");
include("../../Classes/cPanel_Class.php");
include("../../Classes/Competition_Class.php");
?>     
<div class="box">
    <div class="box-header">
        <h3 class="box-title">Usuaris</h3>
    </div><!-- /.box-header -->
    <div class="box-body table-responsive">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Nom</th>
                    <th>Categoria</th>
                   
                    <th>Rol</th>
                    <th >Accions</th>
                     <th >Accions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $user = new cPanel();
                $data = $user->cPanelGetAllUsers();
                foreach ($data as $user) {
                 
                    echo "\n\t<tr id='newsTr_" . $user[0] . "'>\n\t\t<td>" . $user[0] . "</td>";
                    echo "\n\t\t<td>" . utf8_encode($user[1]) . "</td>";
                    echo "\n\t\t<td>" . utf8_encode($user[5]) . "</td>";
                    echo "\n\t\t<td>" . $user[2] . "</td>";
                    
                    echo "\n\t\t<td align=center><i class=\"fa  fa-edit\" style='cursor:pointer' onClick='cPanelUserEdit(" . $user[0] . ");'></i></td>\n\t<td  align=center><i style='cursor:pointer' class=\"fa  fa-trash-o\" onClick='cPanelUserDelete(" . $user[0] . ");'></i></td></tr>";
                }
                ?>  
            </tbody>
    </div>
</div>


<?
include("../../Classes/db.inc");
include("../../Classes/Competition_Class.php");
include("../../Classes/Clubs_Class.php");
$competition = new Competition();
$clubs = new Clubs();
$clubs->idClub = $_COOKIE['idClub'];
$competition->idMatch = $_GET['idMatch'];
$competition->idClub = $_COOKIE['idClub'];

$data = $competition->cmptMatchDateInfo();
$idComplex=$data[8];
$da=explode(" ",$data[1]);
$d=explode("-",$da[0]);
$date=$d[2]."-".$d[1]."-".$d[0];
$time=substr($da[1],0,5);
?>
<section class="content-header" >
    <h1 >&nbsp;</h1>

    <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-dashboard"></i> Inici</a></li>
        <li><a href="#" onClick='cmptMatchListByIdClub()'>Partits</a></li>
        <li><a href="#" onClick='cmptMatchDateChange(<? echo $_GET['idMatch']; ?>)'><? echo utf8_encode($data[2]) . " - " . utf8_encode($data[3]); ?></a></li>
    </ol></section>
<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border" >
            <h3 class="box-title"><? echo utf8_encode($data[2]) . " - " . utf8_encode($data[3]); ?></h3>
        </div><!-- /.box-header -->
        <div class="box-body">
            <form role="form">
                <div class="box-body">
                    <div class="form-group">
                        
                        <div class="col-xs-3">
                             <input  type="text" class="form-control" id="matchDate" placeholder="Introdueix la data dd-mm-aaaa" value=<? echo $date; ?>>
                        </div>
                        <div class="col-xs-3">
                             <input type="text" class="form-control" name="matchTime" id="matchTime" placeholder="Introdueix la hora hh:mm"  value=<? echo $time; ?>>
                        </div>
                        <div class="col-xs-3"><select id="matchComplex"><option>__</option>
                                <?
                                $data = $clubs->clubComplex();
                                foreach($data as $complex){
                                    if($complex[0]==$idComplex){
                                        $sel="selected";
                                    }else{
                                        $sel="";
                                    }
                                    echo "<option $sel value=\"".$complex[0]."\">".utf8_encode($complex[1])."</option>";
                                }
                                ?>
                            
                            </select>
                        </div>
                   </div>
                </div>
                <div class="box-footer">
                    <button type="button" class="btn btn-success" onClick="cmptMatchDateUpdate(<? echo $_GET['idMatch']; ?> )">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</section><?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


<span style="font-weight: bold; font-size: 14px; color:#242424;">Rebutjar fitxa</span>
<? //print_r($_GET); ?>
<textarea id="rejectionReason" style="height: 400px; width: 400px;"></textarea>
<input type='button' onClick='playerCardMarkAsRejectedSave(<? echo $_GET['idPlayer'].",".$_GET['idTeam']; ?>)' class='newPlayerNameButton' value='Enviar' />
<input type='button' onClick='playerCardEdit(<? echo $_GET['idPlayer'].",".$_GET['idTeam']; ?>)' class='newPlayerNameButton' value='Cancelar' />
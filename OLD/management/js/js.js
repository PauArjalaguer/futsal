function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

/* cPanel */
function cPanelGetAllUsers() {
    $("#page-container").html('<img src="images/ajax-loader.gif" />');
    $.ajax({
        url: "php/cPanel/cPanelGetAllUsers.php",
        cache: false
    })
            .done(function (html) {
                $("#page-container").html(html);
                $('#example1').dataTable({
                    "bPaginate": true,
                    "bLengthChange": false,
                    "bFilter": true,
                    "bSort": true,
                    "bInfo": false,
                    "bAutoWidth": true
                });

            });

}

function cPanelUserEdit(idUser) {
    $("#page-container").html('<img src="images/ajax-loader.gif" />');
    $.ajax({
        url: "php/cPanel/cPanelUserEditor.php?idUser=" + idUser,
        cache: false
    })
            .done(function (html) {
                $("#page-container").html(html);
                var myDropzone = new Dropzone("div#myId", {
                    url: "php/cPanel/cPanelUserAvatarUploader.php",
                    success: function (file, response) {
                        document.getElementById("userAvatarContainer").style.display = "block";
                        // document.getElementById("userAvatarImage").src="../users/avatars/thumbs/"+response;
                        document.getElementById("userAvatarImage").style.backgroundImage = "url(../users/avatars/thumbs/" + response + ")";
                        document.getElementById("userAvatarInput").value = response;
                        document.getElementById("imageUploaderContainer").className = "col-lg-3";

                    }
                });

            });

}
function cPanelUserPermissionsUpdate(idUser, idSection) {
    //alert(document.getElementById("userPermissionsRadio_"+idSection).checked);
    if (document.getElementById("userPermissionsRadio_" + idSection).checked) {
        var action = "insert";
    } else {
        var action = "delete";
    }
    $.ajax({
        url: "php/cPanel/cPanelUserPermissionsUpdate.php?idUser=" + idUser + "&idSection=" + idSection + "&action=" + action,
        cache: false
    })
            .done(function (html) {

            });
}


/* NEWS */

/* Obre panell d'edicio */
function newsGetAllNews() {
    $("#page-container").html('<img src="images/ajax-loader.gif" />');
    $.ajax({
        url: "php/news/newsGetAllNews.php",
        cache: false
    })
            .done(function (html) {
                $("#page-container").html(html);

            });

}
/* Nova noticia */
function newsNew() {
    $("#page-container").html('<img src="images/ajax-loader.gif" />');
    $.ajax({
        url: "php/news/newsEditor.php",
        cache: false
    })
            .done(function (html) {
                $("#page-container").html(html);
                // $("#newsText").wysihtml5();
                CKEDITOR.replace('newsText');
                $('#datepicker').datepicker({
                    dateFormat: 'yy-mm-dd'
                }).val();
                var myDropzone = new Dropzone("div#myId", {
                    url: "php/news/fileUploader.php",
                    success: function (file, response) {
                        fillImageContainer();

                    }
                });
                fillImageContainer();

            });

}
/*Editar noticies*/
function newsEdit(idNew) {
    $("#page-container").html('<img src="images/ajax-loader.gif" />');
    $.ajax({
        url: "php/news/newsEditor.php?idNew=" + idNew,
        cache: false
    })
            .done(function (html) {
                $("#page-container").html(html);
                CKEDITOR.replace('newsText');
                $('#datepicker').datepicker({
                    dateFormat: 'yy-mm-dd'
                }).val();
                var myDropzone = new Dropzone("div#myId", {
                    url: "php/news/fileUploader.php",
                    success: function (file, response) {
                        fillImageContainer();

                    }
                });
                fillImageContainer();

            });

}
/* Obre imatges disponibles per a la not�cia */
function fillImageContainer() {
    $("#imageContainer").html('<img src="images/ajax-loader.gif" />');
    $.ajax({
        url: "php/news/newsImageContainer.php",
        cache: false
    })
            .done(function (html) {
                $("#imageContainer").html(html);



            });
}
/* Asigna imatge a una noticia */
function newsImageNewAssign(image) {
    document.getElementById("newsImageAssigned").value = image;
    document.getElementById("newsImageContainerImage").src = "../newsImages/thumbs/" + image;
    document.getElementById("newsImageContainer").style.display = "block";
    document.getElementById("newsImageContainer").className = "col-lg-2";
    document.getElementById("newsLibraryContainer").className = "col-lg-7";
    document.getElementById("newsUploaderContainer").className = "col-lg-3";

}
/* Buscar jornades en una lliga seleccionada i assigna a select de jornades */
function newsMatchSearchSelectLeague() {
    var select = document.getElementById("newsMatchSearchLeagueSelect");
    var select_index = select.selectedIndex;
    var select_value = select.options[select_index].value;
    //alert(select_value);

    $.ajax({
        url: "php/news/newsMatchSearchSelectLeague.php?idLeague=" + select_value,
        cache: false
    })
            .done(function (html) {
                $("#newsMatchSearchRoundContainer").html(html);



            });

}
/*Busca partits de la jornada seleccionada i assigna a select de partits */
function newsMatchSearchSelectRound() {
    var select = document.getElementById("newsMatchSearchRoundSelect");
    var select_index = select.selectedIndex;
    var select_value = select.options[select_index].value;
    //alert(select_value);

    $.ajax({
        url: "php/news/newsMatchSearchSelectRound.php?idRound=" + select_value,
        cache: false
    })
            .done(function (html) {
                $("#newsMatchSearchMatchContainer").html(html);



            });
}
/* Buscar partits per equips i els assigna a select de partits */
function newsMatchSearch() {
    var search = document.getElementById("newsMatchSearchInput").value;

    //alert(select_value);

    $.ajax({
        url: "php/news/newsMatchSearchSelectRound.php?search=" + search,
        cache: false
    })
            .done(function (html) {
                $("#newsMatchSearchMatchContainer").html(html);



            });
}

/* assigna partits del select de partits a input hidden de partits */
function newsMatchSearchSelectMatch() {
    var select = document.getElementById("newsMatchSearchMatchSelect");
    var select_index = select.selectedIndex;
    var select_value = select.options[select_index].value;
    //alert(select_value);

    document.getElementById("newsMatchSearchMatchSelected").value = select_value;

}

/* desa noticia */
function newsSave(idNew, returnToEdit) {

    var newsTitle = document.getElementById("newsTitle").value;
    var newsText = encodeURIComponent(CKEDITOR.instances.newsText.getData());
//alert(CKEDITOR.instances.newsText.getData());
    var select = document.getElementById("newsCategory");
    var select_index = select.selectedIndex;
    var newsCategory = select.options[select_index].value;

    var newsImage = document.getElementById("newsImageAssigned").value;
    var newsMatch = document.getElementById("newsMatchSearchMatchSelected").value;
    var newsExpirationDate = document.getElementById("datepicker").value;
    var dataString = "idNew=" + idNew + "&newsTitle=" + newsTitle + "&newsText=" + newsText + "&newsCategory=" + newsCategory + "&newsImage=" + newsImage + "&newsMatch=" + newsMatch + "&newsExpirationDate=" + newsExpirationDate;
    //var dataString="id:"+idNew;
    //alert(dataString);
    $.ajax({
        type: "POST",
        url: "php/news/newsSave.php",
        data: dataString,
        cache: false,
        contentType: "application/x-www-form-urlencoded;charset=utf-8",
        success: function (result) {
            //alert(result);
            idNew = result;
        }
    });

    if (returnToEdit == true) {
        newsEdit(idNew);
    } else {
        newsGetAllNews();
    }

}
/* Esborra noticia */
function newsDelete(idNew) {

    $.ajax({
        url: "php/news/newsDelete.php?idNew=" + idNew,
        cache: false
    })
            .done(function (html) {
                // $( "#newsMatchSearchMatchContainer" ).html( html );
                $("#newsTr_" + idNew).children('td, th').css('background-color', '#c00');
                $("#newsTr_" + idNew).hide(1000);
            });
}

/*___________________________________________________________________________________*/
/*________________________________ARXIUS_____________________________________________/*
 * 
 */
/* TOTS ELS ARXIUS */
function filesGetAllFiles() {
    $("#page-container").html('<img src="images/ajax-loader.gif" />');
    $.ajax({
        url: "php/files/filesGetAllFiles.php",
        cache: false
    })
            .done(function (html) {
                $("#page-container").html(html);

            });

}
/* Nou arxiu */
function filesNew() {
    $("#page-container").html('<img src="images/ajax-loader.gif" />');
    $.ajax({
        url: "php/files/fileUploaderForm.php",
        cache: false
    })
            .done(function (html) {
                $("#page-container").html(html);

                var myDropzone = new Dropzone("div#myId", {
                    url: "php/files/fileUploader.php",
                    success: function (file, response) {
                        fileEdit(response);
                    }
                });
                //fillImageContainer();

            });

}
/*Editar arxius*/
function fileEdit(idFile) {
    $("#page-container").html('<img src="images/ajax-loader.gif" />');
    $.ajax({
        url: "php/files/fileEditor.php?idFile=" + idFile,
        cache: false
    })
            .done(function (html) {
                $("#page-container").html(html);




            });

}
function fileSave(idFile, returnToEdit) {

    var fileTitle = document.getElementById("fileTitle").value;

    var select = document.getElementById("fileCategory");
    var select_index = select.selectedIndex;
    var fileCategory = select.options[select_index].value;

    var dataString = "idFile=" + idFile + "&fileTitle=" + fileTitle + "&fileCategory=" + fileCategory;
    $.ajax({
        type: "POST",
        url: "php/files/fileSave.php",
        data: dataString,
        cache: false,
        success: function (result) {
            idFile = result;
            //alert(result);
        }
    });

    if (returnToEdit == true) {
        fileEdit(idFile);
    } else {
        filesGetAllFiles();
    }

}
function fileSave(idFile, returnToEdit) {

    var fileTitle = document.getElementById("fileTitle").value;

    var select = document.getElementById("fileCategory");
    var select_index = select.selectedIndex;
    var fileCategory = select.options[select_index].value;

    var dataString = "idFile=" + idFile + "&fileTitle=" + fileTitle + "&fileCategory=" + fileCategory;
    $.ajax({
        type: "POST",
        url: "php/files/fileSave.php",
        data: dataString,
        cache: false,
        success: function (result) {
            idFile = result;
            //alert(result);
        }
    });

    if (returnToEdit == true) {
        fileEdit(idFile);
    } else {
        filesGetAllFiles();
    }

}
function fileDelete(idFile) {

    $.ajax({
        url: "php/files/fileDelete.php?idFile=" + idFile,
        cache: false
    })
            .done(function (html) {
                // $( "#newsMatchSearchMatchContainer" ).html( html );
                $("#newsTr_" + idFile).children('td, th').css('background-color', '#c00');
                $("#newsTr_" + idFile).hide(1000);
            });
}
/**********GESTIÓ DE CLUBS ***************/


function clubsGetList() {
    $("#page-container").html('<img src="images/ajax-loader.gif" />');

    $.ajax({
        url: "php/clubs/clubsGetList.php",
        cache: false
    })
            .done(function (html) {
                $("#page-container").html(html);
                $("#example1").DataTable({"oLanguage": {"sEmptyTable": "No hi ha registres", "sInfo": "Hi ha _TOTAL_ registres. Mostrant de (_START_ a _END_)", "sLoadingRecords": "Per favor espera - Carregant...", "sSearch": "Filtre:", "sLengthMenu": "Mostrar _MENU_", "oPaginate": {"sLast": "Última pàgina", "sFirst": "Primera", "sNext": "Següent", "sPrevious": "Anterior"}}});

            });
    var idClub = getCookie("idClub");
    if (idClub >= 1) {
        clubsEdit(idClub, '1');
    }

}
/* Nova noticia */
function clubsNew() {
    $("#page-container").html('<img src="images/ajax-loader.gif" />');
    $.ajax({
        url: "php/clubs/clubsEditor.php",
        cache: false
    })
            .done(function (html) {
                $("#page-container").html(html);
                CKEDITOR.replace('clubText');

                var myDropzone = new Dropzone("div#myId", {
                    url: "php/clubs/clubsFileUploader.php",
                    success: function (file, response) {
                        document.getElementById("clubImage").value = response;
                        //fillImageContainer();

                    }
                });
                //illImageContainer();

            });

}

/*Editar noticies*/
function clubsEdit(idClub, tab) {
    $("#page-container").html('<img src="images/ajax-loader.gif" />');
    $.ajax({
        url: "php/clubs/clubsEditor.php?idClub=" + idClub,
        cache: false
    })
            .done(function (html) {
                $("#page-container").html(html);

                var editor = CKEDITOR.instances['clubText'];
                if (editor) {
                    editor.destroy(true);
                }
                CKEDITOR.replace('clubText');

                if (tab) {
                    $('a[href="#' + tab + '"]').tab('show')
                }


                var myDropzone = new Dropzone("div#myId", {
                    url: "php/clubs/clubsFileUploader.php",
                    success: function (file, response) {
                        document.getElementById("clubImage").value = response;

                        //fillImageContainer();

                    }
                });


            });

}

function clubsSave(idClub, returnToEdit) {

    var clubName = document.getElementById("clubName").value;
    var clubAddress = document.getElementById("clubAddress").value;
    var clubPhone1 = document.getElementById("clubPhone1").value;
    var clubPhone2 = document.getElementById("clubPhone2").value;
    var clubText = document.getElementById("clubText").value;
    var clubImage = document.getElementById("clubImage").value;
    var clubEmail = document.getElementById("clubEmail").value;
    var clubCity = document.getElementById("clubCity").value;
    var clubFacebook = document.getElementById("clubFacebook").value;
    var clubTwitter = document.getElementById("clubTwitter").value;
    var clubWeb = document.getElementById("clubWeb").value;
    var clubCode = document.getElementById("clubCode").value;
    var clubText = encodeURIComponent(CKEDITOR.instances.clubText.getData());
    var dataString = "idClub=" + idClub + "&clubName=" + clubName + "&clubAddress=" + clubAddress + "&clubPhone1=" + clubPhone1 +
            "&clubPhone2=" + clubPhone2 + "&clubText=" + clubText + "&clubCity=" + clubCity + "&clubImage=" + clubImage + "&clubEmail=" + clubEmail + "&clubFacebook=" + clubFacebook + "&clubTwitter=" + clubTwitter + "&clubWeb=" + clubWeb + "&clubCode=" + clubCode;
    //var dataString="id:"+idNew;
    //alert(dataString);
    $.ajax({
        type: "POST",
        url: "php/clubs/clubsSave.php",
        data: dataString,
        cache: false,
        success: function (result) {
            //alert(result);
            idClub = result;
            //clubsEdit(idClub, 'clubTeamsContainer');
            if (returnToEdit == true) {
                //clubsEdit(idClub);
                clubsEdit(idClub, 'clubTeamsContainer');
            } else {
                clubsGetList();
            }
        }
    });



}

function clubsTeamNewInsert(idClub) {

    var clubTeamName = document.getElementById("clubsNewTeamInput").value;
    // alert(clubTeamName);
    var dataString = "idClub=" + idClub + "&clubTeamName=" + clubTeamName;
    //var dataString="id:"+idNew;
    $.ajax({
        type: "POST",
        url: "php/clubs/clubsTeamNewInsert.php",
        data: dataString,
        cache: false,
        success: function (result) {
            //alert(result);
            //clubsTeamEdit(result);
            clubsEdit(idClub, 'clubTeamsContainer');
        }
    });



}

function clubsTransferPlayer(idPlayer) {

    var select = document.getElementById("clubsTeamTransferSelector_" + idPlayer);
    var select_index = select.selectedIndex;
    var select_value = select.options[select_index].value;

    var rate = document.getElementById("clubsTeamTransferSelectorPrice_" + idPlayer).value;
    // alert(idPlayer + " " + keepPrice);

    $.ajax({
        type: "GET",
        url: "php/clubs/clubsTransferPlayer.php?idPlayer=" + idPlayer + "&rate=" + rate + "&idTeam=" + select_value,
        cache: false,
        success: function (result) {
            //alert(result);
            //clubsTeamEdit(result);
            //clubsEdit(idClub, 'clubTeamsContainer');
        }
    });
}

function clubTeamsGetList() {
    $("#page-container").html('<img src="images/ajax-loader.gif" />');
    $.ajax({
        url: "php/clubs/clubTeamsGetList.php",
        cache: false
    })
            .done(function (html) {
                $("#page-container").html(html);
            });


}
function clubPlayersGetListByTeamId(id) {
    $("#page-container").html('<img src="images/ajax-loader.gif" />');
    $.ajax({
        url: "php/clubs/clubPlayersGetListByTeamId.php?idTeam=" + id,
        cache: false
    })
            .done(function (html) {
                $("#page-container").html(html);
                $("#newPlayersTable").DataTable({"oLanguage": {"sEmptyTable": "No hi ha registres", "sInfo": "Hi ha _TOTAL_ registres. Mostrant de (_START_ a _END_)", "sLoadingRecords": "Per favor espera - Carregant...", "sSearch": "Filtre:", "sLengthMenu": "Mostrar _MENU_", "oPaginate": {"sLast": "Última pàgina", "sFirst": "Primera", "sNext": "Següent", "sPrevious": "Anterior"}}});
                $("#oldPlayersTable").DataTable({"oLanguage": {"sEmptyTable": "No hi ha registres", "sInfo": "Hi ha _TOTAL_ registres. Mostrant de (_START_ a _END_)", "sLoadingRecords": "Per favor espera - Carregant...", "sSearch": "Filtre:", "sLengthMenu": "Mostrar _MENU_", "oPaginate": {"sLast": "Última pàgina", "sFirst": "Primera", "sNext": "Següent", "sPrevious": "Anterior"}}});
                var myDropzone = new Dropzone("div#myId", {
                    url: "php/clubs/clubTeamEditPhotoUploader.php?idTeam=" + id,
                    success: function (file, response) {
                        clubPlayersGetListByTeamId(id);

                    }
                });
            });


}
function clubTeamEditImageDelete(idTeam) {
    if (confirm('Segur que vols eliminar la imatge?')) {
        clubTeamEditImageDeleteConfirm(idTeam);
    } else {
        // Do nothing!
    }
}
function clubTeamEditImageDeleteConfirm(idTeam) {
    //$("#page-container").html('<img src="images/ajax-loader.gif" />');
    $.ajax({
        url: "php/clubs/clubTeamImageDelete.php?idTeam=" + idTeam,
        cache: false
    })
            .done(function (html) {
                clubPlayersGetListByTeamId(idTeam);
            });


}
function clubPlayerActivateOldLicense(idPlayer, idTeam) {
    $("#page-container").html('<img src="images/ajax-loader.gif" />');
    $.ajax({
        url: "php/clubs/clubPlayerActivateOldLicense.php?idPlayer=" + idPlayer + "&idTeam=" + idTeam,
        cache: false
    })
            .done(function (html) {

                clubPlayerEdit(idPlayer);
            });


}

function clubTeamEditSearchPlayerByDni(idTeam) {
    var playerDNItoSearch = $("#playerDNItoSearch").val();
    //$("#page-container").html('<img src="images/ajax-loader.gif" />');
    //alert(playerDNItoSearch);
    $.ajax({
        url: "php/clubs/clubTeamEditSearchPlayerByDni.php?dni=" + playerDNItoSearch + "&idTeam=" + idTeam,
        cache: false
    })
            .done(function (html) {
                $("#clubTeamEditSearchPlayerByDniTable").html(html);
                //clubPlayerEdit(idPlayer);
            });


}


function clubPlayerEdit(idPlayer) {
    $("#page-container").html('<img src="images/ajax-loader.gif" />');
    $.ajax({
        url: "php/clubs/clubPlayerEdit.php?idPlayer=" + idPlayer,
        cache: false
    })
            .done(function (html) {


                $("#page-container").html(html);
                var myDropzone = new Dropzone("div#myId", {
                    url: "php/clubs/clubPlayerEditPhotoUploader.php?idPlayer=" + idPlayer,
                    success: function (file, response) {
                        clubPlayerEdit(idPlayer);

                    }
                });
                var myDropzone2 = new Dropzone("div#myId2", {
                    url: "php/clubs/clubPlayerEditDocumentUploader.php?type=DNI&idPlayer=" + idPlayer,
                    dictDefaultMessage: "<span style='font-size:26px; color:#2a6496;'>\n\<i style='font-size:28px;' class=\"fa fa-cloud-upload fa-fw\"></i> Insertar arxiu per a pujar.",
                    success: function (file, response) {
                        clubPlayerEdit(idPlayer);
                    }
                });
                var myDropzone3 = new Dropzone("div#myId3", {
                    url: "php/clubs/clubPlayerEditDocumentUploader.php?type=insurance&idPlayer=" + idPlayer,
                    dictDefaultMessage: "<span style='font-size:26px; color:#2a6496;'>\n\<i style='font-size:28px;' class=\"fa fa-cloud-upload fa-fw\"></i> Insertar arxiu per a pujar.",
                    success: function (file, response) {
                        clubPlayerEdit(idPlayer);
                    }
                });


            });


}
function clubPlayerEditImageRotate(idPlayer) {
    //$("#page-container").html('<img src="images/ajax-loader.gif" />');
    $.ajax({
        url: "php/clubs/clubPlayerImageRotate.php?idPlayer=" + idPlayer,
        cache: false
    })
            .done(function (html) {
                clubPlayerEdit(idPlayer);
            });


}
function clubPlayerEditImageDelete(idPlayer) {
    if (confirm('Segur que vols eliminar la imatge?')) {
        clubPlayerEditImageDeleteConfirm(idPlayer);
    } else {
        // Do nothing!
    }
}
function clubPlayerEditImageDeleteConfirm(idPlayer) {
    //$("#page-container").html('<img src="images/ajax-loader.gif" />');
    $.ajax({
        url: "php/clubs/clubPlayerEditImageDelete.php?idPlayer=" + idPlayer,
        cache: false
    })
            .done(function (html) {
                clubPlayerEdit(idPlayer);
            });


}
function clubPlayerEditDocumentDelete(idPlayer, type) {
    if (confirm('Segur que vols eliminar la imatge?')) {
        clubPlayerEditDocumentDeleteConfirm(idPlayer, type);
    } else {
        // Do nothing!
    }
}
function clubPlayerEditDocumentDeleteConfirm(idPlayer, type) {
    //$("#page-container").html('<img src="images/ajax-loader.gif" />');
    $.ajax({
        url: "php/clubs/clubPlayerEditDocumentDelete.php?idPlayer=" + idPlayer + "&type=" + type,
        cache: false
    })
            .done(function (html) {
                clubPlayerEdit(idPlayer);
            });


}

function clubPlayerEditSave(idPlayer, returnToEdit, idTeam) {

    var playerName = document.getElementById("playerName").value;

//alert(CKEDITOR.instances.newsText.getData());
    var select = document.getElementById("playerPosition");
    var select_index = select.selectedIndex;
    var playerCategory = select.options[select_index].value;

    var playerSurname = document.getElementById("playerSurname").value;
    var playerBirthDate = document.getElementById("playerBirthDate").value;
    var playerBirthCountry = document.getElementById("playerBirthCountry").value;

    var playerBirthProvince = document.getElementById("playerBirthProvince").value;
    var playerDNI = document.getElementById("playerDNI").value;
    var playerNIF = document.getElementById("playerNIF").value;

    var playerStreet = document.getElementById("playerStreet").value;
    var playerStreetNumber = document.getElementById("playerStreetNumber").value;
    var playerFloor = document.getElementById("playerFloor").value;

    var playerDoor = document.getElementById("playerDoor").value;
    var playerCP = document.getElementById("playerCP").value;
    var playerCity = document.getElementById("playerCity").value;
    var playerProvince = document.getElementById("playerProvince").value;
    var playerNotes = document.getElementById("playerNotes").value;



    var dataString = "playerName=" + playerName + "&playerCategory=" + playerCategory + "&playerSurname=" + playerSurname + "&playerBirthDate=" + playerBirthDate + "&playerBirthCountry=" + playerBirthCountry + "&playerBirthProvince=" + playerBirthProvince
            + "&playerDNI=" + playerDNI + "&playerNIF=" + playerNIF + "&playerStreet=" + playerStreet + "&playerStreetNumber=" + playerStreetNumber + "&playerFloor=" + playerFloor + "&playerDoor=" + playerDoor
            + "&playerCP=" + playerCP + "&playerCity=" + playerCity + "&playerProvince=" + playerProvince + "&playerNotes=" + playerNotes + "&idPlayer=" + idPlayer;
    //var dataString="id:"+idNew;
    //alert(dataString);
    $.ajax({
        type: "POST",
        url: "php/clubs/clubPlayerEditSave.php",
        data: dataString,
        cache: false,
        contentType: "application/x-www-form-urlencoded;charset=utf-8",
        success: function (result) {
            //alert(result);

        }
    });

    if (returnToEdit == true) {
        clubPlayerEdit(idPlayer);
    } else {
        clubPlayersGetListByTeamId(idTeam);
    }

}
function clubPlayersInsert() {

    var idTeam = document.getElementById("idTeam").value;
    var playerName = document.getElementById("playerName").value;
    var dataString = "playerName=" + playerName + "&idTeam=" + idTeam;
    //alert(idTeam);
    //var dataString="id:"+idNew;
    //alert(dataString);
    $.ajax({
        type: "POST",
        url: "php/clubs/clubPlayersInsert.php",
        data: dataString,
        cache: false,
        contentType: "application/x-www-form-urlencoded;charset=utf-8",
        success: function (result) {

            idPlayer = result;
            clubPlayerEdit(idPlayer);
        }
    });
}

function clubPlayerEditDelete(idPlayer, status, idTeam) {
    if (confirm('Segur que vols eliminar la fitxa?')) {
        clubPlayerEditDeleteConfirm(idPlayer, idTeam);
    } else {
        // Do nothing!
    }
}

function clubPlayerEditDeleteConfirm(idPlayer, idTeam) {
    var dataString = "idPlayer=" + idPlayer;
    $.ajax({
        type: "POST",
        url: "php/clubs/clubPlayerEditDelete.php",
        data: dataString,
        cache: false,
        contentType: "application/x-www-form-urlencoded;charset=utf-8",
        success: function (result) {
            clubPlayersGetListByTeamId(idTeam);
        }
    });
}

function clubReceipts() {
    $("#page-container").html('<img src="images/ajax-loader.gif" />');
    $.ajax({
        url: "php/clubs/clubReceipts.php",
        cache: false
    })
            .done(function (html) {
                $("#page-container").html(html);
            });
}
/*___________________________________________________________________________________*/
/*________________________________ARBITRES_____________________________________________/*
 * 
 */
/* TOTS ELS ARXIUS */
function rfrRefereeMatchesList() {
    $("#page-container").html('<img src="images/ajax-loader.gif" />');
    $.ajax({
        url: "php/referees/rfrRefereeMatchesList.php",
        cache: false
    })
            .done(function (html) {
                $("#page-container").html(html);
            });


}
function rfrRefereeMatchResult(idMatch) {
    $("#page-container").html('<img src="images/ajax-loader.gif" />');
    $.ajax({
        url: "php/referees/rfrRefereeMatchResult.php?idMatch=" + idMatch,
        cache: false
    })
            .done(function (html) {
                $("#page-container").html(html);
                /* var myDropzone = new Dropzone("div#myId", {
                 url: "php/referees/rfrRefereeMinuteUploader.php?idMatch="+idMatch,
                 success: function (file, response) {
                 
                 
                 }
                 });*/
            });


}

function rfrRefereeMatchResultInsert(idMatch) {
    var localResult = $("#rfrMatchLocalResult").val();
    var visitorResult = $("#rfrMatchVisitorResult").val();
    var prevLocalResult = $("#rfrMatchPrevLocalResult").val();
    var prevVisitorResult = $("#rfrMatchPrevVisitorResult").val();

    var idLocal = $("#idLocal").val();
    var idVisitor = $("#idVisitor").val();



    if (localResult != 'undefined' & visitorResult != 'undefined' & localResult != '' & visitorResult != '') {
        //alert(localResult + " " + visitorResult);
        $.ajax({
            url: "php/referees/rfrRefereeMatchResultInsert.php?idMatch=" + idMatch + "&localResult=" + localResult + "&visitorResult=" + visitorResult + "&prevLocalResult=" + prevLocalResult + "&prevVisitorResult=" + prevVisitorResult + "&idLocal=" + idLocal + "&idVisitor=" + idVisitor,
            cache: false
        })
                .done(function (html) {
                    setTimeout(rfrRefereeMatchResult(idMatch), 5000);
                });
    }
}

function rfrRefereesGoalPlayerUpdate(idMatch, idGoal) {
    var select = document.getElementById("rfrRefereesGoalPlayer_" + idMatch + "_" + idGoal);
    var select_index = select.selectedIndex;
    var select_value = select.options[select_index].value;

    var minute = $("#rfrRefereesGoalMinute_" + idMatch + "_" + idGoal).val();

    $.ajax({
        url: "php/referees/rfrRefereesGoalPlayerUpdate.php?idMatch=" + idMatch + "&idGoal=" + idGoal + "&idPlayer=" + select_value + "&minute=" + minute,
        cache: false
    })
            .done(function (html) {
                //$("#page-container").html("rfrRefereesGoalMinute_" + idMatch + "_" + idGoal);
            });

}
function rfrRefereesPlayerMatchInsert(idMatch, idPlayer, idTeam, isCaptain) {
    //alert("rfrRefereesPlayerMatchInsertRadio_" + idMatch + "_" + idPlayer + "_" + idTeam);
    var action = $("#rfrRefereesPlayerMatchInsertRadio_" + idMatch + "_" + idPlayer + "_" + idTeam).prop('checked');
    var select = document.getElementById("rfrRefereesPlayerPosition_" + idMatch + "_" + idPlayer + "_" + idTeam);
    var select_index = select.selectedIndex;
    var select_value = select.options[select_index].value;
    if (action == true) {

        $("#rfrRefereesNumberPerPlayer_" + idPlayer + "_" + idTeam).prop('disabled', false);
        $("#rfrRefereesCardsPerPlayer_" + idPlayer + "_" + idTeam + "_yellow").prop('disabled', false);
        $("#rfrRefereesCardsPerPlayer_" + idPlayer + "_" + idTeam + "_blue").prop('disabled', false);
        $("#rfrRefereesPlayerMatchInsertCaptainRadio_" + idMatch + "_" + idPlayer + "_" + idTeam).prop('disabled', false);
        $("#rfrRefereesPlayerPosition_" + idMatch + "_" + idPlayer + "_" + idTeam).prop('disabled', false);

    } else {
        $("#rfrRefereesNumberPerPlayer_" + idPlayer + "_" + idTeam).prop('disabled', true);
        $("#rfrRefereesCardsPerPlayer_" + idPlayer + "_" + idTeam + "_yellow").prop('disabled', true);
        $("#rfrRefereesCardsPerPlayer_" + idPlayer + "_" + idTeam + "_blue").prop('disabled', true);
        $("#rfrRefereesPlayerMatchInsertCaptainRadio_" + idMatch + "_" + idPlayer + "_" + idTeam).prop('disabled', true);
        $("#rfrRefereesPlayerPosition_" + idMatch + "_" + idPlayer + "_" + idTeam).prop('disabled', true);

        $("#rfrRefereesGoalsPerPlayer_" + idPlayer + "_" + idTeam).val('');
        $("#rfrRefereesCardsPerPlayer_" + idPlayer + "_" + idTeam + "_yellow").val('');
        $("#rfrRefereesCardsPerPlayer_" + idPlayer + "_" + idTeam + "_blue").val('');

    }
    $.ajax({
        url: "php/referees/rfrRefereesPlayerMatchInsert.php?idMatch=" + idMatch + "&idTeam=" + idTeam + "&idPlayer=" + idPlayer + "&action=" + action + "&isCaptain=" + isCaptain + "&position=" + select_value,
        cache: false
    })
            .done(function (html) {
                // alert("Resultat introdu�t");
            });


}
function rfrRefereesPlayerMatchInsertCaptain(idMatch, idPlayer, idTeam, isCaptain) {
    var action = $("#rfrRefereesPlayerMatchInsertCaptainRadio_" + idMatch + "_" + idPlayer + "_" + idTeam).prop('checked');


    $.ajax({
        url: "php/referees/rfrRefereesPlayerMatchInsertCaptain.php?idMatch=" + idMatch + "&idTeam=" + idTeam + "&idPlayer=" + idPlayer + "&action=" + action + "&isCaptain=" + isCaptain,
        cache: false
    })
            .done(function (html) {
                // alert("Resultat introdu�t");
            });


}
function rfrRefereesPlayerPositionUpdate(idMatch, idPlayer, idTeam) {
    var select = document.getElementById("rfrRefereesPlayerPosition_" + idMatch + "_" + idPlayer + "_" + idTeam);
    var select_index = select.selectedIndex;
    var select_value = select.options[select_index].value;
    $.ajax({
        url: "php/referees/rfrRefereesPlayerPositionUpdate.php?idMatch=" + idMatch + "&idTeam=" + idTeam + "&idPlayer=" + idPlayer + "&idPosition=" + select_value,
        cache: false
    })
            .done(function (html) {
                // alert("Resultat introdu�t");
            });
}
function rfrRefereesPlayersGoalsMatchInsert(idMatch, idPlayer, idTeam) {
    var goals = $("#rfrRefereesGoalsPerPlayer_" + idPlayer + "_" + idTeam).val();

    $.ajax({
        url: "php/referees/rfrRefereesPlayersGoalsMatchInsert.php?idMatch=" + idMatch + "&idTeam=" + idTeam + "&idPlayer=" + idPlayer + "&goals=" + goals,
        cache: false
    })
            .done(function (html) {
                // alert("Resultat introdu�t");
            });

}
function rfrRefereesPlayerNumberUpdate(idMatch, idPlayer, idTeam) {
    var number = $("#rfrRefereesNumberPerPlayer_" + idPlayer + "_" + idTeam).val();

    $.ajax({
        url: "php/referees/rfrRefereesPlayerNumberUpdate.php?idMatch=" + idMatch + "&idTeam=" + idTeam + "&idPlayer=" + idPlayer + "&number=" + number,
        cache: false
    })
            .done(function (html) {
                // alert("Resultat introdu�t");
            });

}
function rfrRefereesPlayersGoalsCardInsert(idMatch, idPlayer, idTeam, colour) {
    var cards = $("#rfrRefereesCardsPerPlayer_" + idPlayer + "_" + idTeam + "_" + colour).val();
    //alert(cards);
    if(colour =="yellow" & cards >2){
        var x=1;
    }
    if(colour =="blue" & cards>1){
        var x=1;
    }
    if (x==1) {
        $("#rfrRefereesCardsPerPlayer_" + idPlayer + "_" + idTeam + "_" + colour).css("background-color", "red");
        //$("#rfrRefereesCardsPerPlayer_" + idPlayer + "_" + idTeam + "_" + colour).hide(1500).delay( 4000 );
       setTimeout(function () {
            $("#rfrRefereesCardsPerPlayer_" + idPlayer + "_" + idTeam + "_" + colour).val(0);},2000);
        setTimeout(function () {
            $("#rfrRefereesCardsPerPlayer_" + idPlayer + "_" + idTeam + "_" + colour).css("background-color", "#fff");

        }, 3000);
        //  $("#rfrRefereesCardsPerPlayer_" + idPlayer + "_" + idTeam + "_" + colour).css("background-color","#fff").delay(7000);



    } else {
        $("#rfrRefereesCardsPerPlayer_" + idPlayer + "_" + idTeam + "_" + colour).css("background-color", "#fff");

        $.ajax({
            url: "php/referees/rfrRefereesPlayersCardsMatchInsert.php?idMatch=" + idMatch + "&idTeam=" + idTeam + "&idPlayer=" + idPlayer + "&cards=" + cards + "&colour=" + colour,
            cache: false
        })
                .done(function (html) {
                    // alert("Resultat introdu�t");
                });
    }

}
function rfrRefereesPlayersMatchCommentSave(idMatch) {

    var comment = $("#comment").val();
    var dataString = "idMatch=" + idMatch + "&comment=" + comment

    $.ajax({
        type: "POST",
        url: "php/referees/rfrRefereesPlayersMatchCommentSave.php",
        data: dataString,
        cache: false,
        contentType: "application/x-www-form-urlencoded;charset=utf-8",
        success: function (result) {
            //alert(result);
            idNew = result;
            alert("Comentari guardat");
        }
    });

}

function rfrMatchAssignationAccept(idMatch, idReferee) {

    $.ajax({
        url: "php/referees/rfrMatchAssignationAccept.php?idMatch=" + idMatch + "&idReferee=" + idReferee,
        cache: false
    })
            .done(function (html) {
                rfrRefereeMatchesList();
            });

}
function rfrBills() {
    $("#page-container").html('<img src="images/ajax-loader.gif" />');
    $.ajax({
        url: "php/referees/rfrBills.php",
        cache: false
    })
            .done(function (html) {
                $("#page-container").html(html);

            });


}
function rfrBillGenerate(date) {
    $("#page-container").html('<img src="images/ajax-loader.gif" />');
    $.ajax({
        url: "php/referees/rfrBillGenerate.php?date=" + date,
        cache: false
    })
            .done(function (html) {
                //$("#page-container").html(html);
                rfrBills();

            });
}

function rfrRefereeMatchesListForClubs() {
    $("#page-container").html('<img src="images/ajax-loader.gif" />');
    $.ajax({
        url: "php/referees/rfrRefereeMatchesListForClubs.php",
        cache: false
    })
            .done(function (html) {
                $("#page-container").html(html);
            });


}
function rfrRefereeMatchResultForClub(idMatch) {
    $("#page-container").html('<img src="images/ajax-loader.gif" />');
    $.ajax({
        url: "php/referees/rfrRefereeMatchResultForClub.php?idMatch=" + idMatch,
        cache: false
    })
            .done(function (html) {
                $("#page-container").html(html);

            });


}

function cmptMatchListByIdClub() {
    $("#page-container").html('<img src="images/ajax-loader.gif" />');
    $.ajax({
        url: "php/clubs/cmptMatchListByIdClub.php",
        cache: false
    })
            .done(function (html) {
                $("#page-container").html(html);

            });

}

function cmptMatchDateChange(idMatch) {
    $("#page-container").html('<img src="images/ajax-loader.gif" />');
    $.ajax({
        url: "php/clubs/cmptMatchDateChange.php?idMatch=" + idMatch,
        cache: false
    })
            .done(function (html) {
                $("#page-container").html(html);

            });
}

function cmptMatchDateUpdate(idMatch) {
    //$("#page-container").html('<img src="images/ajax-loader.gif" />');
    var date = $("#matchDate").val();
    var time = $("#matchTime").val();
    var select = document.getElementById("matchComplex");
    var select_index = select.selectedIndex;
    var select_value = select.options[select_index].value;
    //alert(date);

    $.ajax({
        url: "php/clubs/cmptMatchDateUpdate.php?idMatch=" + idMatch + "&date=" + date + "&time=" + time + "&complex=" + select_value,
        cache: false
    })
            .done(function (html) {
                // $("#page-container").html(html);
                cmptMatchListByIdClub();

            });
}
function clubComplex() {
    $("#page-container").html('<img src="images/ajax-loader.gif" />');
    $.ajax({
        url: "php/clubs/clubComplex.php",
        cache: false
    })
            .done(function (html) {
                $("#page-container").html(html);
            });


}

function clubComplexInsert() {

    var clubComplexName = $("#clubComplexName").val();
    var clubComplexAddress = $("#clubComplexAddress").val();
    var dataString = "complexName=" + clubComplexName + "&complexAddress=" + clubComplexAddress;
    //var dataString="id:"+idNew;
    //alert(dataString);
    $.ajax({
        type: "POST",
        url: "php/clubs/clubComplexInsert.php",
        data: dataString,
        cache: false,
        contentType: "application/x-www-form-urlencoded;charset=utf-8",
        success: function (result) {
            clubComplex();
        }
    });



}
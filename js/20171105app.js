var url="http://localhost:8081/futsal_v3/";
function clubsSearch(){
	var clubProvince = $( "#clubsSearchProvincesSelect").val();
	var clubCity = $( "#clubsSearchCitiesSelect").val();
	var clubName = $( "#clubsSearchInputText").val();
	var param= "clubName="+clubName+"&clubCity="+clubCity+"&clubProvince="+clubProvince;
	//alert(clubName+" "+clubCity+" "+clubProvince);
	 var request = $.ajax({
		url: "Clubs/clubSearch",
		type: "POST",
		data: param,
		dataType: "html"
	});
 
	request.done(function( msg ) {
		$( "#clubsSearchContainer" ).html( msg );
	});
 
	request.fail(function( jqXHR, textStatus ) {
		alert( "Request failed: " + textStatus );
	}); 
}


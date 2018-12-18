/* 
 * Cette partie permet de rechercher par rapport a un input si il y a un tableau
 */



function barreRecherche(){
	//Generation de la barre de recherche
	rechercheBarre = '<div class="col-sm8"><label>Recherche</label> <input type="text" id="recherche" ><div>';
	var table = $('table');
	table.each(function() {
		//écriture de la barre de recherche dans les pages qui on un tableau, avant le tableau
		$(rechercheBarre).insertBefore(table);
		//recuperation des données de la bdd
		$('#recherche').on('input', function() {
			affichage();
		});
	});
}

function affichage() {
	//récupération du tableau
	$("table tr td").each(function() {
		//s'il y a une ligne qui ressemble au text on l'affiche
		if ($(this).text().indexOf($('#recherche').text()) >= 0){
			$(this).parent().css("display", "table-row");
		//sinon on ne l'affiche pas
		}else{
			$(this).parent().css("display", "none");
		}
	});
}

barreRecherche();
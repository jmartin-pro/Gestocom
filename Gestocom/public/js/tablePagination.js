var table = $('table');
var maxItems = 15;
var selectedItemValue = 0;

//TODO changer le code pour qu'il gère le cas où plusieurs tableaux sont présents sur une même page

function generatePaginationNav() {
	navHtml = "<nav><ul class='pagination'><li class='page-item paginationBefore'><a class='page-link' href='#'>Précédent</a></li>";

	nbPage = $("table tr").length / maxItems +1;
	for(var i = 1 ; i <= nbPage  ; i++) {
		navHtml += "<li class='page-item paginationNumber'><a class='page-link' href='#'>" + i + "</a></li>"
	}

	navHtml += "<li class='page-item'><a class='page-link paginationAfter' href='#'>Suivant</a></li></ul></nav>";

	$(navHtml).insertAfter(table);
	
	$(".paginationNumber").click(function() {
		updateVisibleRows($(this).text()-1);
	});
	
	$(".paginationBefore").click(function() {
		updateVisibleRows(Math.max(0, selectedItemValue-1));
	});
	
	$(".paginationAfter").click(function() {
		updateVisibleRows(Math.min(parseInt($("table tr").length / maxItems), selectedItemValue+1));
	});
}

function updateVisibleRows(selectedItem = 0) {
	$(".pagination li").eq(selectedItemValue + 1).removeClass("disabled");
	selectedItemValue =  selectedItem;
	$(".pagination li").eq(selectedItemValue + 1).addClass("disabled");

	$("table tr").each(function(index) {
		if(index == 0)
			return;
		if(index >= maxItems * selectedItemValue + 1 && index < maxItems * (selectedItemValue+1) + 1) {
			$(this).css("display", "table-row");
		} else {
			$(this).css("display", "none");
		}
	});
}

generatePaginationNav();
updateVisibleRows();

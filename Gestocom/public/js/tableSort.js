var table = $('table');
var lastTh = null; 

$('th')
    .wrapInner('<span title="Trier la colonne"/>')
    .each(function(){

        var th = $(this),
            thIndex = th.index(),
            inverse = false;
            
		th.css("cursor", "pointer");
        th.click(function(){

            table.find('td').filter(function(){

                return $(this).index() === thIndex;

            }).sortElements(function(a, b){

                if( $.text([a]) == $.text([b]) )
                    return 0;

                return $.text([a]) > $.text([b]) ?
                    inverse ? -1 : 1
                    : inverse ? 1 : -1;

            }, function(){

                // parentNode is the element we want to move
                return this.parentNode; 

            });

            inverse = !inverse;
            if(lastTh != null && (lastTh.text().indexOf("▲") >= 0 || lastTh.text().indexOf("▼") >= 0)) {
            	lastTh.text(lastTh.text().slice(0, -1));	
            } 
            
            $(this).text($(this).text() + ((inverse) ? "▲" : "▼"));
            lastTh = $(this);
            updateVisibleRows();

        });

    });

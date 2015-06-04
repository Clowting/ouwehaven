$(document).ready(function ($) {

    var pageCount;
    
    $('#cashbookEntries').on('click', '#deleteEntry', function(){
    	var deleteID = $(this).parent().parent().attr('id');
    	var send = 'deleteID='+deleteID;
    	if(confirm("Weet u zeker dat u deze entrie wilt verwijderen?")){
    		
    	
	    	$.ajax({
	    		type: "post",
	    		url: "searchCashbook.php",
	    		data: send,
	    		success: function(){
	    			$('#'+deleteID).fadeOut("slow", function(){
	    				 $('#'+deleteID).remove();
	    			})
	    		}
	    	})	
	    	
    	}
    });

    $('#search').click(function(e) {
        e.preventDefault();
        $('#pagination').remove();
        $('#page-selection').html('<ul id="pagination"></ul>');
        searchCashbook();
    });

    function searchCashbook() {
        loadCashbook(1);
        $(document).ajaxStop(function() {
            $('#pagination').twbsPagination({
                totalPages: pageCount,
                visiblePages: 5,
                first: 'Begin',
                prev: '<',
                next: '>',
                last: 'Eind',
                onPageClick: function (event, page) {
                    loadCashbook(page);
                }
            });
        });
    }

    function loadCashbook(page) {
    	
        $("#cashbookEntries").html('<tr><td colspan="7">Kasboek entries worden geladen...</td></tr>');
        var postData = {
            desc: $('#desc').val(),
            code: $('#code').val(),
            date: $('#date').val(),
            sender: $('#sender').val(),
            receiver: $('#receiver').val(),
            page: page
        };

        $.ajax({
            type: "post",
            url: "searchCashbook.php",
            data: postData,
            success: function (data) {
                data = $.parseJSON(data);
                var toAppend = "";
                pageCount = Math.ceil(data['totalCount']/50);

                $.each(data['items'], function (index, value) {
                    if(value['Code'] == 'D') {
                        var code = 'Debet';
                    }
                    else if(value['Code'] == 'C') {
                        var code = 'Credit';
                    }

                    toAppend +=
                        '<tr id="'+ value['ID']+'">' +
                        '<td><input type="hidden" name="'+ value['ID'] +'[desc]" value="'+ value['Beschrijving'] +'"></input>	' + value['Beschrijving'] + '</td>' +
                        '<td><input type="hidden" name="'+ value['ID'] +'[date]" value="'+ value['Datum'] +'"></input>	' + value['Datum'] + '</td>' +
                        '<td><input type="hidden" name="'+ value['ID'] +'[amount]" value="&euro; '+ value['Bedrag'] +'"></input>&euro;	' + value['Bedrag'] + '</td>' +
                        '<td><input type="hidden" name="'+ value['ID'] +'[code]" value="'+ value['Code'] +'"></input>	' + code + '</td>' +
                        '<td><input type="hidden" name="'+ value['ID'] +'[sender]" value="'+ value['Afzender'] +'"></input>	' + value['Afzender'] + '</td>' +
                        '<td><input type="hidden" name="'+ value['ID'] +'[receiver]" value="'+ value['Ontvanger'] +'"></input>	' + value['Ontvanger'] + '</td>' +
                        '<td><a class="btn" id="deleteEntry" name="deleteEntry"><i class="fa fa-trash-o "></i> Verwijderen</a></td>';
                        '</tr>';
                });

                $("#cashbookEntries").html(toAppend);

            }
        });
    }
    

   

});
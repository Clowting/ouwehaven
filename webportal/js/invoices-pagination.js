$(document).ready(function ($) {

    var pageCount;
    
    $('#invoicesEntries').on('click', '#deleteEntry', function(){
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
    
    $('#invoicesEntries').on('click', '#printPdf', function(){
    	var id = 'id=' + $(this).parent().parent().attr('id');
    	$.ajax({
    		url: "pdf-creator/invoicesPDF.php",
    		data: id,
    		success: function(){
    			windows.open(this);
    		}
    	})
    });

    $('#search').click(function(e) {
        e.preventDefault();
        $('#pagination').remove();
        $('#page-selection').html('<ul id="pagination"></ul>');
        searchInvoice();
    });

    function searchInvoice() {
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

    function loadInvoice(page) {
    	
        $("#invoiceEntries").html('<tr><td colspan="7">Kasboek entries worden geladen...</td></tr>');
        var postData = {
            member: $('#member').val(),
            date: $('#date').val(),
            paid: $('#paid').val(),
            datePaid: $('datePaid').val(),
            page: page
        };

        $.ajax({
            type: "post",
            url: "searchInvoices.php",
            data: postData,
            success: function (data) {
                data = $.parseJSON(data);
                var toAppend = "";
                pageCount = Math.ceil(data['totalCount']/50);

                $.each(data['items'], function (index, value) {
                    toAppend +=
                        '<tr id="'+ value['ID']+'">' +
                        '<td><input type="hidden" name="'+ value['ID'] +'[desc]" value="'+ value['Beschrijving'] +'"></input>	' + value['Beschrijving'] + '</td>' +
                        '<td><input type="hidden" name="'+ value['ID'] +'[date]" value="'+ value['Datum'] +'"></input>	' + value['Datum'] + '</td>' +
                        '<td><input type="hidden" name="'+ value['ID'] +'[amount]" value="&euro; '+ value['Bedrag'] +'"></input>&euro;	' + value['Bedrag'] + '</td>' +
                        '<td><input type="hidden" name="'+ value['ID'] +'[code]" value="'+ value['Code'] +'"></input>	' + value['Code'] + '</td>' +
                        '<td><input type="hidden" name="'+ value['ID'] +'[sender]" value="'+ value['Afzender'] +'"></input>	' + value['Afzender'] + '</td>' +
                        '<td><input type="hidden" name="'+ value['ID'] +'[receiver]" value="'+ value['Ontvanger'] +'"></input>	' + value['Ontvanger'] + '</td>' +
                        '<td><a class="btn" id="deleteEntry" name="deleteEntry"><i class="fa fa-trash-o "></i> Verwijderen</a></td>';
                        '</tr>';
                });

                $("#invoicesEntries").html(toAppend);

            }
        });
    }
    

   

});
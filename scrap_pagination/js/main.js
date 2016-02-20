// js

$(function(){

	$('#searchForm').submit(function(e) {

		e.preventDefault();
		var action = $(this).attr('action');
		var postData = $(this).serializeArray();
		var method = $(this).attr('method');
		var page=1;

		$('#search-hidden').val($('#qry').val());

		getServerResponse(action, postData, method, page);
	});


	$(document).on('click','.page',function(e) {

		var page = $(this).data('page');
		var action = $('#searchForm').attr('action');
		var method = $('#searchForm').attr('method');
		var postData = {
			qry : $('#search-hidden').val(),
			page: page
		};

		$('#search-hidden').val($('#qry').val());

		getServerResponse(action, postData, method, page);
	});

	$(document).on('click','.price-sort',function(){
		reverseOrder('tbody');
	});

});

var ajax_req; 

function getServerResponse(action,postData,method,page){
	var $resultDiv = $("#result");
	var sl_no;
	var pgClass = 'page'; 
	var totalPage = 0;
	var amazonListCount = 16;
	$resultDiv.html('<img src="img/ajax-loader.gif" class="ldr"/>');

	ajax_req = $.ajax({
		url:action,
		data:postData,
		method:method,
		success: function(result){
			var actual = JSON.parse(result);
			var html = "";

			// save total page number in the first search
			if(page==1){
				if(actual[0]['totalPage']){
					totalPage = actual[0]['totalPage'];
					$('#totalPage').val(totalPage);
				}
			}else{
				totalPage = $('#totalPage').val();
			}

			// create pagination
			if(totalPage!=0){
				html += "<div class='page-div'>";
				for(var i=1; i<=totalPage;i++){
					pgClass = page == i ? 'page selected' : 'page'; 

					html += "<span class='"+pgClass+"' data-page='"+ i +"'>" + i + "</span>";
				}
				html += "<div><div class='clear'></div>";
			}

			html += "<span class='spn1'>Click on price to sort items by price</span>";

			html += "<table>";
			html += "<thead>";
			html += "<tr>";
			html += "<th>No.</th>";
			html += "<th>Image</th>";
			html += "<th>Title</th>";
			html += "<th class='price-sort' data-sort='ASC'>Price ^</th>";
			html += "</tr>";
			html += "<thead>";
			html += "<tbody>";

			for(var i in actual){
				sl_no = parseInt(i) + 1;
				sl_no = ((page-1) * amazonListCount ) + sl_no; // create sl. no from page number
				html += "<tr>";
				html += "<td>"+ sl_no +"</td>";
				html += "<td><img src='"+actual[i]['image']+"'/></td>";
				html += "<td>"+actual[i]['title']+"</td>";
				html += "<td>"+actual[i]['price']+"</td>";
				html += "</tr>";
			}

			html += "</tbody>";
			html +="</table>";

			$resultDiv.html(html);

		},
		error: function(er){
			console.log(er);
			$resultDiv.html('Something went wrong, try again.');
		},
		beforeSend: function(){
			if(ajax_req){
				ajax_req.abort();
			}
		}
	});
}

// reverse order of tr in table
function reverseOrder(elem){
	var $body = $(elem);
	var list = $body.children('tr');
	$body.html(list.get().reverse());
}
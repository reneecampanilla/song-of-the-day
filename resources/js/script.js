jQuery(document).ready(function($){
	$('[data-toggle="tooltip"]').tooltip();
	var actions = $("table td:last-child").html();
	// Append table with add row form on add new button click
    $(".add-new").click(function(){
		$(this).attr("disabled", "disabled");
		var index = $("table tbody tr:last-child").index();
        var row = '<tr>' +
            '<td><input type="text" class="form-control" name="title" id="title"></td>' +
            '<td><input type="text" class="form-control" name="singer" id="singer"></td>' +
			'<td>' + actions + '</td>' +
        '</tr>';
    	$("table").append(row);		
		$("table tbody tr").eq(index + 1).find(".add, .edit").toggle();
        $('[data-toggle="tooltip"]').tooltip();
    });
	// Add row on add button click
	$(document).on("click", ".add", function(){
		var empty = false;
		var input = $(this).parents("tr").find('input[type="text"]');
		var sotd_data = {"title":"", "singer":""};
        input.each(function(){
			if(!$(this).val()){
				$(this).addClass("error");
				empty = true;
			} else{
                $(this).removeClass("error");
            }
		});
		$(this).parents("tr").find(".error").first().focus();
		if(!empty){
			input.each(function(){
				$(this).parent("td").html($(this).val());
				sotd_data[$(this).attr('id')] = $(this).val();
			});			
			$(this).parents("tr").find(".add, .edit").toggle();
			$(".add-new").removeAttr("disabled");
		}	

		$.ajax({
			type: "GET",
			dataType:'json',
			url: "/wp-json/sotd/v1/add/" + sotd_data['title'] + "/" + sotd_data['singer'],
			success: function(msg,status,xhr){
				// console.log(result);
			},
		});	
    });

	// Delete row on delete button click
	$(document).on("click", ".delete", function(){
        $(this).parents("tr").remove();
		$(".add-new").removeAttr("disabled");
		$(".tooltip").hide();
		$.ajax({
			type: "GET",
			dataType:'json',
			url: "/wp-json/sotd/v1/delete/" + $(this).parents("tr").data('sotd-id'),
			success: function(msg,status,xhr){
				// console.log(result);
			},
		});	
    });
});
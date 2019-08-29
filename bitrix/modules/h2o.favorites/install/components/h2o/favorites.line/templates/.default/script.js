function updateFavoritesLine(){
	var link = '?AJAX_CALL_FAVORITES_LINE=Y';
	jQuery.ajax(link, {
		type: "POST",
		success: function (data) {
			var obj = jQuery("<div />").html(data);
			jQuery(".favor-list-wrap").html(obj.find(".favor-list-wrap").html());
		},
		dataType: "html"
	});
}
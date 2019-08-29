function favorites_list(){

   /**
    * ��� ������� �� ������� � ������� delete_favorites ������ ajax ������,
	* ����� ������� �������, ���������� � �������� id,
	*/ 
	jQuery(document).on('click','.delete_favorites', function(e){
		e.preventDefault();
		var link = '?AJAX_CALL_FAVORITES_LIST=Y';
		var postArray = {
			'DELETE_FAVOR': 'Y',
			'ID': jQuery(this).data('id')
		};
		jQuery.ajax(link, {
			type: "POST",
			data: postArray,
			success: function (data) {
				var obj = jQuery("<div />").html(data);
				jQuery(".ajax-h2ofavorites-list").html(obj.find(".ajax-h2ofavorites-list").html());
				if(typeof updateFavoritesLine == 'function'){
					updateFavoritesLine();
				}
			},
			dataType: "html"
		});
	})
   
}
/**
 * �������� �������������
 */
if (window.frameCacheVars !== undefined) 
{
        BX.addCustomEvent("onFrameDataReceived" , function(json) {
            favorites_list();
        });
} else {
        jQuery(function() {
            favorites_list();
        });
}
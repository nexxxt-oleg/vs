window.JCH2oFavoritesList = function (arParams) {
  var self = this;
  this.containerClass = ".ajax-h2ofavorites-list";
  this.ajaxID = "";
  this.elementMaps = {};

  this.errorCode = 0;
  if (typeof arParams === 'object') {
    this.params = arParams;
    this.initConfig();

    this.errorCode = 0;
  }
  if (0 === this.errorCode) {
    if (window.frameCacheVars !== undefined)
    {
      BX.addCustomEvent("onFrameDataReceived" , function(json) {
        BX.ready(BX.delegate(self.Init, self));
      });
    } else {
      BX.ready(BX.delegate(this.Init, this));
    }
  }else{
    console.log('this.errorCode ',this.errorCode);
  }
};

window.JCH2oFavoritesList.prototype.initConfig = function () {
  if (!!this.params.CONTAINER_CLASS) {
    this.containerClass = "."+this.params.CONTAINER_CLASS;
    this._containerClass = this.params.CONTAINER_CLASS;
  }
  if (!!this.params.ELEMENT_MAPS) {
    this.elementMaps = this.params.ELEMENT_MAPS;
  }
  if (!!this.params.AJAX_ID) {
    this.ajaxID = this.params.AJAX_ID;
  }
};


window.JCH2oFavoritesList.prototype.AjaxSubmit = function (postArray, link, dataType, successFunction) {
  var self = this;
  if(link === undefined){
    link = window.location.pathname;
  }
  if(dataType === undefined){
    dataType = 'html';
  }
  if(postArray === undefined){
    postArray = {};
  }
  if(typeof successFunction !== 'function'){
    successFunction = function (data) {
      var obj = $("<div />").html(data);
      $(self.containerClass).html(obj.find(self.containerClass).html());
      if(typeof updateFavoritesLine === 'function'){
        updateFavoritesLine();
      }
    }
  }
  $.ajax({
    url: link,
    type: "POST",
    data: postArray,
    success: successFunction,
    dataType: dataType
  });
};

window.JCH2oFavoritesList.prototype.DeleteFavor = function (e) {
	e.preventDefault();
	var self = this,
    	element = e.target,
    	id = $(element).data('id');
  if(self.elementMaps[id] !== 'undefined'){
  	self.AjaxSubmit({
      'DELETE_FAVOR': 'Y',
      'ID': self.elementMaps[id]
    });
	}
};

window.JCH2oFavoritesList.prototype.InitEvents = function () {
  var self = this;
  $(document).on('click', '.delete_favorites', BX.delegate(self.DeleteFavor, self));
};

window.JCH2oFavoritesList.prototype.Init = function () {
  this.InitEvents();
};



function favorites_list(){

   /**
    * При нажатии на элемент с классом delete_favorites делаем ajax запрос,
	* чтобы удалить элемент, переданный в атрибуте id,
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
				if(typeof updateFavoritesLine === 'function'){
					updateFavoritesLine();
				}
			},
			dataType: "html"
		});
	})
   
}
/**
 * Проверка композитности
 */
if (window.frameCacheVars !== undefined) 
{
        BX.addCustomEvent("onFrameDataReceived" , function(json) {
            //favorites_list();
        });
} else {
        jQuery(function() {
            //favorites_list();
        });
}
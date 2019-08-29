

window.JCH2oFavoritesAdd = function (arParams){

  this.currentFavorites = [];

  this.button = {
    title: {
      inFavor: "already in favorites",
      notInFavor: "Add to favorites"
    },
    className: "h2o_add_favor"
  };

  if (typeof arParams === 'object')
  {
    this.params = arParams;

    this.initConfig();


    this.errorCode = 0;
  }
  if (0 === this.errorCode)
  {
    BX.ready(BX.delegate(this.Init,this));
  }
  //this.params = {};
}

window.JCH2oFavoritesAdd.prototype.initConfig = function(){
  if (typeof this.params.BUTTON_CONTENT === 'object'){
    if(this.params.BUTTON_CONTENT.IN_FAVOR != ""){

      this.button.title.inFavor = this.params.BUTTON_CONTENT.IN_FAVOR;
    }
    if(this.params.BUTTON_CONTENT.NOT_IN_FAVOR != ""){
      this.button.title.notInFavor = this.params.BUTTON_CONTENT.NOT_IN_FAVOR;
    }
    console.log(this.params.BUTTON_CLASS);
    if(this.params.BUTTON_CLASS != "" && typeof this.params.BUTTON_CLASS !== 'undefined'){
      this.button.className = this.params.BUTTON_CLASS;
    }
    this.currentFavorites = this.params.CURRENT_ELEMENT_IN_FAVORITES;
  }
}

window.JCH2oFavoritesAdd.prototype.Init = function() {
  var i = 0,
    j = 0,
    strPrefix = '',
    self = this,
    params = this.params,
    TreeItems = null;
  TreeItems = jQuery("."+this.button.className);
  if (TreeItems.length > 0){
    TreeItems.each(function(){
      if(jQuery.inArray(String(jQuery(this).data("id")), self.currentFavorites) >= 0){
        // jQuery(this).html(self.button.title.inFavor).addClass("in-favor");
        jQuery(this).addClass("active");
      }else{
        // jQuery(this).html(self.button.title.notInFavor).removeClass("in-favor");
        jQuery(this).removeClass("active");
      }
    });
  }

  jQuery(document).on('click', "."+this.button.className, function (e) {
    e.preventDefault();
    var link = '?AJAX_CALL_FAVORITES_ADD=Y';
    var $this = jQuery(this);
    var postArray = {
      'H2O_FAVORITES_ELEMENT_ID':  jQuery(this).data('id'),
      'h2o_add_favorites': 'Y'
    };
    jQuery.ajax(link, {
      type: "POST",
      data: postArray,
      success: function (data) {
        if(data.ADD > 0){
          // $this.html(self.button.title.inFavor).addClass("in-favor");
          $this.addClass("active");
        }
        if(data.DELETE > 0){
          // $this.html(self.button.title.notInFavor).removeClass("in-favor");
          $this.removeClass("active");
        }
        if(typeof updateFavoritesLine == 'function'){
          updateFavoritesLine();
        }

      },
      dataType: "json"
    });

  })

};
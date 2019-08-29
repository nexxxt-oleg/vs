var allBlocksUslugi = $(".block-uslugi");
var allBlocksUslugiArrHeight = [];
for (var i=0; i<allBlocksUslugi.length; i++) {
    var asd = $(allBlocksUslugi[i]).height();
    allBlocksUslugiArrHeight.push(parseInt(asd));
}

allBlocksUslugiArrHeight.max = function(){
    return Math.max.apply( Math, this );
};

$(".block-uslugi").height(allBlocksUslugiArrHeight.max());
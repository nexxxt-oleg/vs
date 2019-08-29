function startYaMaps(id="",objects={},zoom=12){
	ymaps.ready(init);
	function init(){
        var myMap = new ymaps.Map(id, {
            center: [45.134290, 33.603298],
            zoom: zoom,
            controls: []
        });
		for(var name in objects){
			window["myPlacemark"+objects[name]['CODE']] = new ymaps.Placemark(objects[name]['COORDINATES'],{ 
				hintContent: name, 
				balloonContent: objects[name]['CITY']+", "+objects[name]['ADDRESS']+"<br/>Тел.: "+objects[name]['PHONE']+(objects[name]['FAX'] !== null ? "<br/>Тел./факс: "+objects[name]['FAX'] : '')+"<br/>"+objects[name]['WORKTIME']
			},
			{
				iconLayout: 'default#image',
				iconImageHref: '/bitrix/templates/stroyka/img/pin-map.png',
				iconImageSize: [44, 44],
				iconImageOffset: [-22, -44], 
			});
			myMap.geoObjects.add(window["myPlacemark"+objects[name]['CODE']]);
		}
    }
}
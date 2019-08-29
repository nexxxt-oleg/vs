<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$phones = COption::GetOptionString("grain.customsettings","phone");
$phones = explode(',', $phones);
?>
<script type="text/javascript">
    ymaps.ready(function () {
        var zoom = 14;
        /* Данные карты */
        var dataPoints = [
            {
                coords: [<?= COption::GetOptionString("grain.customsettings","coordinates") ?>],
                title: "Основной офис",
                props: [
                    <?= isset($phones[0]) ? '"тел. ' . $phones[0] . '",' : '' ?>
                    <?= isset($phones[1]) ? '"тел. ' . $phones[1] . '"' : '' ?>
                ]
            }
        ];
        var geoObjects = [];

        /* Настройки карты */
        var myMap = new ymaps.Map('map', {
            center: [<?= COption::GetOptionString("grain.customsettings","coordinates") ?>],
            zoom: zoom,
            controls: ['smallMapDefaultSet']
        }, {
            searchControlProvider: 'yandex#search'
        });

        /* Настройки кластеризатора */
        var clusterer = new ymaps.Clusterer({
            preset: 'islands#redClusterIcons',
            clusterDisableClickZoom: true,
            clusterOpenBalloonOnClick: true,
            clusterBalloonPanelMaxMapArea: 0,
            clusterBalloonContentLayoutWidth: 350,
            clusterBalloonItemContentLayout: ClusterTemp,
            clusterBalloonLeftColumnWidth: 120
        });

        /* Шаблон балуна кластера */
        var ClusterTemp = ymaps.templateLayoutFactory.createClass(
            '<h2 class=card-contact__title>{{ properties.balloonContentHeader|raw }}</h2>' +
            '<div class=card-contact__desc>{{ properties.balloonContentHeader|raw }}<div>'
        );

        /* Шаблон балуна метки */
        var PointTemplate = ymaps.templateLayoutFactory.createClass(
            '<div class="ymap-balloon card-contact">' +
            '<h4 class="card-contact__title">{{properties.title}}</h4>' +
            '<ul class="card-contact__desc">' +
            '{% for prop in properties.props %}' +
            '<li>{{ prop }}</li>' +
            '{% endfor %}' +
            '</ul>' +
            '</div>'
        );

        var getContentBody = function (props) {
            var string = "<div class='ymap-balloon card-contact'><ul class='card-contact__desc'>";
            for (var i = 0; i < props.length; i++) {
                // console.log(props[i]);
                string += "<li>" + props[i] + "</li>";
            }
            string += "</ul></div>";
            return string;
        }

        /* Данные метки */
        var getPointData = function (index) {
            return {
                balloonContentHeader: dataPoints[index].title,
                balloonContentBody: getContentBody(dataPoints[index].props),
                title: dataPoints[index].title,
                props: dataPoints[index].props
            };
        }

        /* Опции метки */
        var getPointOptions = function () {
            return {
                balloonContentLayout: PointTemplate,
                iconLayout: 'default#image',
                iconImageHref: '<?= $APPLICATION->GetTemplatePath("img/pin-map.svg") ?>',
                iconImageSize: [44, 43],
                iconImageOffset: [-22, -22]
            };
        }

        /* Создание меток */
        for (var i = 0, len = dataPoints.length; i < len; i++) {
            geoObjects[i] = new ymaps.Placemark(dataPoints[i].coords, getPointData(i), getPointOptions());
        }

        clusterer.options.set({
            gridSize: 80,
            clusterDisableClickZoom: true
        });

        clusterer.add(geoObjects);
        myMap.geoObjects.add(clusterer);
        if( geoObjects.length === 0 ) { // Если не найдено ни 1 объекта
            myMap.setCenter([<?= COption::GetOptionString("grain.customsettings","coordinates") ?>], zoom);
        } else if( geoObjects.length === 1 ) { // Если найден 1 объект
            myMap.setCenter(myMap.geoObjects.getBounds()[0], zoom);
        } else { // Если не найдено больше 1 объекта
            myMap.setBounds(clusterer.getBounds());
        }
       /* myMap.setBounds(clusterer.getBounds(), {
            checkZoomRange: true
        });*/
    });
</script>

<div id="map" class="pcc-map"></div>
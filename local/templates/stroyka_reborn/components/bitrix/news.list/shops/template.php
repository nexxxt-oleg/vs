<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */

$this->setFrameMode(true);
?>
<? if (!empty($arResult['ITEMS'])): ?>
    <section id="shops" class="page-all-sect page-all-sect_pb_none page-cnt-shops__map">
        <div class="container">
            <div class="row">
                <div class="col-8">
                    <div class="page-all-sect__top-title">
                        <? $APPLICATION->IncludeComponent(
                            "bitrix:main.include",
                            "",
                            Array(
                                "AREA_FILE_SHOW" => "file",
                                "PATH" => "title1_inc.php"
                            )
                        ); ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <script type="text/javascript">
                        ymaps.ready(function () {
                            /* Данные карты */
                            var dataPoints = [
                                <? foreach ($arResult['ITEMS'] as $key => $arItem): ?>{
                                    id: <?= $key ?>,
                                    coords: [<?= $arItem['DISPLAY_PROPERTIES']['COORDINATES']['VALUE'] ?>],
                                    title: '<?= $arItem['~NAME'] . ', ' . $arItem['DISPLAY_PROPERTIES']['CITY']['VALUE'] ?>',
                                    props: [
                                        "<?= $arItem['DISPLAY_PROPERTIES']['ADDRESS']['VALUE'] ?>",
                                        "тел. <?= $arItem['DISPLAY_PROPERTIES']['PHONE']['VALUE'] ?>",
                                        <?= empty($arItem['DISPLAY_PROPERTIES']['COORDINATES']['VALUE']) ? '"тел/факс ' . $arItem['DISPLAY_PROPERTIES']['FAX']['VALUE'] . '",' : '' ?>
                                        "<?= $arItem['DISPLAY_PROPERTIES']['WORKTIME']['VALUE'] ?>",
                                        "<?= $arItem['DISPLAY_PROPERTIES']['HOLIDAYS']['VALUE'] ?>",
                                    ]
                                },<? endforeach; ?>
                            ];
                            var geoObjects = [];

                            /* Настройки карты */
                            var myMap = new ymaps.Map('map-with-shops', {
                                center: [<?= COption::GetOptionString("grain.customsettings","coordinates") ?>],
                                zoom: 9,
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

                            myMap.setBounds(clusterer.getBounds(), {
                                checkZoomRange: true
                            });

                            $('.js-open-balloon').on('click', function (e) {
                                e.preventDefault();
                                var id = parseInt($(this).data('point-id'));
                                myMap.setCenter(dataPoints[id].coords, 19);
                                geoObjects[id].balloon.open();
                            });
                        });
                    </script>

                    <div id="map-with-shops" class="pcs-map"></div>
                </div>
            </div>
        </div>
    </section>
    <section class="page-all-sect page-cnt-shops__map">
        <div class="container">
            <div class="row">
                <div class="col-8">
                    <div class="page-all-sect__top-title">
                        <? $APPLICATION->IncludeComponent(
                            "bitrix:main.include",
                            "",
                            Array(
                                "AREA_FILE_SHOW" => "file",
                                "PATH" => "title2_inc.php"
                            )
                        ); ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <? foreach ($arResult['ITEMS'] as $key => $arItem): ?>
                    <? $arPhone = explode(';', $arItem['DISPLAY_PROPERTIES']['PHONE']['VALUE']); ?>
                    <div class="col-12 col-sm-4 col-lg-3">
                        <div class="page-cnt-contacts__card card-contact">
                            <a href="#" class="card-contact__title h5 js-open-balloon" data-point-id="<?= $key ?>"><?= $arItem['NAME']  ?></a>
                            <ul class="card-contact__desc">
                                <!--<li><?/*= $arItem['DISPLAY_PROPERTIES']['COORDINATES']['VALUE'] */?></li>-->
                                <li><?= $arItem['DISPLAY_PROPERTIES']['CITY']['VALUE'] ?></li>
                                <li><?= $arItem['DISPLAY_PROPERTIES']['ADDRESS']['VALUE'] ?></li>
                                <? if (isset($arPhone[0]) && !empty($arPhone[0])) : ?>
                                    <li>тел.
                                        <? foreach ($arPhone as $phone): ?>
                                            <?= !empty($phone) && $phone != ' ' ? trim($phone) . '<br/>' : '' ?>
                                        <? endforeach; ?>
                                    </li>
                                <? endif; ?>
                                <li><?= $arItem['DISPLAY_PROPERTIES']['WORKTIME']['VALUE'] ?></li>
                                <li><?= $arItem['DISPLAY_PROPERTIES']['HOLIDAYS']['VALUE'] ?></li>
                            </ul>
                        </div>

                        <!-- <div class="page-cnt-shops__card b-content">
                            <p><strong class="js-open-balloon" data-point-id="<?= $key ?>"><?= $arItem['NAME'] . ', ' . $arItem['DISPLAY_PROPERTIES']['CITY']['VALUE'] ?></strong>,<br>
                                <?= $arItem['DISPLAY_PROPERTIES']['COORDINATES']['VALUE'] ?><br>
                                <?= $arItem['DISPLAY_PROPERTIES']['ADDRESS']['VALUE'] ?><br>
                                тел. <?= $arItem['DISPLAY_PROPERTIES']['PHONE']['VALUE'] ?><br>
                                <?= $arItem['DISPLAY_PROPERTIES']['WORKTIME']['VALUE'] ?><br>
                                <?= $arItem['DISPLAY_PROPERTIES']['HOLIDAYS']['VALUE'] ?>
                            </p>
                        </div> -->
                    </div>
                <? endforeach; ?>
            </div>
        </div>
    </section>
<? endif; ?>
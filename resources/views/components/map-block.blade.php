@php $mapId = 'ymap-' . substr(md5(uniqid()), 0, 8); @endphp

{{-- Высота: по умолчанию 320px, переопределяется через style="height:Xpx" --}}
<div {{ $attributes->merge(['class' => 'w-full rounded-2xl shadow-lg', 'style' => 'height:320px;']) }}
     id="{{ $mapId }}">
</div>

<script>
(function () {
    var branches = [
        {
            coords:   [56.838908, 60.592641],
            title:    'Свой Мастер — Центральный офис',
            address:  'Антона Валека, 13, офис 200',
            hours:    'Пн — Вс: 10:00 — 20:00',
            routeUrl: 'https://yandex.ru/maps/?rtext=~56.838908,60.592641&rtt=auto'
        },
        {
            coords:   [56.838547, 60.691303],
            title:    'Свой Мастер — ЖБИ',
            address:  'Рассветная улица, 8/1',
            hours:    'Пн — Вс: 10:00 — 20:00',
            routeUrl: 'https://yandex.ru/maps/?rtext=~56.838547,60.691303&rtt=auto'
        }
    ];

    function initMap(containerId) {
        ymaps.ready(function () {
            var el = document.getElementById(containerId);
            if (!el) return;

            var map = new ymaps.Map(containerId, {
                center: [56.838727, 60.641972],
                zoom: 11,
                controls: ['zoomControl', 'fullscreenControl', 'geolocationControl']
            });

            branches.forEach(function (b) {
                var body =
                    '<div style="font-family:Inter,sans-serif;min-width:230px;padding:2px 0">' +
                        '<p style="margin:0 0 4px;color:#555;font-size:13px">&#128205; ' + b.address + '</p>' +
                        '<p style="margin:0 0 12px;color:#555;font-size:12px">&#128336; ' + b.hours + '</p>' +
                        '<div style="display:flex;gap:8px">' +
                            '<a href="' + b.routeUrl + '" target="_blank" ' +
                               'style="flex:1;background:#0678A8;color:#fff;text-align:center;padding:9px 12px;' +
                                      'border-radius:10px;font-size:13px;font-weight:600;text-decoration:none;display:block">' +
                               'Маршрут</a>' +
                            '<a href="tel:+73432264622" ' +
                               'style="flex:1;border:1.5px solid #0678A8;color:#0678A8;text-align:center;padding:9px 12px;' +
                                      'border-radius:10px;font-size:13px;font-weight:600;text-decoration:none;display:block">' +
                               'Позвонить</a>' +
                        '</div>' +
                    '</div>';

                map.geoObjects.add(new ymaps.Placemark(
                    b.coords,
                    {
                        balloonContentHeader: '<b style="font-family:Inter,sans-serif;font-size:14px;color:#1a1a1a">' + b.title + '</b>',
                        balloonContentBody:   body,
                        hintContent:          b.title
                    },
                    {
                        preset:                'islands#blueDotIconWithCaption',
                        iconCaptionMaxWidth:   '200',
                        balloonCloseButton:    true,
                        hideIconOnBalloonOpen: false
                    }
                ));
            });
        });
    }

    // Загружаем ymaps API один раз, остальные экземпляры просто ставятся в очередь
    if (!window._ymapsQueue) {
        window._ymapsQueue = [];
    }
    window._ymapsQueue.push('{{ $mapId }}');

    if (!window._ymapsLoaded) {
        window._ymapsLoaded = true;
        var s = document.createElement('script');
        s.src = 'https://api-maps.yandex.ru/2.1/?lang=ru_RU&onload=_ymapsOnLoad';
        document.head.appendChild(s);

        window._ymapsOnLoad = function () {
            (window._ymapsQueue || []).forEach(function (id) {
                initMap(id);
            });
        };
    } else if (window.ymaps) {
        // API уже загружен — инициализируем сразу
        initMap('{{ $mapId }}');
    }
    // Если API грузится прямо сейчас, id уже в очереди и будет обработан в _ymapsOnLoad
}());
</script>

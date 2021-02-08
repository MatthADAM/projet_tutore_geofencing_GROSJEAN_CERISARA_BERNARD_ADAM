
function initialize() {
    var map = L.map('map').setView([48.6309538, 6.1067854], 16); // LIGNE 18

    var osmLayer = L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', { // LIGNE 20
        attribution: '© OpenStreetMap contributors',
        maxZoom: 19
    });

    map.addLayer(osmLayer);

    var popup = L.popup();

    var index = 0;
    var tabPts = [];
    var zoneId;
    var zone = false;
    var mapMarkers = [];
    $.get("http://localhost:8001/api/zone").then((result) => {
        result.data.forEach(e => {
            $.get("http://localhost:8001/api/points").then((results) => {
                results.data.forEach(el => {
                    if (e.id_zone == el.id_zone) {
                        tabPts.push([el.x, el.y]);
                    }
                });
                if (tabPts.length > 2) {
                    L.polygon(tabPts, { color: 'red' }).addTo(map);
                }
                tabPts = [];
            });
        })

    });

    function addZone() {
        if (!zone) {
            $.post("http://localhost:8001/api/zone", { nom: "ZONE TEST", description: "ZONE TEST" })
                .done(function (data) {
                    zoneId = data.data.id_zone;
                    index = 0;
                    tabPts = [];
                    zone = true;
                    console.log("Zone créer" + zone);

                });
        }
    }
    function endZone() {
        if (zone && tabPts.length > 2) {
            console.log("End zone")
            L.polygon(tabPts, { color: 'red' }).addTo(map);
            for (let i = 0; i < mapMarkers.length; i++) {
                map.removeLayer(mapMarkers[i]);
            }
            zone = false;
        }
    }
    function onMapClick(e) {
        if (zone) {
            console.log("New Point")
            tabPts.push([e.latlng.lat, e.latlng.lng]);
            index++;
            var marker = L.marker(tabPts[tabPts.length - 1]).addTo(map);
            mapMarkers.push(marker);
            $.post("http://localhost:8001/api/points", { id_zone: zoneId, x: e.latlng.lat, y: e.latlng.lng });
        }
    }

    map.on('click', onMapClick);
    document.getElementById("submit").addEventListener("click", addZone);
    document.getElementById("submit2").addEventListener("click", endZone);
}

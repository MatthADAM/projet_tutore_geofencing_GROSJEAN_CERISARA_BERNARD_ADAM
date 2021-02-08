
function initialize() {
    var map = L.map('map').setView([48.6309538, 6.1067854], 16); // LIGNE 18

    var osmLayer = L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', { // LIGNE 20
        attribution: '© OpenStreetMap contributors',
        maxZoom: 19
    });

    map.addLayer(osmLayer);

    var popup = L.popup();
    var tabPts = [];
    var tabPts2 = [];
    var zoneId;
    var zone = false;
    var mapMarkers = [];
    $.get("http://localhost:8001/api/zone").then((result) => {
        result.data.forEach(e => {
            let id = e.id_zone
            let nom = e.nom;
            let desc = e.description;
            let info = `<p>
            idZone: ${id}</br>  
            Nom: ${nom}</br>
            Description: ${desc}</br></br></p>`;
            document.getElementById("listZone").innerHTML += info;
                $.get("http://localhost:8001/api/points").then((results) => {
                    results.data.forEach(el => {
                        if (e.id_zone == el.id_zone) {
                            tabPts2.push([el.x, el.y]);
                        }
                    });
                    if (tabPts2.length > 2) {
                        L.polygon(tabPts2, { color: 'red' }).addTo(map);
                    }
                    tabPts2 = [];
                });
        })
        tabPts2 = [];
    });

    function addZone() {
        if (!zone && document.getElementById("nom").value != "" && document.getElementById("description").value != "") {
            let nom = document.getElementById("nom").value;
            let desc = document.getElementById("description").value;
            $.post("http://localhost:8001/api/zone", { nom: nom, description: desc })
                .done(function (data) {
                    zoneId = data.data.id_zone;
                    tabPts = [];
                    zone = true;
                    console.log("Zone créer " + zone);

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
            console.log(tabPts)
            tabPts = [];
            zone = false;
        }
    }
    function onMapClick(e) {
        if (zone) {
            console.log("New Point")
            let x = e.latlng.lat;
            let y = e.latlng.lng;
            $.post("http://localhost:8001/api/points", { id_zone: zoneId, x: x, y: y });
            tabPts.push([x, y]);
            var marker = L.marker(tabPts[tabPts.length - 1]).addTo(map);
            mapMarkers.push(marker);
        }
    }

    map.on('click', onMapClick);
    document.getElementById("submit").addEventListener("click", addZone);
    document.getElementById("submit2").addEventListener("click", endZone);
}


function initialize() {
    let api = "http://localhost:8001";
    var map = L.map('map').setView([48.6309538, 6.1067854], 16); // LIGNE 18

    var osmLayer = L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', { // LIGNE 20
        attribution: '© OpenStreetMap contributors',
        maxZoom: 19
    });

    map.addLayer(osmLayer);
    L.popup();

    let tabPts = [];
    let tabPts2 = [];
    let polygon = [];
    let mapMarkers = [];
    let zoneId;
    let polyg;
    let idZ;
    let zone = false;
    let finish = false;


    //Function quand on clique sur un polygon
    var onPolyClick = function (event) {
        idZ = event.target.options.id;
        console.log("Clicked");
        polyg = event.target;
        if (polyg.options.color == "blue") {
            polygon.forEach(element => {
                element.setStyle({
                    color: "red"
                })
            });
            affiAllZone();
        } else {
            polygon.forEach(element => {
                element.setStyle({
                    color: "red"
                })
            });
            event.target.setStyle({
                color: "blue"
            })
            $.get(api + "/api/zone/" + idZ).then((e) => {
                let nom = e.data.nom;
                let desc = e.data.description;
                let res = affiListZone(nom, desc);
                $.get(api + "/api/infos/zone/" + idZ).then((results) => {
                    results.data.forEach(el => {
                        res += affiInfoZone(el.contenu);
                    })
                    res += "</div>";
                    res += affiModifZone();
                    res += affiAddInfoZone();
                    document.getElementById("listZone").innerHTML = res;
                    document.getElementById("submit3").addEventListener("click", modifZone);
                    document.getElementById("submit4").addEventListener("click", deleteZone);
                    document.getElementById("submit5").addEventListener("click", updateInfoZone);
                });
            });
        }
    };
    //Fonction clique sur la map
    function onMapClick(e) {
        if (!zone) {
            if (polygon != [])
                clickable();
        }
        else {
            console.log("New Point")
            let x = e.latlng.lat;
            let y = e.latlng.lng;
            $.post(api + "/api/points", { id_zone: zoneId, x: x, y: y });
            tabPts.push([x, y]);
            var marker = L.marker(tabPts[tabPts.length - 1]).addTo(map);
            mapMarkers.push(marker);
        }
    }
    //Function qui détermine quelle polygon est sélectionné
    function clickable() {
        if (finish) {
            polygon.forEach(element => {
                element.on('click', onPolyClick);
            });
        }
    }
    //Function affichage liste de toutes les zones
    function affiAllZone() {
        for(i in map._layers) {
            if(map._layers[i]._path != undefined) {
                try {
                    map.removeLayer(map._layers[i]);
                }
                catch(e) {
                    console.log("problem with " + e + map._layers[i]);
                }
            }
        }
        $.get(api + "/api/zone").then((result) => {
            document.getElementById("listZone").innerHTML = "";
            result.data.forEach(e => {
                let id = e.id_zone
                let nom = e.nom;
                let desc = e.description;
                let res = affiListZone(nom, desc);
                document.getElementById("listZone").innerHTML += res;
                $.get(api + "/api/points/zone/" + id).then((results) => {
                    results.data.forEach(el => {
                        if (e.id_zone == el.id_zone) {
                            tabPts2.push([el.x, el.y]);
                        }
                    });
                    if (tabPts2.length > 2) {
                        polyg = L.polygon(tabPts2, { color: 'red', id: id });
                        polyg.addTo(map);
                        polygon.push(polyg)
                    }
                    tabPts2 = [];
                });
            })
            finish = true;
            tabPts2 = [];
        });
    }
    //Function affichage de la zone sélectionné
    function affiListZone(nom, desc) {
        let res = `<div id="info"><p>
        Nom: ${nom}</br>
        Description: ${desc}</br></br></p></div>
        <div id="informationZone">`;
        return res;
    }
    //Function affichage informations de la zone sélectionné
    function affiInfoZone(info) {
        let res = `<p>
        Information: ${info}
        </br></p>`;
        return res;
    }
    //Function affichage formulaire Modification zone
    function affiModifZone() {
        let res = `
        <form onsubmit="return false">
                <div>
                    <input type="text" id="nom2" placeholder="Nom..." required>
                </div>
                <div>
                    <input type="text" id="description2" placeholder="Description..." required>
                </div>
                <input id="submit3" type="submit" value="modifier zone">
                </form>
                <input id="submit4" type="submit" value="supprimer zone">`
            ;
        return res;
    }
    //Function affichage formulaire ajout d'information a une zone
    function affiAddInfoZone() {
        let res = `
        <form onsubmit="return false">
                <div>
                    <input type="text" id="contenu" placeholder="Information..." required>
                </div>
                <input id="submit5" type="submit" value="Ajouter information">
                </form>`
            ;
        return res;
    }

    //Function ajout de zone
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
    //Function modification information zone
    function updateInfoZone() {
        let info = document.getElementById("contenu").value;
        document.getElementById("contenu").value = "";
        $.post(api + "/api/infos", { id_zone: idZ, type: "text", contenu: info })
        res = affiInfoZone(info);
        document.getElementById("informationZone").innerHTML += res;
    }
    //Function modification zone
    function modifZone() {
        let nom = document.getElementById("nom2").value;
        let desc = document.getElementById("description2").value;
        $.post(api + "/api/zone/" + idZ, { nom: nom, description: desc })
        res = affiListZone(nom, desc);
        document.getElementById("info").innerHTML = res;
    }
    //Function suppression zone
    function deleteZone() {
        let index = 0;
        $.get(api + "/api/points/zone/" + idZ).then((results) => {
            results.data.forEach(el => {
                $.ajax({
                    url: api + "/api/points/" + el.id_point,
                    type: 'DELETE',
                    success: function (result) {
                        index++;
                        if (index == results.data.length) {
                            $.ajax({
                                url: api + "/api/zone/" + idZ,
                                type: 'DELETE',
                                success: function (result) {
                                    console.log("Delete Zone");
                                    map.removeLayer(polyg);
                                }
                            });
                        }
                        console.log("Delete points");
                    }
                });

            });
            console.log(results.data.length);
        });
    }
    //Function fin de la création de la zone
    function endZone() {
        if (zone && tabPts.length > 2) {
            console.log("End zone")
            L.polygon(tabPts, { color: 'red' }).addTo(map);
            for (let i = 0; i < mapMarkers.length; i++) {
                map.removeLayer(mapMarkers[i]);
            }
            tabPts = [];
            zone = false;
            
            affiAllZone();
        }
    }

    affiAllZone();
    map.on('click', onMapClick);
    document.getElementById("submit").addEventListener("click", addZone);
    document.getElementById("submit2").addEventListener("click", endZone);

}

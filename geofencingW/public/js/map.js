
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
                let res ="</br>";
                let text = affiListZone(nom, desc);
                $.get(api + "/api/infos/zone/" + idZ).then((results) => {
                    results.data.forEach(el => {
                        text += affiInfoZone(el.contenu,el.type);
                    })
                    res += affiModifZone();
                    res += affiAddInfoZone();
                    res += affiMobile(idZ);
                    document.getElementById("listZone").innerHTML = text;
                    document.getElementById("formulaire2").innerHTML = res;
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
                if (finish) {
                    polygon.forEach(element => {
                        element.on('click', onPolyClick);
                    });
                }
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
    //Function affichage liste de toutes les zones
    function affiAllZone() {
        document.getElementById("formulaire2").innerHTML="";
        for (i in map._layers) {
            if (map._layers[i]._path != undefined) {
                try {
                    map.removeLayer(map._layers[i]);
                }
                catch (e) {
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
    function affiInfoZone(info,type) {
        let res = `<p>
        Type:  ${type};
        Information: ${info}
        </br></p>`;
        return res;
    }
    //Function affichage formulaire Modification zone
    function affiModifZone() {
        let res = `</br>
        <form onsubmit="return false">
                <div>
                    <input type="text" id="nom2" placeholder="Nom...">
                </div>
                <div>
                    <input type="text" id="description2" placeholder="Description...">
                </div>
                <input id="submit3" type="submit" value="modifier zone">
                </form>
                <input id="submit4" type="submit" value="supprimer zone">
                </br>`
            ;
        return res;
    }
    //Function affichage formulaire ajout d'information a une zone
    function affiAddInfoZone() {
        let res = `</br>
        <form onsubmit="return false">
                <label for="type-select"> type d'information?:</label>
                <select name="type" id="type-select">
                    <option value="text">Texte</option>
                    <option value="image">Image</option>
                    <option value="video">Vidéo</option>
                </select>
                <div>
                    <input type="text" id="contenu" placeholder="Information..." required>
                </div>
                </br>
                <input id="submit5" type="submit" value="Ajouter information">
                </form></br>`
            ;
        return res;
    }
    function affiMobile(idZone) {
        let res = `
        <button onClick="window.open('/mobile/${idZone}','_blank')">Aperçu mobile</button></br>`
            ;
        return res;
    }
    function mdToHtml(str) {
        var tempStr = str;
        while (tempStr.indexOf("**") !== -1) {
            var firstPos = tempStr.indexOf("**");
            var nextPos = tempStr.indexOf("**", firstPos + 2);
            if (nextPos !== -1) {
                var innerTxt = tempStr.substring(firstPos + 2, nextPos);
                var strongified = '<strong>' + innerTxt + '</strong>';
                tempStr = tempStr.substring(0, firstPos) + strongified + tempStr.substring(nextPos + 2, tempStr.length);
                //get rid of unclosed '**'
            } else {
                tempStr = tempStr.replace('**', '');
            }
        }
        while (tempStr.indexOf("*") !== -1) {
            var firstPos = tempStr.indexOf("*");
            var nextPos = tempStr.indexOf("*", firstPos + 1);
            if (nextPos !== -1) {
                var innerTxt = tempStr.substring(firstPos + 1, nextPos);
                var italicized = '<i>' + innerTxt + '</i>';
                tempStr = tempStr.substring(0, firstPos) + italicized + tempStr.substring(nextPos + 2, tempStr.length);
                //get rid of unclosed '*'
            } else {
                tempStr = tempStr.replace('*', '');
            }
        }
        return tempStr;
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
        let type=document.getElementById("type-select").value;
        let info = document.getElementById("contenu").value;
        switch (type) {
            case 'image':
                info=`<img src='${info}'width="150">`
                break;
            case 'video':
                info=`<iframe width="150" height="150"
                src="${info}">
                </iframe>`
                break;
            case 'text':
                info = mdToHtml(info);
              break;
            default:
              console.log(`Sorry, we are out of ${expr}.`);
          }
        document.getElementById("contenu").value = "";
        $.post(api + "/api/infos", { id_zone: idZ, type: type, contenu: info })
        res = affiInfoZone(info,type);
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
        $.get(api + "/api/infos/zone/" + idZ).then((results) => {
            results.data.forEach(el => {
                $.ajax({
                    url: api + "/api/infos/" + el.id_info,
                    type: 'DELETE',
                    success: function (result) {
                        console.log("Delete Informations");
                    }
                });

            });
        });
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
                                    affiAllZone();
                                }
                            });
                        }
                        console.log("Delete points");
                    }
                });

            });

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

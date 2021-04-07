function initialize() {
    let id = $('.js-id').data('isId');
    let api = "http://localhost:8001";

    function affiInfoZone(info, id) {
        let res = `${info}`;
        return res;
    }

    function afficherNomDesc(nom, desc) {
        let res = `<div id="top"><b>Nom de la zone : </b>${nom}
        <br/><b>description : </b>${desc}
        <br/></div>`;
        return res;
    }

    let content = "";

    $.get(api + "/api/zone/" + id).then((result) => {
        content += afficherNomDesc(result.data.nom, result.data.description);
        $.get(api + "/api/infos/zone/" + id).then((results) => {
            results.data.forEach(el => {
                content += affiInfoZone(el.contenu, el.id_info);
            })
            document.getElementById("infosZone").innerHTML += content;
        })
    })
};
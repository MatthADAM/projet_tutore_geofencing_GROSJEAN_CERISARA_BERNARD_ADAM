function initialize() {
    let id = $('.js-id').data('isId');
    let api = "http://localhost:8001";

    function affiInfoZone(info, id) {
        let res = `${info}`;
        return res;
    }
    $.get(api + "/api/infos/zone/" + id).then((results) => {
        let text="";
        results.data.forEach(el => {
            text += affiInfoZone(el.contenu, el.id_info);
        })
        document.getElementById("listZone").innerHTML = text;

    })
};
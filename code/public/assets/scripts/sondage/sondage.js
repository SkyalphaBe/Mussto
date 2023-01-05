import Loader from "/assets/scripts/component/loader.js";

if (id){
    var section = document.getElementById("delete-section");
    var loader = Loader();
    section.appendChild(loader);
    var button = document.getElementById("delete-button");

    button.onclick = () => {
        loader.show();
        if (window.confirm("Etes vous sur de vouloir supprimer ce sondage?")){
            var header = {
                method : "DELETE"
            }
            fetch("/api/sondage/delete-"+id, header).then(res => {
                if (res.ok){
                    return res.text();
                } else {
                    return res.text().then(text => {throw new Error(text)});
                }
            }).then(text => {
                location.replace(text);
            }).catch(err => {
                loader.hide();
                console.error(err);
            })
        } else {
            loader.hide();
        }
    }   
} else {
    console.error("id manquant");
}

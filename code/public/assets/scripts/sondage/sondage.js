import Loader from "/assets/scripts/component/loader.js";

if (id){
    var delete_section = document.getElementById("delete-section");
    var delete_loader = Loader();
    delete_section.appendChild(delete_loader);
    var delete_button = document.getElementById("delete-button");

    delete_button.onclick = () => {
        delete_loader.show();
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
                delete_loader.hide();
                console.error(err);
            })
        } else {
            delete_loader.hide();
        }
    }   

    var show_section = document.getElementById("show-section");
    var show_loader = Loader();
    show_section.appendChild(show_loader);
    var show_button = document.getElementById("show-button");

    show_button.onclick = () => {
        show_loader.show();
        ////api/sondage/change-visibility-[:id]
        var header = {
            method : 'POST', 
            headers: {
            'Content-Type': 'application/json'
            },
            body : JSON.stringify({show : show_button.value})
        }
        fetch("/api/sondage/change-visibility-"+id, header).then(res => {
            if (res.ok){
                location.reload();
            } else {
                return res.text().then(text => {throw new Error(text)});
            }
        }).catch(err => {
            console.error(err);
        })
    }
} else {
    console.error("id manquant");
}

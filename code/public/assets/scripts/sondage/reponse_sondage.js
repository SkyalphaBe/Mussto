import Loader from "/assets/scripts/component/loader.js";
import Message from "/assets/scripts/component/message.js";

if (id){
    var form = document.getElementById("form");
    var loader = Loader();
    var mess = Message();
    form.appendChild(loader);
    form.appendChild(mess);
    
    var submit = () => {
        var inputs = document.getElementsByClassName("res-sondage");
        var data = {};
        Array.from(inputs).forEach(elt => {
            if (elt.value){
                data[elt.name] = elt.value;
            }
        });
    
        loader.show();

        var header = {
            method : 'POST', 
            headers: {
            'Content-Type': 'application/json'
            },
            body : JSON.stringify(data)
        }

        fetch("/api/update-rep-sondage-"+id, header).then(res => {
            loader.hide();
            if (res.ok){
                mess.showMessage("Votre réponse a bien été enregitré");
            } else {   
                return res.text().then(text => {throw new Error(text)});
            }
        }).catch(err => {
            console.error(err);
            mess.showMessage("Erreur dans l'enregistrement");
        })
    }
    
    var button = document.getElementById("sondage-submit");
    button.onclick = submit;
}
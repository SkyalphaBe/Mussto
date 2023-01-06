let sondages = document.getElementsByClassName("sondage");
for(let i=0;i<sondages.length;i++){
    box = document.createElement("DIV")
    sondages[i].append(box)
    box.setAttribute("id", "reponse");
    input = document.createElement("INPUT")
    box.appendChild(input);
    id = box.parentNode.id
    getReponse(id, input);
    bouton = box.appendChild(document.createElement("BUTTON"));
    bouton.textContent = "Envoyer";
    bouton.addEventListener("click", sendSondage);
}


function sendSondage(event){
    msg = event.target.parentNode.getElementsByTagName("input")[0].value
    id = event.target.parentNode.parentNode.id

    var header = {
        method : 'POST', 
        headers: {
            'Content-Type': 'application/json'
        },
        body : JSON.stringify({
            msg : msg
        })
    }
    fetch("/api/update-rep-sondage-"+id, header).then(res => res.text()).then(text => {console.log(text)});
}


function getReponse(id, input){
    var header = {
        method : 'GET', 
        headers: {
            'Content-Type': 'application/json'
        }
    }
    fetch("/api/get-rep-sondage-"+id, header).then(res => res.json()).then(json => {
        if(json != false){
            input.value = json["CONTENUREPONSE"]
        }
    });
}
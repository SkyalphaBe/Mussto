import {Utilisateur} from "./utilisateur.js";
const content = document.getElementsByClassName("content")[0];


fetch("/api/listeUtilisateur").then(res =>{
    if (res.ok){
        return res.json();
    }else {
        throw new Error(res.status);
    }
}).then(json => {
    json.forEach(elem =>{
        let user = new Utilisateur(elem);
        createLineEtu(user);
        /*console.log(user);*/
    });

}).catch(err =>{
    console.error(err);
});

function createLineEtu(user){
    let newElem = document.createElement("div");
    let newNom = document.createElement("h3");
    let newPrenom = document.createElement("h3");
    let newBtn = document.createElement("button");

    newElem.className = "userElement";

    newPrenom.className = "attribute";
    newPrenom.textContent = user.prenom;

    newNom.className = "attribute";
    newNom.textContent = user.nom;

    newBtn.className = "btnUser";
    newBtn.textContent = "gérer";

    newElem.appendChild(newPrenom);
    newElem.appendChild(newNom);
    newElem.appendChild(newBtn);
    content.appendChild(newElem);
}
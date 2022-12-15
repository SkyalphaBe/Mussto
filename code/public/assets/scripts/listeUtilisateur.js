import {Etudiant} from "./Etudiant.js";
import {Professeur} from "./Professeur.js";

const content = document.getElementsByClassName("content")[0];
const radioChoix = document.querySelectorAll('input[type="radio"]');


window.onload = update();

radioChoix.forEach(elem=>{
    elem.addEventListener("click",()=>{
        update();
    });
});


function update(){
    content.innerHTML = "";
    radioChoix.forEach(elem =>{
        if(elem.checked){
            console.log(elem.value)
            fetch(elem.value).then(res =>{
                if (res.ok){
                    return res.json();
                }else {
                    throw new Error(res.status);
                }
            }).then(json => {
                json.forEach(line =>{
                    if(elem.value == "/api/listeEtu"){
                        let user = new Etudiant(line);
                        createLineEtu(user);
                    }
                    if(elem.value == "/api/listeProfesseur"){
                        let user = new Professeur(line);
                        createLineEtu(user);
                    }

                });

            }).catch(err =>{
                console.error(err);
            });
        }
    });
}

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
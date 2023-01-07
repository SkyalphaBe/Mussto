import {Etudiant} from "./Etudiant.js";
import {Professeur} from "./Professeur.js";
import {generateFormGestion} from "./modifUser.js";

const content = document.getElementsByClassName("content")[0];
const radioChoix = document.querySelectorAll('input[type="radio"]');
const creerBtn = document.getElementsByTagName('button')[0];
const topBox = document.getElementsByClassName('topBoxUsr')[0];

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
                json.user.forEach(line =>{
                    if(elem.value == "/api/listeEtu"){

                        let user = new Etudiant(line);
                        createLineEtu(user,"Etudiant",json.groups);
                    }
                    else if(elem.value == "/api/listeProfesseur"){
                        let user = new Professeur(line);
                        createLineEtu(user,"Professeur",json.module,json.assigns);
                    }
                });

            }).catch(err =>{
                console.error(err);
            });
        }
    });
}

function createLineEtu(user,typeCompte,assignList,defaultAssign=null){
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

    newBtn.addEventListener('click',()=>{
        generateFormGestion(user,typeCompte,assignList,defaultAssign);
        modificationTopBox(typeCompte);
    });
}

function modificationTopBox(typeCompte){
    let retourBtn = document.createElement('button');

    retourBtn.textContent='Retour';
    retourBtn.onclick=()=>{
        creerBtn.style.display = 'Block';
        radioChoix.forEach(elem =>{
            elem.parentElement.style.display = 'flex';
        })
        topBox.children[0].textContent="Utilisateur";
        retourBtn.remove();
        update();
    };

    topBox.appendChild(retourBtn);

    creerBtn.style.display = 'None';
    radioChoix.forEach(elem =>{
        elem.parentElement.style.display = 'None';
    });
    topBox.children[0].textContent=typeCompte;

}
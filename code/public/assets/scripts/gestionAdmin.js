import {Etudiant} from "./Etudiant.js";
import {Professeur} from "./Professeur.js";

const content = document.getElementsByClassName("content")[0];
const radioChoix = document.querySelectorAll('input[type="radio"]');
const btnCreerGroupe = document.getElementById("btnCreer");
const checkBox = document.getElementsByClassName("check")[0];
const topBoxUsr = document.getElementsByClassName("topBoxUsr")[0];


window.onload = update();

radioChoix.forEach(elem=>{
    elem.addEventListener("click",()=>{
        update();
    });
});

btnCreerGroupe.addEventListener("click",()=>{
    btnCreerGroupe.style.display="none";
    checkBox.style.display="none";
    content.style.flexDirection="row";
    content.style.height="80vh";
    creerCompte();
    creerCompteExcel();

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
                        createLine(user);
                    }
                    else if(elem.value == "/api/listeProfesseur"){
                        let user = new Professeur(line);
                        createLine(user);
                    }
                    else{
                        createLineGroup(line);
                    }
                });

            }).catch(err =>{
                console.error(err);
            });
        }
    });
}

function createLine(user){
    let newElem = document.createElement("div");
    let newNom = document.createElement("h3");
    let newPrenom = document.createElement("h3");
    let newBtn = document.createElement("button");
    let attribute = document.createElement("div");

    newElem.className = "userElement";

    newPrenom.className = "attribute";
    newPrenom.textContent = user.prenom;

    newNom.className = "attribute";
    newNom.textContent = user.nom;

    newBtn.className = "btnUser";
    newBtn.textContent = "gérer";

    attribute.className = "attribute";

    attribute.appendChild(newPrenom);
    attribute.appendChild(newNom);
    newElem.appendChild(attribute);
    newElem.appendChild(newBtn);
    content.appendChild(newElem);
}

function createLineGroup(group){
    let newDiv= document.createElement('div');
    let intitule = document.createElement('h3');
    let annee = document.createElement('h3');
    let newBtn = document.createElement('button');

    newDiv.className = "userElement";

    intitule.className = "attribute";
    intitule.textContent = group.INTITULEGROUPE;

    annee.className = "attribute";
    annee.textContent = group.ANNEEGROUPE;

    newBtn.className='btnUser';
    newBtn.textContent='supprimer';

    newDiv.appendChild(intitule);
    newDiv.appendChild(annee);
    newDiv.appendChild(newBtn);
    content.appendChild(newDiv);
}

function creerCompte(){
    let templateForm = document.querySelector("template");
    content.replaceChildren(templateForm.content.cloneNode(true));

    let btnRetour = document.createElement("button");
    btnRetour.textContent="retour";

    topBoxUsr.appendChild(btnRetour);

    btnRetour.addEventListener("click",()=>{
        btnCreerGroupe.style.display="block";
        checkBox.style.display="flex";
        content.style.flexDirection="column";``
        topBoxUsr.removeChild(btnRetour);
        update();
    });
}

function creerCompteExcel(){
    let templateExcel = document.querySelectorAll("template")[1];
    content.appendChild(templateExcel.content.cloneNode(true));
}
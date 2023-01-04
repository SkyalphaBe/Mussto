import {Etudiant} from "./Etudiant.js";
import {Professeur} from "./Professeur.js";

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
                json.forEach(line =>{
                    if(elem.value == "/api/listeEtu"){
                        let user = new Etudiant(line);
                        createLineEtu(user,"ETUDIANT");
                    }
                    else if(elem.value == "/api/listeProfesseur"){
                        let user = new Professeur(line);
                        createLineEtu(user,"PROFESSEUR");
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

function createLineEtu(user,typeCompte){
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
        generateFormGestion(user,typeCompte);
    });
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

function generateFormGestion(user,typeCompte){
    let form = document.createElement('form');
    let inputLogin = document.createElement('input');
    let inputNom = document.createElement('input');
    let inputFirstName = document.createElement('input');
    let inputMdp = document.createElement('input');
    let inputType = document.createElement('input');
    let inputValide = document.createElement('input');
    let labelLogin = document.createElement('label');
    let labelNom = document.createElement('label');
    let labelFirstName = document.createElement('label');
    let labelMdp = document.createElement('label');
    let deleteBtn = document.createElement('button');

    form.method='POST';

    labelLogin.textContent = 'Login';
    inputLogin.name = 'newlogin';
    inputLogin.type = 'text';
    inputLogin.value = user.login;

    labelFirstName.textContent = 'Prenom';
    inputFirstName.name = 'prenom';
    inputFirstName.type = 'text';
    inputFirstName.value = user.prenom;

    labelNom.textContent = 'Nom';
    inputNom.name = 'nom';
    inputNom.type = 'text';
    inputNom.value = user.nom;

    labelMdp.textContent = 'Mot de passe';
    inputMdp.name = 'mdp';
    inputMdp.type = 'text';

    inputType.name = 'type';
    inputType.type = 'text';
    inputType.value = typeCompte;
    inputType.hidden = true;

    inputValide.type = 'submit';

    content.innerHTML="";

    deleteBtn.textContent = "supprimer";
    deleteBtn.addEventListener('click', async ()=>{
            await deleteUser(user.login,typeCompte);
    });

    labelLogin.appendChild(inputLogin);
    labelFirstName.appendChild(inputFirstName);
    labelNom.appendChild(inputNom);
    labelMdp.appendChild(inputMdp);
    form.appendChild(labelLogin);
    form.appendChild(labelFirstName);
    form.appendChild(labelNom);
    form.appendChild(labelMdp);
    form.appendChild(inputType);
    form.appendChild(inputValide);

    content.appendChild(form);
    content.appendChild(deleteBtn);

    modificationTopBox();
}

function modificationTopBox(){
    let retourBtn = document.createElement('button');

    retourBtn.textContent='Retour';
    retourBtn.onclick=()=>{
        creerBtn.style.display = 'Block';
        radioChoix.forEach(elem =>{
            elem.parentElement.style.display = 'flex';
        })
        retourBtn.remove();
        update();
    };

    topBox.appendChild(retourBtn);

    creerBtn.style.display = 'None';
    radioChoix.forEach(elem =>{
        elem.parentElement.style.display = 'None';
    });

}

async function deleteUser(login,typeCompte){
    let header = {
        method : 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body : JSON.stringify([login,typeCompte])
    }

    let request = await fetch("/api/deleteUser", header);
    if (request.ok){
        let json = await request.json();
        console.log(json);

        if(json["code"] === 200){
            let validation = document.createElement("p");
            validation.textContent="Suppression du compte réussi";
            validation.style.color="green";
            validation.id="validation";
            content.appendChild(validation);
        }
    }
    else{
        console.log('marche pas');
    }


}
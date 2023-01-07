import {Etudiant} from "./Etudiant.js";
import {Professeur} from "./Professeur.js";

const content = document.getElementsByClassName("content")[0];
const radioChoix = document.querySelectorAll('input[type="radio"]');
const creerBtn = document.getElementsByTagName('button')[0];
const topBox = document.getElementsByClassName('topBoxUsr')[0];

var idModule = 0;

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
                        createLineEtu(user,"Professeur",json.module);
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

function createLineEtu(user,typeCompte,assignList){
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
        generateFormGestion(user,typeCompte,assignList);
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

function generateFormGestion(user,typeCompte,assignList){
    let form = document.createElement('form');
    let inputNom = document.createElement('input');
    let inputFirstName = document.createElement('input');
    let inputType = document.createElement('input');
    let inputLogin = document.createElement('input');
    let inputValide = document.createElement('input');
    let labelNom = document.createElement('label');
    let labelFirstName = document.createElement('label');
    let deleteBtn = document.createElement('button');
    let labelAssign = document.createElement('label');

    form.method='POST';

    labelFirstName.textContent = 'Prenom';
    inputFirstName.name = 'prenom';
    inputFirstName.type = 'text';
    inputFirstName.value = user.prenom;

    labelNom.textContent = 'Nom';
    inputNom.name = 'nom';
    inputNom.type = 'text';
    inputNom.value = user.nom;

    inputType.name = 'type';
    inputType.type = 'text';
    inputType.value = typeCompte.toUpperCase();
    inputType.hidden = true;

    inputLogin.name = 'login';
    inputLogin.type = 'text';
    inputLogin.value = user.login;
    inputLogin.hidden = true;

    if(typeCompte == "Etudiant"){
        let selectAssign = document.createElement('select');

        labelAssign.textContent = 'Groupe';
        selectAssign.name = 'groups';
        for(let i = 0; i<assignList.length;i++){
            let option = document.createElement('option');
            option.value = assignList[i].INTITULEGROUPE;
            option.textContent = assignList[i].INTITULEGROUPE;
            selectAssign.appendChild(option);
        }

        labelAssign.appendChild(selectAssign);
    }
    else{

        labelAssign.textContent = 'Module';

        labelAssign.appendChild(createSelectTeacher(assignList));
        labelAssign.appendChild(generateAddBtn(assignList));
    }

    inputValide.type = 'submit';

    content.innerHTML="";

    deleteBtn.textContent = "supprimer";
    deleteBtn.addEventListener('click', async ()=>{
            await deleteUser(user.login,typeCompte.toUpperCase());
    });

    labelFirstName.appendChild(inputFirstName);
    labelNom.appendChild(inputNom);

    form.appendChild(labelFirstName);
    form.appendChild(labelNom);
    form.appendChild(inputType);
    form.appendChild(labelAssign);
    form.appendChild(inputLogin);
    form.appendChild(inputValide);

    content.appendChild(form);
    content.appendChild(deleteBtn);

    modificationTopBox(typeCompte);
}


function generateAddBtn(assignList){
    let addBtn = document.createElement('button');

    addBtn.textContent='+';
    addBtn.type='button';
    addBtn.addEventListener('click', (evt)=>{
        if(addBtn.parentElement.children.length<(assignList.length)+1)
            // if(addBtn.parentElement.children.[(addBtn.parentElement.children.length)-1]==addBtn)
            //     generateRemoveBtn();
            addSelect(evt,assignList);
    });

    return addBtn;
}

function generateRemoveBtn(){
    let rmvBtn = document.createElement('button');
    rmvBtn.textContent='-';
    rmvBtn.type='button';
    rmvBtn.addEventListener('click', (evt)=>{
        if(rmvBtn.parentElement.children.length>1)
            if(rmvBtn.parentElement.children[(rmvBtn.parentElement.children.length)-2]==rmvBtn)
                generateRemoveBtn();
        Select(evt,assignList);
    });
}

function addSelect(evt,assignList){
    let newSelect = createSelectTeacher(assignList);
    evt.target.parentElement.insertBefore(newSelect,evt.target);
}

function createSelectTeacher(assignList){
    let selectAssign = document.createElement('select');
    selectAssign.name = "module"+(++idModule);
    for(let i = 0; i<assignList.length;i++){
        let option = document.createElement('option');
        option.value = assignList[i].REFMODULE;
        option.textContent = assignList[i].NOMMODULE;
        selectAssign.appendChild(option);
    }
    return selectAssign;
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
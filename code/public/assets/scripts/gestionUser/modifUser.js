const content = document.getElementsByClassName("content")[0];
var idSelect = 0;

function generateFormGestion(user,typeCompte,assignList,defaultAssign){
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
    let divFirstName = document.createElement('div');
    let divLastName = document.createElement('div');
    let divAssign = document.createElement('div');
    let divModule = document.createElement('div');

    form.method='POST';
    form.classList.add('formAdminManage');

    labelFirstName.textContent = 'Prenom';
    inputFirstName.name = 'prenom';
    inputFirstName.type = 'text';
    inputFirstName.value = user.prenom;

    divFirstName.classList.add('formContentAdminManage');

    labelNom.textContent = 'Nom';
    inputNom.name = 'nom';
    inputNom.type = 'text';
    inputNom.value = user.nom;

    divLastName.classList.add('formContentAdminManage')

    inputType.name = 'type';
    inputType.type = 'text';
    inputType.value = typeCompte.toUpperCase();
    inputType.hidden = true;

    divAssign.classList.add('formContentAdminManage')

    inputLogin.name = 'login';
    inputLogin.type = 'text';
    inputLogin.value = user.login;
    inputLogin.hidden = true;

    labelAssign.id ="assignment";

    if(typeCompte == "Etudiant"){
        let selectAssign = document.createElement('select');
        let divGroup = document.createElement('div');
        let option = document.createElement('option');

        labelAssign.textContent = 'Groupe';
        selectAssign.name = 'groups';
        option.textContent = "choisissez un groupe";
        selectAssign.appendChild(option);

        for(let i = 0; i<assignList.length;i++){
            option = document.createElement('option');
            option.value = assignList[i].INTITULEGROUPE;
            option.textContent = assignList[i].INTITULEGROUPE;
            selectAssign.appendChild(option);
        }

        selectAssign.addEventListener('change',(evt)=>{
            if(divGroup.lastElementChild!=selectAssign){
                divGroup.lastElementChild.remove()
            }
            let selectYear = createSelectYear(evt.target,assignList);
            divGroup.appendChild(selectYear);
        });
        divGroup.appendChild(selectAssign);
        labelAssign.appendChild(divGroup)
    }
    else{
        labelAssign.textContent = 'Module';

        for(let i=0;i<defaultAssign[user.login].length;i++){
            divModule.appendChild(creerSelectProf(assignList,defaultAssign[user.login][i]));
        }
        labelAssign.appendChild(generateAddBtn(assignList,divModule));
        labelAssign.appendChild(generateRemoveBtn(divModule));
        labelAssign.appendChild(divModule);

    }
    inputValide.type = 'submit';
    content.innerHTML="";

    deleteBtn.textContent = "supprimer";
    deleteBtn.className = "deleteBtn";
    deleteBtn.addEventListener('click', async ()=>{
        await deleteUser(user.login,typeCompte.toUpperCase());
    });
    labelFirstName.appendChild(inputFirstName);
    labelNom.appendChild(inputNom);

    divFirstName.appendChild(labelFirstName);
    divLastName.appendChild(labelNom);
    divAssign.appendChild(labelAssign);
    form.appendChild(divFirstName);
    form.appendChild(divLastName);
    form.appendChild(divAssign);
    form.appendChild(inputLogin);
    form.appendChild(inputType);
    form.appendChild(inputValide);

    content.appendChild(form);
    content.appendChild(deleteBtn);
}

function createSelectYear(selectParent,assignList){
    let selectYear = document.createElement('select');
    let option = document.createElement('option');

    selectYear.name = 'year';
    option.textContent = "choisissez une année";
    selectYear.appendChild(option);
    for(let i = 0; i<assignList.length;i++){
        option = document.createElement('option');
        if(assignList[i].INTITULEGROUPE==selectParent.value){
            option.value = assignList[i].ANNEEGROUPE;
            option.textContent = assignList[i].ANNEEGROUPE;
            selectYear.appendChild(option);
        }
    }
    return selectYear;
}

function generateAddBtn(list,div){
    let addBtn = document.createElement('button');
    addBtn.textContent='+';
    addBtn.type='button';
    addBtn.addEventListener('click', (evt)=>{
        if(evt.target.tagName==="BUTTON"){
            if(div.children.length<list.length)
                addSelect(list,div);
        }
    });
    return addBtn;
}

function generateRemoveBtn(div){
    let rmvBtn = document.createElement('button');
    rmvBtn.textContent='-';
    rmvBtn.type='button';
    rmvBtn.addEventListener('click', (evt)=>{
        if(evt.target.tagName==="BUTTON") {
            if (div.children.length > 1)
                removeSelect(div);
        }
    });
    return rmvBtn;
}

function addSelect(list,div){
    let newSelect = creerSelectProf(list);
    div.appendChild(newSelect);
}

function removeSelect(div){
    div.removeChild(div.lastChild);
    idSelect--;
}

function creerSelectProf(list,defaultAssign=null){
    let select = document.createElement('select');
    select.name = "affect"+(++idSelect);
    for(let i = 0; i<list.length;i++){
        let option = document.createElement('option');
        option.value = list[i].REFMODULE;
        if(defaultAssign!=null){
            if(option.value==defaultAssign.REFMODULE){
                option.setAttribute('selected','selected');
            }
        }
        option.textContent = list[i].NOMMODULE;
        select.appendChild(option);
    }
    return select;
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

const content = document.getElementsByClassName("content")[0];
var idModule = 0;

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

    form.method='POST';
    form.classList.add('formAdmin');

    labelFirstName.textContent = 'Prenom';
    inputFirstName.name = 'prenom';
    inputFirstName.type = 'text';
    inputFirstName.value = user.prenom;

    divFirstName.classList.add('formContentAdmin');

    labelNom.textContent = 'Nom';
    inputNom.name = 'nom';
    inputNom.type = 'text';
    inputNom.value = user.nom;

    divLastName.classList.add('formContentAdmin')

    inputType.name = 'type';
    inputType.type = 'text';
    inputType.value = typeCompte.toUpperCase();
    inputType.hidden = true;

    divAssign.classList.add('formContentAdmin')

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

        for(let i=0;i<defaultAssign[user.login].length;i++){
            labelAssign.appendChild(createSelectTeacher(assignList,defaultAssign[user.login][i]));
        }
        labelAssign.appendChild(generateAddBtn(assignList));
        labelAssign.appendChild(generateRemoveBtn());
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

function generateAddBtn(assignList){
    let addBtn = document.createElement('button');
    addBtn.textContent='+';
    addBtn.type='button';
    addBtn.addEventListener('click', (evt)=>{
        if(addBtn.parentElement.children.length<(assignList.length)+2)
            addSelect(evt,assignList);
    });
    return addBtn;
}

function generateRemoveBtn(){
    let rmvBtn = document.createElement('button');
    rmvBtn.textContent='-';
    rmvBtn.type='button';
    rmvBtn.addEventListener('click', (evt)=>{
        if(rmvBtn.parentElement.children.length>3)
            removeSelect(evt);
    });
    return rmvBtn;
}

function addSelect(evt,assignList){
    let newSelect = createSelectTeacher(assignList);
    evt.target.parentElement.insertBefore(newSelect,evt.target);
}

function removeSelect(evt){
    let lastSelect = evt.target.parentElement.children[(evt.target.parentElement.children.length)-3]
    evt.target.parentElement.removeChild(lastSelect);
    idModule--;
}

function createSelectTeacher(assignList,defaultAssign=null){
    let selectAssign = document.createElement('select');
    selectAssign.name = "module"+(++idModule);
    for(let i = 0; i<assignList.length;i++){
        let option = document.createElement('option');
        option.value = assignList[i].REFMODULE;
        if(defaultAssign!=null){
            if(option.value==defaultAssign.REFMODULE){
                option.setAttribute('selected','selected');
            }
        }
        option.textContent = assignList[i].NOMMODULE;
        selectAssign.appendChild(option);
    }
    return selectAssign;
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

export {generateFormGestion}
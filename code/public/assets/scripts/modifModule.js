const content = document.getElementsByClassName("content")[0];
const templateForm = document.getElementsByTagName("template")[2];

var idSelect =0;

function creerFormGestion(module,listGroupe,listeParticipant){
    let deleteBtn = document.createElement('button');
    let form = templateForm.content.children[0].cloneNode(true);
    let refModule = form.firstElementChild;
    let nomModule = form.children[1].firstElementChild.firstElementChild;
    let desc = form.children[2].firstElementChild.firstElementChild;
    let addBtn = form.children[3].firstElementChild.firstElementChild;
    let rmBtn = form.children[3].firstElementChild.children[1];
    let divSelect = form.children[3].firstElementChild.lastElementChild;

    refModule.value=module.REFMODULE;
    nomModule.value=module.NOMMODULE;
    desc.value=module.DESCRIPTIONMODULE;

    for(let i=0;i<listeParticipant[module.REFMODULE].length;i++){
        divSelect.appendChild(creerSelectModule(listGroupe,listeParticipant[module.REFMODULE][i]));
    }

    addBtn.addEventListener('click', (evt)=>{
        if(evt.target.tagName==="BUTTON"){
            if(divSelect.children.length<listGroupe.length)
                addSelect(listGroupe,divSelect);
        }
    });

    rmBtn.addEventListener('click', (evt)=>{
        if(evt.target.tagName==="BUTTON") {
            if (divSelect.children.length > 1)
                removeSelect(divSelect);
        }
    });

    deleteBtn.textContent = "supprimer";
    deleteBtn.className = "deleteBtn";

    deleteBtn.addEventListener('click', async ()=>{
        await deleteUser(module.REFMODULE);
    });

    content.replaceChildren(form);
    content.appendChild(deleteBtn);
}

function creerSelectModule(list,defaultAssign=null){
    let select = document.createElement('select');
    select.name = "affect"+(++idSelect);
    for(let i = 0; i<list.length;i++){
        let option = document.createElement('option');
        option.value = list[i].INTITULEGROUPE+"-"+list[i].ANNEEGROUPE;
        if(defaultAssign!=null){
            if(option.value==defaultAssign.INTITULEGROUPE+"-"+defaultAssign.ANNEEGROUPE){
                option.setAttribute('selected','selected');
            }
        }
        option.textContent = list[i].INTITULEGROUPE;
        select.appendChild(option);
    }
    return select;
}

function addSelect(list,div){
    let newSelect = creerSelectModule(list);
    div.appendChild(newSelect);
}

function removeSelect(div){
    div.removeChild(div.lastChild);
    idSelect--;
}

async function deleteUser(module){
    let header = {
        method : 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body : JSON.stringify([module])
    }

    let request = await fetch("/api/supprimerModule", header);
    if (request.ok){
        let json = await request.json();
        console.log(json);

        if(json["code"] === 200){
            location.reload()
        }
    }
    else{
        console.log('marche pas');
    }
}

export {creerFormGestion};
import{addSelect,removeSelect,creerSelectAffectation,idSelect} from "./gestionUser/modifUser";

const content = document.getElementsByClassName("content")[0];
const templateForm = document.getElementsByTagName("template")[2];

function creerFormGestion(listGroupe){
    let deleteBtn = document.createElement('button');
    let form = templateForm.content.children[0].cloneNode(true);
    let addBtn = form.children[3].firstElementChild.firstElementChild;
    let delBtn = form.children[3].firstElementChild.children[1];
    let divSelect = form.children[3].firstElementChild.lastElementChild;

    addBtn.addEventListener('click', (evt)=>{
        if(evt.target.tagName==="BUTTON"){
            if(divSelect.children.length<listGroupe.length)
                console.log('toto');
                addSelect(listGroupe,divSelect);
        }
    });

    delBtn.addEventListener('click', (evt)=>{
        if(evt.target.tagName==="BUTTON") {
            if (divSelect.children.length > 1)
                removeSelect(divSelect);
        }
    });

    deleteBtn.textContent = "supprimer";
    deleteBtn.className = "deleteBtn";

    content.replaceChildren(form);
    content.appendChild(deleteBtn);
}

export {creerFormGestion};
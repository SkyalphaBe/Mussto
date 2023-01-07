import {Etudiant} from "./Etudiant.js";
import {Professeur} from "./Professeur.js";

let js = document.createElement("script");
js.src = "https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js";
js.type = "text/javascript";
document.body.appendChild(js);

const content = document.getElementsByClassName("content")[0];
const radioChoix = document.querySelectorAll('input[type="radio"]');
const btnCreerCompte = document.getElementById("btnCreer");
const checkBox = document.getElementsByClassName("check")[0];
const topBoxUsr = document.getElementsByClassName("topBoxUsr")[0];


window.onload = update();

radioChoix.forEach(elem=>{
    elem.addEventListener("click",()=>{
        update();
    });
});

btnCreerCompte.addEventListener("click",()=>{
    btnCreerCompte.style.display="none";
    checkBox.style.display="none";
    content.style.flexDirection="row";
    content.style.height="80vh";
    creerCompte();
    creerCompteExcel();

    let selectedFile;
    let inputFileCompte = document.getElementById('fileCompte');
    let sendBtn = document.getElementById("sendIt");

    inputFileCompte.addEventListener("change",(event)=>{
         selectedFile = event.target.files[0];
    });

    sendBtn.addEventListener("click", (event)=>{
        let testvalide = document.getElementById("validation");
        if (testvalide){
            testvalide.remove();
        }
        event.preventDefault();
        if(selectedFile){
            let fileReader = new FileReader();
            fileReader.readAsBinaryString(selectedFile);
            fileReader.onload = (event)=>{
                let data = event.target.result;
                let workbook = XLSX.read(data,{type:"binary"});
                console.log(workbook);
                workbook.SheetNames.forEach(async sheet => {
                    let rowObject = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[sheet]);
                    await CreationCompte(rowObject);
                });
            }
        }
    });
});

async function CreationCompte(donnees){
    let divExcel = document.getElementsByClassName("ExcelExport")[0];

    let header = {
        method : 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body : JSON.stringify(donnees,undefined,4)
    }
    let request = await fetch("/api/creerCompteExcel", header);
    if (request.ok){
        let json = await request.json();
        console.log(json);

        if(json["code"] === 200){
            let validation = document.createElement("p");
            validation.textContent="Création des comptes réussi";
            validation.style.color="green";
            validation.id="validation";
            divExcel.appendChild(validation);
        }
        else {
            let validation = document.createElement("p");
            validation.textContent = "Erreur lors de la création";
            validation.style.color = "red";
            validation.id="validation";
            divExcel.appendChild(validation);
        }
    }else{
        prompt("Une erreur c'est produite dans la requete au server");
    }
}

function update(){
    content.innerHTML = "";
    radioChoix.forEach(elem =>{
        if(elem.checked){
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
                        createLineUser(user);
                    }
                    else if(elem.value == "/api/listeProfesseur"){
                        let user = new Professeur(line);
                        createLineUser(user);
                    }
                });
            }).catch(err =>{
                console.error(err);
            });
        }
    });
}

function createLineUser(user){
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
        btnCreerCompte.style.display="block";
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
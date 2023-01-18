import {creerFormGestion} from "./modifModule";

const content = document.getElementsByClassName("content")[0];
const topBoxAdmin = document.getElementsByClassName("topBoxAdmin")[0];
const btnCreerModule = document.getElementById("btnCreer");

window.onload = updateModule();

let js = document.createElement("script");
js.src = "https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js";
js.type = "text/javascript";
document.body.appendChild(js);

btnCreerModule.addEventListener("click",()=>{
    modifyTopBox()
    createAccountForm();
    createAccountFormExcel();

    let selectedFile;
    let inputFileModule = document.getElementById('fileModule');
    let sendBtn = document.getElementById("sendItModule");

    inputFileModule.addEventListener("change",(event)=>{
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
                    await createModule(rowObject);
                });
            }
        }
    });
});

async function createModule(donnees){
    let divExcel = document.getElementsByClassName("ExcelExport")[0];

    let header = {
        method : 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body : JSON.stringify(donnees,undefined,4)
    }
    let request = await fetch("/api/creerModuleExcel", header);
    if (request.ok){
        let json = await request.json();
        console.log(json);

        if(json["code"] === 200){
            let validation = document.createElement("p");
            validation.textContent="Création des modules réussi";
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

function updateModule(){
    content.innerHTML = "";
    fetch("/api/listeModules").then(res =>{
        if (res.ok){
            return res.json();
        }else {
            throw new Error(res.status);
        }
    }).then(json => {
        json.module.forEach(line =>{
            createLineModule(line,json.groupe,json.affect);
        });
    }).catch(err =>{
        console.error(err);
    });
}
function createLineModule(module,listGroupe,listeParticipant){
    let newDiv= document.createElement('div');
    let intitule = document.createElement('h3');
    let refModule = document.createElement('h3');
    let newBtn = document.createElement('button');

    newDiv.className = "Element";

    intitule.className = "attribute";
    intitule.textContent = module.NOMMODULE;

    refModule.className = "attribute"
    refModule.textContent = module.REFMODULE;

    newBtn.className='btnManage';
    newBtn.textContent='gérer';
    newBtn.addEventListener('click',()=>{
        content.style.alignItems = "center";
        content.style.justifyContent = "space-evenly";
        creerFormGestion(module,listGroupe,listeParticipant);
        modifyTopBox();
    })

    newDiv.appendChild(intitule);
    newDiv.appendChild(refModule);
    newDiv.appendChild(newBtn);
    content.appendChild(newDiv);
}


function createAccountForm(){
    let templateForm = document.querySelector("template");
    content.style.flexDirection="row";
    content.replaceChildren(templateForm.content.cloneNode(true));
}

function modifyTopBox(){
    btnCreerModule.style.display="none";

    let btnRetour = document.createElement("button");
    btnRetour.textContent="retour";

    topBoxAdmin.appendChild(btnRetour);

    btnRetour.addEventListener("click",()=>{
        btnCreerModule.style.display="block";
        content.style.alignItems = "normal";
        content.style.justifyContent = "normal";
        content.style.flexDirection="column";
        topBoxAdmin.removeChild(btnRetour);
        updateModule();
    });
}

function createAccountFormExcel(){
    let templateExcel = document.querySelectorAll("template")[1];
    content.appendChild(templateExcel.content.cloneNode(true));
}
import {Etudiant} from "./Etudiant.js";
import {Professeur} from "./Professeur.js";
import {generateFormGestion} from "./modifUser.js";

let js = document.createElement("script");
js.src = "https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js";
js.type = "text/javascript";
document.body.appendChild(js);

const content = document.getElementsByClassName("content")[0];
const radioChoice = document.querySelectorAll('input[type="radio"]');
const btnCreateAccount = document.getElementById("btnCreer");
const checkBox = document.getElementsByClassName("check")[0];
const topBoxAdmin = document.getElementsByClassName("topBoxAdmin")[0];
const searchBar = document.getElementById("search");


window.onload = updateAccount();

radioChoice.forEach(elem=>{
    elem.addEventListener("click",()=>{
        updateAccount();
    });
});

searchBar.onchange = () => {
    updateAccount();
}

btnCreateAccount.addEventListener("click",()=>{
    searchBar.style.display="None";
    btnCreateAccount.style.display="none";
    checkBox.style.display="none";
    content.style.flexDirection="row";
    createAccountForm();
    createAccountFormExcel();

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
                    await createUser(rowObject);
                });
            }
        }
    });
});

function updateAccount(){
    content.innerHTML = "";
    radioChoice.forEach(elem =>{
        if(elem.checked){
            let search = searchBar.value

            fetch(elem.value + "?query="+search).then(res =>{
                if (res.ok){
                    return res.json();
                }else {
                    throw new Error(res.status);
                }
            }).then(json => {
                json.user.forEach(line =>{
                    if(elem.value == "/api/listeEtu"){
                        let user = new Etudiant(line);
                        createLineUser(user,"Etudiant",json.groups);
                    }
                    else if(elem.value == "/api/listeProfesseur"){
                        let user = new Professeur(line);
                        createLineUser(user,"Professeur",json.module,json.assigns);
                    }
                });
            }).catch(err =>{
                console.error(err);
            });
        }
    });
}

async function createUser(donnees){
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

function createLineUser(user,typeAccount,assignList,defaultAssign=null){
    let newElem = document.createElement("div");
    let newNom = document.createElement("h3");
    let newPrenom = document.createElement("h3");
    let newBtn = document.createElement("button");
    let attribute = document.createElement("div");

    newElem.className = "Element";

    newPrenom.className = "attribute";
    newPrenom.textContent = user.prenom;

    newNom.className = "attribute";
    newNom.textContent = user.nom;

    newBtn.className = "btnManage";
    newBtn.textContent = "gérer";

    attribute.className = "attribute";

    attribute.appendChild(newPrenom);
    attribute.appendChild(newNom);
    newElem.appendChild(attribute);
    newElem.appendChild(newBtn);
    content.appendChild(newElem);

    newBtn.addEventListener('click',()=>{
        content.style.alignItems = "center";
        content.style.justifyContent = "space-evenly";
        generateFormGestion(user,typeAccount,assignList,defaultAssign);
        modifyTopBox(typeAccount);
    });
}

function modifyTopBox(typeAccount){
    searchBar.style.display="None";
    let btnRetour = document.createElement('button');

    btnRetour.textContent='Retour';
    btnRetour.onclick=()=>{
        content.style.alignItems = "normal";
        content.style.justifyContent = "normal";
        btnCreateAccount.style.display = 'Block';
        searchBar.style.display="block";
        radioChoice.forEach(elem =>{
            elem.parentElement.style.display = 'flex';
        })
        topBoxAdmin.children[0].textContent="Utilisateur";
        btnRetour.remove();
        updateAccount();
    };

    topBoxAdmin.appendChild(btnRetour);

    btnCreateAccount.style.display = 'None';
    radioChoice.forEach(elem =>{
        elem.parentElement.style.display = 'None';
    });
    topBoxAdmin.children[0].textContent=typeAccount;

}

function createAccountForm(){
    let templateForm = document.querySelector("template");
    content.replaceChildren(templateForm.content.cloneNode(true));

    let btnRetour = document.createElement("button");
    btnRetour.textContent="retour";

    topBoxAdmin.appendChild(btnRetour);

    btnRetour.addEventListener("click",()=>{
        searchBar.style.display="Block";
        btnCreateAccount.style.display="block";
        checkBox.style.display="flex";
        content.style.flexDirection="column";
        topBoxAdmin.removeChild(btnRetour);
        updateAccount();
    });
}

function createAccountFormExcel(){
    let templateExcel = document.querySelectorAll("template")[1];
    content.appendChild(templateExcel.content.cloneNode(true));
}
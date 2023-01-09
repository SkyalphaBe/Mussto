const content = document.getElementsByClassName("content")[0];
const radioChoix = document.querySelectorAll('input[type="radio"]');
const topBoxAdmin = document.getElementsByClassName("topBoxAdmin")[0];
const btnCreerGroup = document.getElementById("btnCreer");
const checkBox = document.getElementsByClassName("check")[0];

window.onload = updateGroup();

let js = document.createElement("script");
js.src = "https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js";
js.type = "text/javascript";
document.body.appendChild(js);

btnCreerGroup.addEventListener("click",()=>{
    btnCreerGroup.style.display="none";
    content.style.flexDirection="row";
    checkBox.style.display="none";
    createGroupForm();
    createGroupFormExcel();

    let selectedFile;
    let inputFileModule = document.getElementById('fileGroup');
    let sendBtn = document.getElementById("sendItGroup");

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
                    await createGroup(rowObject);
                });
            }
        }
    });
});

async function createGroup(donnees){
    let divExcel = document.getElementsByClassName("ExcelExport")[0];

    let header = {
        method : 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body : JSON.stringify(donnees,undefined,4)
    }
    let request = await fetch("/api/createGroupExcel", header);
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
radioChoix.forEach(elem=>{
    elem.addEventListener("click",()=>{
        updateGroup();
    });
});
function updateGroup(){
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
                    createLineGroup(line);
                });
            }).catch(err =>{
                console.error(err);
            });
        }
    });
}

function createLineGroup(group){
    let newDiv= document.createElement('div');
    let intitule = document.createElement('h3');
    let annee = document.createElement('h3');
    let newBtn = document.createElement('button');

    newDiv.className = "Element";

    intitule.className = "attribute";
    intitule.textContent = group.INTITULEGROUPE;

    annee.className = "attribute";
    annee.textContent = group.ANNEEGROUPE;

    newBtn.className='btnManage';
    newBtn.textContent='supprimer';
    newBtn.addEventListener('click',async ()=>{
        await deleteGroup(group.INTITULEGROUPE,group.ANNEEGROUPE)
    });

    newDiv.appendChild(intitule);
    newDiv.appendChild(annee);
    newDiv.appendChild(newBtn);
    content.appendChild(newDiv);
}

async function deleteGroup(name,year){
    let header = {
        method : 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body : JSON.stringify([name,year])
    }

    let request = await fetch("/api/deleteGroup", header);
    if (request.ok){
        let json = await request.json();
        console.log(json);

        if(json["code"] === 200){
            location.reload();
        }
    }
    else{
        console.log('marche pas');
    }
}

function createGroupForm(){
    let templateForm = document.querySelector("template");
    content.replaceChildren(templateForm.content.cloneNode(true));

    let btnRetour = document.createElement("button");
    btnRetour.textContent="retour";

    topBoxAdmin.appendChild(btnRetour);

    btnRetour.addEventListener("click",()=>{
        btnCreerGroup.style.display="block";
        checkBox.style.display="flex";
        content.style.flexDirection="column";
        topBoxAdmin.removeChild(btnRetour);
        updateGroup();
    });
}

function createGroupFormExcel(){
    let templateExcel = document.querySelectorAll("template")[1];
    content.appendChild(templateExcel.content.cloneNode(true));
}
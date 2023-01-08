const content = document.getElementsByClassName("content")[0];
const btnCreerModule = document.getElementById("btnCreer");

window.onload = updateModule();

function updateModule(){
    content.innerHTML = "";
    console.log("cc");
    fetch("/api/listeModules").then(res =>{
        if (res.ok){
            return res.json();
        }else {
            throw new Error(res.status);
        }
    }).then(json => {
        json.forEach(line =>{
            console.log("cc");
            createLineModule(line);
        });
    }).catch(err =>{
        console.error(err);
    });
}
function createLineModule(module){
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

    newDiv.appendChild(intitule);
    newDiv.appendChild(refModule);
    newDiv.appendChild(newBtn);
    content.appendChild(newDiv);
}
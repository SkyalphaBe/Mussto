const content = document.getElementsByClassName("content")[0];
const radioChoix = document.querySelectorAll('input[type="radio"]');
const btnCreerGroup = document.getElementById("btnCreer");

window.onload = updateGroup();

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
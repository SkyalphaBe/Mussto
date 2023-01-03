export default function selecteur(name, selected, available, callback){
    var div = document.createElement("div");
    div.classList.add("selecteur");
    /* div.classList.add("devoir-info-input"); */
    div.name = name;

    if (selected){
        selected = [...selected];  ///Copie des deux tableaux
    } else {
        selected  = [];
    }
    
    available = [...available];

    const update = () => {
        div.value = [...selected]; ///Copie du tableau pour perdre la référence de l'ancienne valeur.
        div.innerHTML = "";

        //console.log("update");
        if (callback){  
            callback(selected);
        }
        if (div.onchange){
            div.onchange();
        }

        var listElt = document.createElement("ul");
        selected.forEach((elt, index) => {
            let item = document.createElement("li");
            if (elt instanceof Object){
                item.innerText = elt.val;
            } else {
                item.innerText = elt;
            }
            item.onclick = () => {  //Suppresion
                selected.splice(index, 1);
                selected.sort();
                update();
            }
            listElt.appendChild(item);
        })
        div.appendChild(listElt);

        var selectElt = document.createElement("select");
        var not_selected = available.filter(elt => !(selected.includes(elt)))
        selectElt.add(new Option("--", null));
        not_selected.forEach((elt, index) => {
            if (elt instanceof Object){
                selectElt.add(new Option(elt.val, index));
            } else {
                selectElt.add(new Option(elt, index));
            }
        })
        div.appendChild(selectElt);

        var buttonElt = document.createElement("button");
        buttonElt.innerText = "Ajouter";
        buttonElt.onclick = () => { //Ajout
            let val = selectElt.value;
            if (val !== "null"){
                selected.push(not_selected[val]);
                selected.sort();
                update();
            }
        }
        div.appendChild(buttonElt);
    }

    update();

    return div;
}
import selecteur from "/assets/scripts/component/selecteur.js";
import Loader from "/assets/scripts/component/loader.js";

export default function formulaire_infos_devoir(data, callback){
    var root = document.createElement("div");
    root.className = "form-info-devoir"
    if (!(data.GROUPES_AVAILABLE && data.ORGANISATEUR_AVAILABLE && data.SALLES_AVAILABLE)){
        console.error("Pas assez de data");
    } else {
        var inputs = [];

        //Sujet
        var contentDiv = document.createElement("div");
        contentDiv.className = "field";
        var contentLabel = document.createElement("label");
        contentLabel.innerText = "Sujet du devoir :"
        contentLabel.htmlFor = "content-input";

        var contentInput = document.createElement("input");
        if (data.CONTENUDEVOIR){
            contentInput.value = data.CONTENUDEVOIR;
        }
        contentInput.id = "content-input";
        contentInput.name = "content";

        contentDiv.appendChild(contentLabel);
        contentDiv.appendChild(contentInput);
        root.appendChild(contentDiv);
        inputs.push(contentInput);

        //Desc
        var descDiv = document.createElement("div");
        descDiv.className = "field";
        var descLabel = document.createElement("label");
        descLabel.innerText = "Description du devoir :"
        descLabel.htmlFor = "desc-input";

        var descInput = document.createElement("textarea");
        if (data.DESCDEVOIR){
            descInput.value = data.DESCDEVOIR;
        }
        descInput.id = "desc-input";
        descInput.name = "desc";

        descDiv.appendChild(descLabel);
        descDiv.appendChild(descInput);
        root.appendChild(descDiv);
        inputs.push(descInput);

        //Date
        var dateDiv = document.createElement("div");
        dateDiv.className = "field";
        var dateLabel = document.createElement("label");
        dateLabel.innerText = "Date du devoir :"
        dateLabel.htmlFor = "date-input";

        var dateInput = document.createElement("input");
        if (data.DATEDEVOIR){
            dateInput.value = data.DATEDEVOIR
        }
        dateInput.id = "date-input";
        dateInput.type = "date";
        dateInput.name = "date";

        dateDiv.appendChild(dateLabel);
        dateDiv.appendChild(dateInput);
        root.appendChild(dateDiv);
        inputs.push(dateInput);

        //Salle
        var salleDiv = document.createElement("div");
        salleDiv.className = "field";
        var salleLabel = document.createElement("label");
        salleLabel.innerText = "Salle du devoir :"
        salleLabel.htmlFor = "salle-input";

        var salleInput = document.createElement("select");
        salleInput.id = "salle-input";
        salleInput.name = "salle";
        data.SALLES_AVAILABLE.forEach((salle) => {
            salleInput.add(new Option(salle, salle, salle === data.SALLE, salle === data.SALLE));
        })

        salleDiv.appendChild(salleLabel);
        salleDiv.appendChild(salleInput);
        root.appendChild(salleDiv);
        inputs.push(salleInput);


        //Groupes
        var groupsDiv = document.createElement("div");
        groupsDiv.className = "field";
        var groupsLabel = document.createElement("label");
        groupsLabel.innerText = "Groupes participants :"

        var groupsInput = selecteur("groups", data.GROUPES, data.GROUPES_AVAILABLE);

        groupsDiv.appendChild(groupsLabel);
        groupsDiv.appendChild(groupsInput);
        root.appendChild(groupsDiv);
        inputs.push(groupsInput);

        //Orga
        var orgaDiv = document.createElement("div");
        orgaDiv.className = "field";
        var orgaLabel = document.createElement("label");
        orgaLabel.innerText = "Organisateurs :"

        var orgaInput = selecteur("orga", data.ORGANISATEUR, data.ORGANISATEUR_AVAILABLE);

        orgaDiv.appendChild(orgaLabel);
        orgaDiv.appendChild(orgaInput);
        root.appendChild(orgaDiv);
        inputs.push(orgaInput);

        //Coef
        var coefDiv = document.createElement("div");
        coefDiv.className = "field";
        var coefLabel = document.createElement("label");
        coefLabel.innerText = "Coefficient :"
        coefLabel.htmlFor = "coef-input";

        var coefInput = document.createElement("input");
        coefInput.type = "number";
        coefInput.step = "0.1";
        coefInput.min = "1";
        if ( data.COEF){
            coefInput.value = data.COEF
        } else {
            coefInput.value = 1;
        }
        coefInput.id = "coef-input";
        coefInput.name = "coef";
        coefInput.setAttribute("required", "");

        coefDiv.appendChild(coefLabel);
        coefDiv.appendChild(coefInput);
        root.appendChild(coefDiv);
        inputs.push(coefInput);

        //Submit
        var submitButton = document.createElement("button");
        submitButton.textContent = "Envoyer";
        submitButton.setAttribute("disabled", "");

        root.appendChild(submitButton);

        //Loader
        var loaderDiv = Loader();

        root.appendChild(loaderDiv);

        //Création de l'objets des valeurs initiales
        const initialValue = {};
        inputs.forEach(elt => {
            initialValue[elt.name] = elt.value;
        });

        //Méthode de récupération des valuers actuelles
        const getData = () => {
            const data = {};
            inputs.forEach(elt => { data[elt.name] = elt.value; });
            return data;
        }

        //Méthode de vérification de changement (valeur initial != valeur actuelle)
        const checkChange = () => {
            if (JSON.stringify(getData()) === JSON.stringify(initialValue)){
                submitButton.setAttribute("disabled", "");
                return false;
            } else {
                submitButton.removeAttribute("disabled");
                return true;
            };
        }

        inputs.forEach((elt) => {
            elt.onchange = checkChange;
        })

        const submit = () => {
            if (callback){
                callback(getData(), root);
            }
        }

        submitButton.onclick = submit;

    }

    root.setEnable = (value) => {
        if (submitButton){
            if (value){
                submitButton.removeAttribute("disabled");
            } else {
                submitButton.setAttribute("disabled", "");
            }
        }
    }

    root.showLoader = (value) => {
        if (loaderDiv){
            if (value){
                loaderDiv.show();
            } else {
                loaderDiv.hide();
            }
        }
    }

    return root;
}
import Selecteur from "/assets/scripts/component/selecteur.js";
import Message from "/assets/scripts/component/message.js";

var free_section = () => {
    var root = document.createElement("div");
    root.className = "free-section";
    root.question = "";
    root.type = "free";

    root.getData = () => {
        return {question : root.question, type : root.type}
    }

    root.innerHTML = '<p>Champ libre : </p>';

    var inputQuestion = document.createElement("input");
    inputQuestion.placeholder = "Question";
    inputQuestion.oninput = (e) => {
        if (e.target.value){
            root.question = e.target.value;
        }
    }

    root.appendChild(inputQuestion);

    return root;
}

var select_section = () => {
    var root = document.createElement("div");
    root.className = "select-section";
    root.question = "";
    root.type = "choice";
    root.choice = [];

    root.getData = () => {
        return {question : root.question, type : root.type, choice : root.choice}
    }

    root.innerHTML = '<p>Champ à choix multiple : </p>';

    var inputQuestion = document.createElement("input");
    inputQuestion.placeholder = "Question";
    inputQuestion.oninput = (e) => {
        if (e.target.value){
            root.question = e.target.value;
        }
    }

    var choiceDiv = document.createElement("div");

    var listChoiceDiv = document.createElement("ul");
    var load = () => {
        listChoiceDiv.innerHTML = "";
        root.choice.forEach((element, index) => {
            let item = document.createElement("li");
            item.innerHTML = "<span>"+element+"</span>";
            let button = document.createElement("button");
            item.appendChild(button);
            button.innerText = "Suppr";
            button.onclick = () => { //Suppression
                root.choice.splice(index, 1);
                load();
            }
            listChoiceDiv.appendChild(item);
        });
    }

    var newChoiceDiv = document.createElement("div");
    choiceDiv.appendChild(newChoiceDiv);

    var inputChoice = document.createElement("input");
    inputChoice.placeholder = "Ajouter un choix";
    newChoiceDiv.appendChild(inputChoice);
    
    var inputChoiceSubmit = document.createElement("button");
    inputChoiceSubmit.innerText = "Ajouter";
    inputChoiceSubmit.onclick = () => {
        if (inputChoice.value){
            root.choice.push(inputChoice.value);
            inputChoice.value = "";
            load();
        }
    }

    newChoiceDiv.appendChild(inputChoiceSubmit);
    newChoiceDiv.appendChild(listChoiceDiv);

    
    root.appendChild(inputQuestion);
    root.appendChild(choiceDiv);

    return root;
}


if (id){
    fetch('/api/modules-' + id + '/groups').then(res => {
        if (res.ok){
            return res.json();
        } else {
            throw new Error(res.status);
        }
    }).then(json => {

        var root = document.getElementById("creer-sondage");
    
        var titleInput = document.createElement("input");
        titleInput.placeholder = "Objet";
        titleInput.name = "title";
        root.appendChild(titleInput);

        var groupeDiv = document.createElement("div");
        var groupeLabel = document.createElement("p");
        groupeLabel.innerText = "Groupe :";
        var groupeInput = Selecteur("groups", [], json);
        groupeDiv.appendChild(groupeLabel);
        groupeDiv.appendChild(groupeInput);
        root.appendChild(groupeDiv);

        
        var sections = [];
        var sectionsDiv = document.createElement("ul");
        var loadSections = () => {
            sectionsDiv.innerHTML = "";
            sections.forEach((element, index) => {
                
                let item = document.createElement("li");
                item.appendChild(element);
                
                let supprButton = document.createElement("button");
                supprButton.innerText = "suppr";
                supprButton.onclick = () => {
                    sections.splice(index, 1);
                    loadSections();
                }
                item.appendChild(supprButton);

                sectionsDiv.appendChild(item);
            });
        }

        var newSectionDiv = document.createElement("div");
        var newSectionSelect = document.createElement("select");
        newSectionSelect.add(new Option("Champs libre", "free"));
        newSectionSelect.add(new Option("Champs à choix multiple", "select"));
        newSectionDiv.appendChild(newSectionSelect);

        var newSectionSubmit = document.createElement("button");
        newSectionSubmit.innerText = "Ajouter";
        newSectionSubmit.onclick = () => {
            if (newSectionSelect.value === "free"){
                sections.push(free_section());
            } else if (newSectionSelect.value === "select"){
                sections.push(select_section());
            }
            loadSections();
        }
        newSectionDiv.appendChild(newSectionSubmit);
        root.appendChild(newSectionDiv);
        root.appendChild(sectionsDiv);
        
        var errorMessage = Message();
        var submitButton = document.createElement("button");
        submitButton.innerText = "Envoyer";
        submitButton.onclick = () => {
            var data = {title : titleInput.value, groups : groupeInput.value, fields : sections.map(elt => elt.getData())}

            console.log(data)
            if (data.title && data.groups && data.groups.length > 0 && data.fields && data.fields.length > 0){
                console.log("ok");
            } else {
                errorMessage.showMessage("Veuillez mettre un objet et au moins un groupe et un champ de réponse");
            }

        }

        root.appendChild(submitButton);
        root.appendChild(errorMessage);


    }).catch(err => {
        console.log(err);
    })
}

import Selecteur from "/assets/scripts/component/selecteur.js";
import Message from "/assets/scripts/component/message.js";
import Loader from "/assets/scripts/component/loader.js";

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
        root.question = e.target.value;
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
        return {question : root.question, type : root.type, choices : root.choice}
    }

    root.innerHTML = '<p>Champ à choix multiple : </p>';

    var inputQuestion = document.createElement("input");
    inputQuestion.placeholder = "Question";
    inputQuestion.oninput = (e) => {
        root.question = e.target.value;
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

        var topDiv = document.createElement("div");
        topDiv.className = "form";
    
        var titleDiv = document.createElement("div");
        var titleLabel = document.createElement("label");
        titleLabel.innerText = "Objet du sondage :";
        titleLabel.htmlFor = "objet";
        titleDiv.appendChild(titleLabel);

        var titleInput = document.createElement("input");
        titleInput.placeholder = "Objet";
        titleInput.id = "objet";
        titleDiv.appendChild(titleInput);

        topDiv.appendChild(titleDiv);

        var groupeDiv = document.createElement("div");
        var groupeLabel = document.createElement("label");
        groupeLabel.innerText = "Groupes :";
        var groupeInput = Selecteur("groups", [], json);
        groupeDiv.appendChild(groupeLabel);
        groupeDiv.appendChild(groupeInput);
        topDiv.appendChild(groupeDiv);

        
        var sections = [];
        var sectionsDiv = document.createElement("ul");
        var loadSections = () => {    //Charger la liste des questions
            sectionsDiv.innerHTML = "";
            if (sections.length > 0){
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
            } else {
                sectionsDiv.innerHTML = "Auncune question ajoutée";
            }
        }
        loadSections();

        var newSectionDiv = document.createElement("div");
        var newSectionSubDiv = document.createElement("div");
        newSectionSubDiv.className = "add-question";

        var newSectionLabel = document.createElement("label");
        newSectionLabel.innerText = "Ajouter une nouvelle question : ";
        newSectionLabel.htmlFor = "type-select";
        newSectionDiv.appendChild(newSectionLabel);

        var newSectionSelect = document.createElement("select");
        newSectionSelect.id = "type-select";
        newSectionSelect.add(new Option("Champs libre", "free"));
        newSectionSelect.add(new Option("Champs à choix multiple", "select"));
        newSectionSubDiv.appendChild(newSectionSelect);

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
        newSectionSubDiv.appendChild(newSectionSubmit);
        newSectionDiv.appendChild(newSectionSubDiv);
        topDiv.appendChild(newSectionDiv);
        root.appendChild(topDiv);

        var parentSectionDiv = document.createElement("div");
        parentSectionDiv.className = "question-list";
        parentSectionDiv.innerHTML = "<h2>Liste des question : </h2>";
        parentSectionDiv.appendChild(sectionsDiv);

        root.appendChild(parentSectionDiv);
        
        var errorMessage = Message();
        var submitButton = document.createElement("button");
        var loader = Loader();
        submitButton.innerText = "Envoyer";
        submitButton.onclick = () => {
            var data = {title : titleInput.value, groups : groupeInput.value, fields : sections.map(elt => elt.getData()), module : id}

            if (data.title && data.groups && data.groups.length > 0 && data.fields && data.fields.length > 0){
                var pass = data.fields.every(elt => {
                    if (elt.question && elt.question.length > 0){
                        if (elt.type === "choice"){
                            if (elt.choices.length > 1){
                                return true;
                            } else {
                                return false;
                            }
                        } else {
                            return true;
                        }
                    } else {
                        return false;
                    }
                });

                if (pass){
                    loader.show();
                    var header = {
                        method : 'PUT', 
                        headers: {
                        'Content-Type': 'application/json'
                        },
                        body : JSON.stringify(data)
                    }
    
                    fetch("/api/sondage/create-sondage", header).then(res => {
                        if (res.ok){
                            return res.text();
                        } else {
                            return res.text().then(text => {throw new Error(text + " " + res.status)});
                        }
                    }).then(text => {
                        location.replace(text);
                    }).catch(err => {
                        loader.hide();
                        console.error(err);
                    }) 
                } else {
                    errorMessage.showMessage("Une question n'est pas complète");
                }

                
            } else {
                errorMessage.showMessage("Veuillez mettre un objet et au moins un groupe et un champ de réponse");
            }

        }

        root.appendChild(submitButton);
        root.appendChild(loader);
        root.appendChild(errorMessage);


    }).catch(err => {
        console.log(err);
    })
}

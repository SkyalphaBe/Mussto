function gestion_notes(root_id){

    ///Importation librairie SheetJS
    let js = document.createElement("script");
    js.src = "https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js";
    js.type = "text/javascript";
    document.body.appendChild(js);

    class Note{
        static id = 0;
        static getId(){
            return id++;
        }

        constructor(json){
            this.login = json.LOGINETU; 
            this.nom = json.NOMETU;
            this.prenom = json.PRENOMETU;
            this.date = json.DATE_ENVOIE;
            this.comment = json.COMMENTAIRE;
            this.note = json.NOTE;

            this.input_comment;
            this.input_note;
        }

        setComment(comment){
            this.input_comment.value = comment;
            this.comment = comment;
        }

        setNote(note){
            this.input_note.value = note;
            this.note = note;
        }

        updateComment(e){
            if (e.target.value === ""){
                this.comment = null;
            } else {
                this.comment = e.target.value;
            }
        }

        updateNote(e){
            if (e.target.value === ""){
                this.note = null;
            } else {
                this.note = e.target.value;
            }
        }

        getData(){
            return {loginetu : this.login, nom : this.nom, prenom : this.prenom, comment : this.comment, note : this.note}
        }

        getDOMElt(){
            let DOMelt = document.createElement("tr");
            DOMelt.innerHTML = "<td>" + this.prenom + "</td>" +
                "<td>" + this.nom + "</td>" +
                "<td>" + (this.date ? this.date : "") + "</td>"

            this.input_comment = document.createElement("textarea");
            this.input_comment.value = this.comment;
            this.input_comment.oninput = this.updateComment.bind(this);
            let td_comment = document.createElement("td");
            td_comment.appendChild(this.input_comment);

            this.input_note = document.createElement("input");
            this.input_note.value = this.note;
            this.input_note.oninput = this.updateNote.bind(this);
            let td_note = document.createElement("td");
            td_note.appendChild(this.input_note);

            DOMelt.appendChild(td_comment);
            DOMelt.appendChild(td_note);

            return DOMelt;
        }
    }

    var data = {};

    var root = document.getElementById(root_id);
    root.innerHTML = "";

    var send = () => {
        var header = {
            method : 'POST', 
            headers: {
            'Content-Type': 'application/json'
            },
            body : JSON.stringify(Object.values(data).map(elt => elt.getData()))
        }

        fetch("/api/devoir/update-notes-ds-"+id, header).then(res => res.text()).then(text => {console.log(text)});
    }

    var download = () => {

        if (data){
            console.log(data);
            let rows = Object.values(data).map((elt) => elt.getData());
            let worksheet = XLSX.utils.json_to_sheet(rows);
            let workbook = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(workbook, worksheet, "NOTES");

            XLSX.writeFile(workbook, "NOTES.xlsx");
        }
    }

    var importer = (e) => {
        let filelist = e.target.files;
        if (filelist.length >= 1){
            let reader = new FileReader();
            reader.onload = function(e) {
                var workbook = XLSX.read(e.target.result);
                var dataimport = XLSX.utils.sheet_to_json(workbook.Sheets.NOTES);
                console.log(dataimport);
                if (data){
                    dataimport.forEach((row) => {
                        let target = data[row.loginetu]
                        if (target){
                            if (row.note){
                                target.setNote(row.note)
                            }
                            if (row.comment){
                                target.setComment(row.comment);
                            }
                        }
                    });
                }
                

            };
            reader.readAsArrayBuffer(filelist[0]);
        }
    }

    var load = () => {
        root.innerHTML = "";

        data = {};

        var table = document.createElement("table");
        table.innerHTML = "<thead><th>Nom</th><th>Prenom</th><th>Date Envoie</th><th>Commentaires</th><th>Notes</th></thead>";
        var tbody = document.createElement("tbody");
        table.appendChild(tbody);


        var buttondiv = document.createElement("div");
        var sendButton = document.createElement("button");
        sendButton.innerText = "Enregistrer";
        sendButton.onclick = send;
        var downloadButton = document.createElement("button");
        downloadButton.innerText = "Télécharger les données au format Excel";
        downloadButton.onclick = download;
        var inportButton = document.createElement("input");
        inportButton.type = "file"
        inportButton.innerText = "Importer un fichier Excel";
        inportButton.onchange = importer;
        buttondiv.appendChild(sendButton);
        buttondiv.appendChild(downloadButton);
        buttondiv.appendChild(inportButton);

        var loadingTitle = document.createElement("h2");
        loadingTitle.innerText = "Chargement";
        root.appendChild(loadingTitle);

        fetch("/api/devoir/get-notes-ds-"+id).then(res => {
            if (res.ok){
                return res.json();
            } else {
                throw new Error(res.status);
            }
        }).then(json => {
            json.forEach(elt => {
                let line = new Note(elt);
                tbody.appendChild(line.getDOMElt());
                data[line.login] = line
            })
            root.removeChild(loadingTitle);
            root.appendChild(table);
            root.appendChild(buttondiv);
        }).catch(err => {
            console.error(err);
        }) ;
    }

    load();
};

function gestion_info(){

    ///Importation du selecteur
    let js = document.createElement("script");
    js.src = "/assets/scripts/selecteur.js";
    js.type = "text/javascript";
    js.onload = () => {
        groups_selected.sort();
        profs_selected.sort();

        //Recuperation des div pour les selecteurs
        const groupsDiv = document.getElementById("devoir-group");
        const orgaDiv = document.getElementById("devoir-orga");

        //Création des selecteur et affectation
        groupsDiv.innerHTML = "<p>Groupes : </p>";
        groupsDiv.appendChild(selecteur("groups", groups_selected, groups_available, (selected) => {
            groups_selected = selected;
        }));

        orgaDiv.innerHTML = "<p>Organisateur : </p>";
        profs_available.forEach(elt => {elt.val = elt.PRENOMPROF + " " + elt.NOMEPROF});
        profs_selected.forEach(elt => {elt.val = elt.PRENOMPROF + " " + elt.NOMEPROF});
        orgaDiv.appendChild(selecteur("orga", profs_selected, profs_available, (selected) => {
            profs_selected = selected;
        }))


        //Gestion des inputs
        const inputs = [...document.querySelectorAll("input.devoir-info-input, select.devoir-info-input, div.devoir-info-input, textarea.devoir-info-input")]; //Les selecteurs sont gérés comme les inputs
        const submitButton = document.querySelector("button#devoir-info-submit");
        
        //Création de l'objets des valeurs initiales
        const initialValue = {iddevoir : id};
        inputs.forEach(elt => {
            initialValue[elt.name] = elt.value;
        });

        //Méthode de récupération des valuers actuelles
        const getData = () => {
            const data = {iddevoir : id};
            inputs.forEach(elt => {
                data[elt.name] = elt.value;
            });

            return data;
        }

        //Méthode de vérification de changement (valeur initial != valeur actuelle)
        const checkChange = () => {
            //console.log(initialValue);
            if (JSON.stringify(getData()) === JSON.stringify(initialValue)){
                submitButton.setAttribute("disabled", "");
                return false;
            } else {
                submitButton.removeAttribute("disabled");
                return true;
            };
        }

        //Chaque changement des inputs engendre un checkChange
        inputs.forEach(elt => {
            elt.onchange = checkChange;
            elt.oninput = checkChange;
        })

        const submit = () => {
            if (checkChange()){
                let data = getData();
                data.orga = data.orga.map(elt => elt.LOGINPROF); //Réarrangement profs;
                var header = {
                    method : 'POST', 
                    headers: {
                    'Content-Type': 'application/json'
                    },
                    body : JSON.stringify(data)
                }
        
                submitButton.setAttribute("disabled", "");
                fetch("/api/devoir/update-infos-ds-"+id, header).then(res => {
                    
                    if (res.status === 200){
                        submitButton.removeAttribute("disabled");
                        location.reload();
                    } else {
                        submitButton.removeAttribute("disabled");
                        console.log("Error");
                    }
                    return res.text()
                }).then(text => {console.log(text)});
            }
        }

        submitButton.onclick = submit;
        submitButton.setAttribute("disabled", "");
    }
    document.body.appendChild(js);


    
}
function notes(id, rootid){
    ///Importation librairie SheetJS
    let js = document.createElement("script");
    js.src = "https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js";
    js.type = "text/javascript";
    document.body.appendChild(js);

    class Note{
        constructor(json){
            this.nom = json.NOMETU;
            this.prenom = json.PRENOMETU;
            this.date = json.DATE_ENVOIE;
            this.comment = json.COMMENTAIRE;
            this.note = json.NOTE;

            this.input_comment;
            this.input_note;
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
            return {nom : this.nom, prenom : this.prenom, comment : this.comment, note : this.note}
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

    var data = [];

    var appRoot = document.getElementById(rootid);
    var root = document.createElement("div");

    appRoot.appendChild(root);

    var send = () => {
        console.log(data);
    }

    var download = () => {
        if (data.length > 0){
            let rows = data.map((elt) => elt.getData());
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
                console.log(workbook);
            };
            reader.readAsArrayBuffer(filelist[0]);
        }
    }

    var load = () => {
        root.innerHTML = "";

        data = [];

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

        fetch("/api/modules/notes-ds-"+id).then(res => {
            if (res.ok){
                return res.json();
            } else {
                throw new Error(res.status);
            }
        }).then(json => {
            json.forEach(elt => {
                let line = new Note(elt);
                tbody.appendChild(line.getDOMElt());
                data.push(line);
            })
            root.removeChild(loadingTitle);
            root.appendChild(table);
            root.appendChild(buttondiv);
        }).catch(err => {
            console.error(err);
        }) ;
    }

    load();
}
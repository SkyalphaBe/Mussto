import XLSX from "https://cdn.sheetjs.com/xlsx-0.19.1/package/xlsx.mjs";
import Message from "/assets/scripts/component/message.js";

export default function gestion_notes(root_id, id_devoir){

    ///Importation librairie SheetJS
    /* let js = document.createElement("script");
    js.src = "https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js";
    js.type = "text/javascript";
    document.body.appendChild(js); */

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
            note = note.toString();
            if (note){  
                note = note.replace(",", ".");
            }
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
                this.setNote(null)
            } else {
                this.setNote(e.target.value)
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

    var root = document.getElementById(root_id);
    root.innerHTML = "";

    var data = {};
    var dataDiv = document.createElement("div");
    root.appendChild(dataDiv);

    var message = Message();
    root.appendChild(message);

    var send = () => {
        var header = {
            method : 'POST', 
            headers: {
            'Content-Type': 'application/json'
            },
            body : JSON.stringify(Object.values(data).map(elt => elt.getData()))
        }

        fetch("/api/devoir/modif-notes-ds-"+id_devoir, header).then(res => {
            if (res.ok){
               
                message.showMessage("Les modifications ont bien été enregistré");   
                load();
                return res.text();
            } else {
                return new Error(res.status);
            }
        }).then(text => {console.log(text)}).catch(err => {
            console.log(err);
        });
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
        dataDiv.innerHTML = "";

        data = {};

        var table = document.createElement("table");
        table.innerHTML = "<thead><th>Nom</th><th>Prenom</th><th>Date d'envoi</th><th>Commentaires</th><th>Note</th></thead>";
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
        dataDiv.appendChild(loadingTitle);

        var errorMessage = document.createElement("p");


        fetch("/api/devoir/obtenir-notes-ds-"+id_devoir).then(res => {
            if (res.ok){
                return res.json();
            } else {
                return res.text().then(data => {throw new Error(data)});
            }
        }).then(json => {
            json.forEach(elt => {
                let line = new Note(elt);
                tbody.appendChild(line.getDOMElt());
                data[line.login] = line
            })
            dataDiv.removeChild(loadingTitle);
            dataDiv.appendChild(table);
            dataDiv.appendChild(buttondiv);
        }).catch(err => {

            errorMessage.innerText = err.message;

            dataDiv.removeChild(loadingTitle);
            dataDiv.appendChild(errorMessage);
        });
    }

    load();
};
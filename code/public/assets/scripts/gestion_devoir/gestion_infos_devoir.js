import formulaire_infos_devoir from "/assets/scripts/component/formulaire_infos_devoir.js";

export default function gestion_infos_devoir(root_id, data){
    Promise.all([
        fetch('/api/modules-' + data.REFMODULE + '/groupes'),
        fetch('/api/modules-' + data.REFMODULE + '/profs'),
        fetch('/api/salles')
    ]).then((responses) => {
        return Promise.all(responses.map((response) => {
            return response.json();
        }));
    }).then((json) => {
        data.GROUPES_AVAILABLE = json[0];
        data.ORGANISATEUR_AVAILABLE = json[1];
        data.SALLES_AVAILABLE = json[2];

        data.ORGANISATEUR_AVAILABLE.forEach(elt => {elt.val = elt.PRENOMPROF + " " + elt.NOMEPROF});
        data.ORGANISATEUR.forEach(elt => {elt.val = elt.PRENOMPROF + " " + elt.NOMEPROF});

        var form;

        var submit = (result) => {
            result.orga = result.orga.map(elt => elt.LOGINPROF); //Réarrangement profs;
            var header = {
                method : 'POST', 
                headers: {
                'Content-Type': 'application/json'
                },
                body : JSON.stringify(result)
            }
            
            form.setEnable(false);
            form.showLoader(true);
            fetch("/api/devoir/modif-infos-ds-"+data.IDDEVOIR, header).then(res => {
                if (res.status === 200){
                    location.reload();
                } else {
                    console.error('error');
                    form.showLoader(false);
                }
                return res.text()
            }).then(text => {console.log(text)});
        }

        var suppr = () => {
            if (window.confirm("Etes vous sur de vouloir supprimer ce devoir")){
                var header = {
                    method : 'DELETE'
                }
                fetch("/api/devoir/suppression-"+data.IDDEVOIR, header).then(res => {
                    if (res.ok){
                        return res.text();
                    } else {
                        throw new Error(res.status);
                    }
                }).then(text => {
                   location.replace(text);
                }).catch(err => {
                    console.log(err);
                })
            }
        }

        form = formulaire_infos_devoir(data, submit)
        document.getElementById(root_id).appendChild(form);

        var button = document.createElement("button");
        button.className = "delete-button"
        button.innerText = "Supprimer le devoir";
        button.onclick = suppr;
        document.getElementById(root_id).appendChild(button);

    }).catch(function (error) {
        console.log(error);
    });
}

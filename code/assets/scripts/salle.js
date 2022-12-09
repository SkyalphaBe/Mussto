const typeSalle = document.getElementsByName('typeSalle')[0];

function createSelectSalle(evt){
    let oldSelect = document.getElementsByName('salle')[0];
    if(oldSelect != null)
        oldSelect.remove();
    let oldLabel = document.getElementById('salle');
    if(oldLabel!=null)
        oldLabel.remove();
    let newLabel = document.createElement('label');
    let newSelect = document.createElement('select');
    newLabel.textContent = 'Salle';
    newLabel.id = 'salle'
    newSelect.name='salle';
    typeSalle.parentNode.insertBefore(newSelect,document.getElementsByClassName('groupe')[0]);
    typeSalle.parentNode.insertBefore(newLabel,newSelect);

    let newOption;
    let numSalle

    switch(evt.target.value){
        case 'Amphi':
            for(let i = 1; i<3;i++){
                newOption = document.createElement('option');
                newOption.value = 'Amphi'+i;
                newOption.textContent = 'Amphi'+i;
                newSelect.appendChild(newOption);
            }
            break;
        case 'TD':
            numSalle = ['10','11','12','15','21'];
            for(let i = 0; i<numSalle.length;i++){
                newOption = document.createElement('option');
                newOption.value = 'S'+numSalle[i];
                newOption.textContent = 'S'+numSalle[i];
                newSelect.appendChild(newOption);
            }
            newOption = document.createElement('option');
            newOption.value = '026';
            newOption.textContent ='026';
            newSelect.appendChild(newOption);
            newOption = document.createElement('option');
            newOption.value = '028';
            newOption.textContent ='028';
            newSelect.appendChild(newOption);
            break;
        case 'TP':
            numSalle = ['01','03','13','14','16','17','22','24'];
            for(let i = 0; i<numSalle.length;i++){
                newOption = document.createElement('option');
                newOption.value = 'S'+numSalle[i];
                newOption.textContent ='S'+numSalle[i];
                newSelect.appendChild(newOption);
            }
            break;
        case 'Examen':
            newOption = document.createElement('option');
            newOption.value = 'H20';
            newOption.textContent ='H20';
            newSelect.appendChild(newOption);
            newOption = document.createElement('option');
            newOption.value = 'H21';
            newOption.textContent ='H21';
            newSelect.appendChild(newOption);
            newOption = document.createElement('option');
            newOption.value = 'S26';
            newOption.textContent ='S26';
            newSelect.appendChild(newOption);
            break;
    }
}
typeSalle.addEventListener('change', createSelectSalle);

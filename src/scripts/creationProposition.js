function updateBudgetLimit() {
    const select = document.getElementById('idThematique');
    const selectedOption = select.options[select.selectedIndex];
    
    const maxBudget = selectedOption.getAttribute('budget');

    const budgetInput = document.getElementById('budget');
    budgetInput.max = maxBudget;

    budgetInput.placeholder = "Maximum: "+maxBudget;
}

let choix=[];
let idTypeScrutin=1;
function updateFields(){
    const select = document.getElementById('typeScrutin');
    const selectedOption = select.options[select.selectedIndex];
    idTypeScrutin = Number(selectedOption.getAttribute('value'));
    choix.length=0;
    console.log("choix = "+choix);
    refrechChoixList();
    let champ1 = document.getElementById('champ1');
    let champ2 = document.getElementById('champ2');
    if(idTypeScrutin==1){
        console.log("switch to 'Pour/Contre'");
        champ1.placeholder='libellé du choix favorable';
        champ2.type='text';
        champ2.placeholder='libellé du choix défavorable';
    }else if((idTypeScrutin==2)||(idTypeScrutin==3)){
        console.log("switch to 'Majoritaire'");
        champ1.placeholder='libellé du choix';
        champ2.type='number';
        champ2.placeholder='-1 pour supprimé le choix';
        champ2.setAttribute("min","-1");
        champ2.setAttribute("max","-1");
    }
}

function addChoix(){
    if(idTypeScrutin==1){
        addForType1();
    }else if((idTypeScrutin==2)||(idTypeScrutin==3)){
        addForType2and3();
    }
}

function addForType1(){
    let champ1 = document.getElementById('champ1');
    let champ2 = document.getElementById('champ2');
    if((champ1.value=="")||(champ2.value=="")){
        return;
    }
    choix[0]=champ1.value;
    champ1.value="";
    choix[1]=champ2.value;
    champ2.value="";
    console.log("choix = "+choix);
    refrechChoixList();
}

function addForType2and3(){
    let champ1 = document.getElementById('champ1');
    let champ2 = document.getElementById('champ2');
    if(champ1.value==""){
        return;
    }else if (champ2.value=="-1"){
        let idChoix=choix.indexOf(champ1.value);
        if(idChoix!=-1){
            choix.splice(idChoix,1);
            console.log("choix = "+choix);
            refrechChoixList();
            showMessage("'"+champ1.value+"' supprimée")
            champ1.value="";
            champ2.value="";
        }else{
            showMessage("'"+champ1.value+"' non présent")
        }
    }else{
        if(choix.length==10){
            showMessage("Maximum 10 choix")
        }else{
            choix.push(champ1.value);
            console.log("choix = "+choix);
            refrechChoixList();
            champ1.value=null;
            champ2.value=null;
        }
    }
}

function refrechChoixList(){
    let textArea=document.getElementById('choix');
    textArea.value="";
    for(let i=0;i<choix.length;i++){
        textArea.value+=choix[i]+"\n";
    }
}

function choixToArray(e){
    if(choix.length<2){
        e.preventDefault();
    }else{
        let textArea=document.getElementById('choix');
        textArea.value="";
        for(let i=0;i<choix.length;i++){
            textArea.value+=choix[i]+",";
        }
    }
}

function showMessage(message){
    let textArea=document.getElementById('choix');
    textArea.value+="\n"+message;
}

document.addEventListener('DOMContentLoaded', updateBudgetLimit);
document.getElementById('idThematique').addEventListener('change', updateBudgetLimit);
document.getElementById('typeScrutin').addEventListener('change', updateFields);
document.getElementById('addChoix').addEventListener('click', addChoix);
document.querySelector('form').addEventListener("submit", choixToArray);
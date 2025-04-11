document.addEventListener('DOMContentLoaded', () => {
    const thematiques = [];
    const budgets = [];

    function sumBudgets(){
        let sum=0;
        for(let i=0;i<budgets.length;i++){
            sum+=budgets[i];
        }
        return sum;
    }

    function addThematique(e) {
        let nomThemeElement=document.getElementById('themeName');
        let budgetThemeElement=document.getElementById('themeBudget');
        const nomTheme=nomThemeElement.value;
        const budgetTheme=budgetThemeElement.value;
        const budgetGroupe=(document.getElementById('budget').value=="" ? 0 : Number(document.getElementById('budget').value));
        console.log("budgetGroupe = "+budgetGroupe);
        if (((nomTheme=="")||(budgetTheme==""))||(thematiques.length==20)) {
            console.log("valeurs incorrectes ou nombre de maximum de thématique dépassé")
            return;
        }
        if (!thematiques.includes(nomTheme)) {
            if(budgetTheme=="-1"){
                showError("pas de thématique à supprimer")
                console.log("pas de thématique à supprimer")
                return;
            }else if((sumBudgets()+Number(budgetTheme))>budgetGroupe){
                showError("Budget du groupe dépassé");
                console.log("Budget du groupe dépassé");
                return;
            }else{
                thematiques.push(nomTheme);
                budgets.push(Number(budgetTheme));
                nomThemeElement.value=null;
                budgetThemeElement.value=null;
                console.log("thematiques = "+thematiques);
                console.log("budgets = "+budgets);
                refrechThematiquesList();
            }
        }else if (budgetTheme=="-1"){
            let idThematique=thematiques.indexOf(nomTheme);
            thematiques.splice(idThematique,1);
            budgets.splice(idThematique,1);
            console.log("thematiques = "+thematiques);
            console.log("budgets = "+budgets);
            refrechThematiquesList();
            showError("'"+nomTheme+"' supprimée")
        }
    }

    function refrechThematiquesList(){
        let textArea=document.getElementById('thematiques');
        textArea.value="";
        for(let i=0;i<thematiques.length;i++){
            textArea.value+=thematiques[i]+":"+budgets[i]+"\n";
        }
    }

    function thematiquesToArray(e){
        if(thematiques.length<2){
            e.preventDefault();
        }else{
            let textArea=document.getElementById('thematiques');
            textArea.value="";
            for(let i=0;i<thematiques.length;i++){
                textArea.value+=thematiques[i]+","+budgets[i]+"\n";
            }
        }

    }

    function showError(message){
        let textArea=document.getElementById('thematiques');
        textArea.value+="\n"+message;
    }

    document.getElementById('addThematique').addEventListener('click', addThematique);
    document.querySelector('form').addEventListener("submit", thematiquesToArray);
});
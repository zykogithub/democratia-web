function toggleTheme() {
    const image = document.querySelector("img");
    const stylepage = document.styleSheets[0].cssRules; // généraliser pour un nombre de feuille de style quelconques, stocker dans un tableau stylePages
    const styleTheme = document.styleSheets[1].cssRules; // TODO : placer document theme.css en tout premier
    let i = 0
    while (stylepage[i].selectorText!==".theme" && i<stylepage.length) {
        i++
    }
    
    const rulePage = stylepage[i]
    let ruleTheme = null
    if (image.getAttribute("id") !== "dark") {
        // TODO : en faire une fonction pour les deux bouts de code
        image.setAttribute("src", "../../ressource/image/dark.png");
        document.querySelector("body").setAttribute("id","dark")
        image.setAttribute("id","dark")
        let j = 0
        while (styleTheme[j].selectorText!=="#light" && i<stylepage.length) {
            j++
        }
        ruleTheme = styleTheme[j]
    } else {
        const imageDark = document.querySelector("img");
        imageDark.setAttribute("src", "../../ressource/image/light.png");
        document.querySelector("body").setAttribute("id","light")
        image.setAttribute("id","light")
        let j = 0
        while (styleTheme[j].selectorText!=="#dark" && i<stylepage.length) {
            j++
        }
        ruleTheme = styleTheme[j]
    }
    

    // Trouver la variable CSS à l'intérieur de la règle (par exemple, --md-sys-color-background)
    
    const themeElement = document.querySelector(".theme");

    // TODO : parcourri stylePages pour changer les règles de chaque feuille de style
    if (themeElement && typeof ruleTheme.style !== 'undefined') {
        for (let index = 0; index < ruleTheme.style.length; index++) {
            const proprieteCourante = ruleTheme.style[index];
            const valeurCourante = ruleTheme.style.getPropertyValue(proprieteCourante);
            const proprieteAChanger = rulePage.style[index]

            // Vérifier si la propriété est une variable CSS
            if (proprieteCourante.startsWith('--')) {
                // Appliquer la variable CSS à l'élément .theme
                themeElement.style.setProperty(proprieteAChanger, valeurCourante);
            }
        }
    }
    


    
}

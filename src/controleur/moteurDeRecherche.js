import bowser from "bowser";
 const browser = bowser.getParser(window.navigator.userAgent);
     const browserName = browser.getBrowserName(); 

      // TODO : adapter le comportement de la fonction selon le navigateur
     switch (browserName) {
         case "Microsoft Edge":
            
             break;

         case "Opera":
            
             break;

         case "Safari":
            
             break;

         case "Firefox":
            
             break;

         case "Chrome":
            
             break;

         default:
             console.log("Navigateur inconnu");
             break;
     }
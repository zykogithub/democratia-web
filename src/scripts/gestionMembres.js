document.addEventListener('DOMContentLoaded', () => {
    function filterResults() {
        const query = document.getElementById('searchBar').value.toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, '');
        const items = document.querySelectorAll('.result-item');
        items.forEach(item => {
            const courriel = item.getAttribute('data-name').normalize('NFD').replace(/[\u0300-\u036f]/g, '');
            item.style.display = courriel.includes(query) ? '' : 'none';
        });
    }

    const usersToAdd = [];

    function toAdd(e){
        const id = Number(e.target.closest('.result-item').getAttribute('data-id'));
        
        if (!usersToAdd.includes(id)) {
            usersToAdd.push(id);
            e.target.style.backgroundColor="#599e09";
        }else{
            usersToAdd.splice(usersToAdd.indexOf(id),1);
            e.target.style.backgroundColor="#dcdcdc";
        }
    }

    const membersToDel = [];

    function toDel(e){
        const id = Number(e.target.closest('.membre-bloc').getAttribute('member-id'));
        
        if (!membersToDel.includes(id)) {
            e.target.previousElementSibling.disabled=true;
            membersToDel.push(id);
            e.target.style.backgroundColor="#b83021";
        }else{
            membersToDel.splice(membersToDel.indexOf(id),1);
            e.target.previousElementSibling.disabled=false;
            e.target.style.backgroundColor="#dcdcdc";
        }
    }

    const membersToUpg = [];
    const membersNewRoles = [];

    function onChange(e){
        if(e.target.closest('.membre-bloc').getAttribute('role').valueOf()==e.target.value.valueOf()){
            console.log('cancel update');
            cancelUpg(e);
        }else{
            console.log('update');
            toUpg(e);
        }
    }

    function cancelUpg(e){
        const id = Number(e.target.closest('.membre-bloc').getAttribute('member-id'));
        const idMembre=membersToUpg.indexOf(id)
        membersToUpg.splice(idMembre,1);
        membersNewRoles.splice(idMembre,1);
        e.target.style.backgroundColor="#ffffff";
        console.log("membersToUpg = "+membersToUpg);
        console.log("membersNewRoles = "+membersNewRoles);
        console.log("membersToDel = "+membersToDel);
    }

    function toUpg(e){
        const id = Number(e.target.closest('.membre-bloc').getAttribute('member-id'));
        const roles=['Membre','Administrateur','Décideur','Modérateur','Assesseur','Scrutateur'];
        if (!membersToUpg.includes(id)) {
            membersToUpg.push(id);
            membersNewRoles.push(roles.indexOf(e.target.value)+1);
            e.target.style.backgroundColor="f5b70c";
        }else{
            membersNewRoles[membersToUpg.indexOf(id)]=roles.indexOf(e.target.value)+1;
        }
        console.log("membersToUpg = "+membersToUpg);
        console.log("membersNewRoles = "+membersNewRoles);
        console.log("membersToDel = "+membersToDel);
    }

    function sendNewMembers(e) {
        let ids=usersToAdd;
        if (ids.length > 0) {
            let newPathname='ajoutMembres.php';
            let currentUrl = new URL(window.location.href);
            let params = new URLSearchParams(currentUrl.search);
            params.set('ids', ids.join(','));
            let redirect = `${currentUrl.origin}${currentUrl.pathname.replace('controleurListePropositions.php', newPathname)}?${params.toString()}`;
            window.location.href = redirect;
        }
    }

    function sendUpdatedMembers(e) {
        let deletedMembers=membersToDel;
        let memberIds=membersToUpg;
        let newRoles=membersNewRoles;
        if ((memberIds.length > 0) || (deletedMembers.length > 0)) {
            let newPathname='majMembres.php';
            let currentUrl = new URL(window.location.href);
            let params = new URLSearchParams(currentUrl.search);
            params.set('memberIds', memberIds.join(','));
            params.set('newRoles', newRoles.join(','));
            params.set('deletedMembers', deletedMembers.join(','));
            let redirect = `${currentUrl.origin}${currentUrl.pathname.replace('controleurListePropositions.php', newPathname)}?${params.toString()}`;
            window.location.href = redirect;
        }
    }

    // Attache les événements
    document.getElementById('searchBar').addEventListener('keyup', filterResults);
    document.querySelectorAll('.add-button').forEach(button => {
        button.addEventListener('click', toAdd);
    });
    document.querySelectorAll('.del-button').forEach(button => {
        button.addEventListener('click', toDel);
    });
    document.querySelectorAll('select.role-selector').forEach(select => {
        select.addEventListener('change', onChange);
    });
    document.getElementById('sendNewMembersButton').addEventListener('click', sendNewMembers);
    document.getElementById('sendUpdatedMembersButton').addEventListener('click', sendUpdatedMembers);
});
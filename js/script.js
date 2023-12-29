document.addEventListener('DOMContentLoaded', function () {
    const addButton = document.getElementById('ajouterEquipe');
    const modal = document.getElementById('modal');
    const closeButton = document.querySelector('.close');
    const teamForm = document.getElementById('teamForm');
    const tournamentForm = document.getElementById('tournamentForm');
    const equipesBody = document.getElementById('equipesBody');
    const tournamentNameField = document.getElementById('tournamentName');
    const tournoisBody = document.getElementById('tournoisBody');

    addButton.addEventListener('click', function () {
        modal.style.display = 'block';
    });

    closeButton.addEventListener('click', function () {
        modal.style.display = 'none';
    });

    teamForm.addEventListener('submit', function (e) {
        e.preventDefault();
        const teamName = document.getElementById('teamName').value;
        const teamCountry = document.getElementById('teamCountry').value;
        const teamOther = document.getElementById('teamOther').value;

        const tournament = tournamentNameField.value;

        if (!tournoisEnregistres.hasOwnProperty(tournament)) {
            tournoisEnregistres[tournament] = [];
        }

        tournoisEnregistres[tournament].push({ name: teamName, country: teamCountry, other: teamOther });

        afficherEquipesPourTournoi(tournament);

        closeModal();
        teamForm.reset();
    });

    tournamentForm.addEventListener('submit', function (e) {
        e.preventDefault();
        const tournamentName = tournamentNameField.value;

        if (!tournoisEnregistres.hasOwnProperty(tournamentName)) {
            tournoisEnregistres[tournamentName] = [];
        }

        afficherEquipesPourTournoi(tournamentName);
        afficherTournoisEnregistres();

        tournamentNameField.value = '';
    });

    // Fonction pour afficher les équipes pour un tournoi spécifique
    function afficherEquipesPourTournoi(tournament) {
        equipesBody.innerHTML = '';

        if (tournoisEnregistres.hasOwnProperty(tournament)) {
            tournoisEnregistres[tournament].forEach(function (equipe) {
                const newRow = equipesBody.insertRow();
                const cell1 = newRow.insertCell(0);
                const cell2 = newRow.insertCell(1);
                const cell3 = newRow.insertCell(2);

                cell1.innerHTML = equipe.name;
                cell2.innerHTML = equipe.country;
                cell3.innerHTML = equipe.other;
            });
        }
    }

    // Fonction pour afficher les tournois enregistrés dans le tableau des tournois
    function afficherTournoisEnregistres() {
        tournoisBody.innerHTML = '';

        for (const tournament in tournoisEnregistres) {
            const newRow = tournoisBody.insertRow();
            const cell = newRow.insertCell(0);
            cell.innerHTML = tournament;
        }
    }

    function closeModal() {
        modal.style.display = 'none';
    }
});

// Exemple de données de résultats de matchs pour différents tournois (à remplacer par vos données réelles)
const tournamentResults = {
    1: [
      { equipe: 'Équipe A', points: 20, victoires: 6, defaites: 2, nuls: 2, buts: 18 },
      { equipe: 'Équipe B', points: 18, victoires: 5, defaites: 3, nuls: 2, buts: 15 },
      // ... Autres données pour le tournoi 1 ...
    ],
    2: [
      { equipe: 'Équipe X', points: 25, victoires: 7, defaites: 1, nuls: 0, buts: 22 },
      { equipe: 'Équipe Y', points: 18, victoires: 5, defaites: 3, nuls: 2, buts: 16 },
      // ... Autres données pour le tournoi 2 ...
    ],
    // Ajoute d'autres données pour les autres tournois
  };
  
  // Fonction pour afficher les résultats en fonction du tournoi sélectionné
  function updateResults() {
    const selectedTournament = document.getElementById('tournamentSelect').value;
    const resultsBody = document.getElementById('resultsBody');
    resultsBody.innerHTML = ''; // Efface les résultats actuels
  
    const selectedResults = tournamentResults[selectedTournament];
  
    // Affiche les résultats du tournoi sélectionné
    selectedResults.forEach((result, index) => {
      const row = resultsBody.insertRow();
  
      // Crée les cellules pour chaque propriété de résultat
      const cells = [
        index + 1,
        result.equipe,
        result.points,
        result.victoires,
        result.defaites,
        result.nuls,
        result.buts
      ];
  
      // Remplit les cellules de la ligne
      cells.forEach((cellData, cellIndex) => {
        const cell = row.insertCell(cellIndex);
        cell.textContent = cellData;
      });
    });
  }
  
  // Appel initial pour afficher les résultats du premier tournoi au chargement de la page
  window.onload = updateResults;
  
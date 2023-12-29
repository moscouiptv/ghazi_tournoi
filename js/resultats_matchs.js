let matchCount = 1; // Compteur de matchs

function addMatch() {
  const matchesContainer = document.getElementById('matchesContainer');
  
  const matchDiv = document.createElement('div');
  
  const matchLabel = document.createElement('label');
  matchLabel.textContent = `Match ${matchCount}:`;
  matchDiv.appendChild(matchLabel);
  
  const team1Input = document.createElement('input');
  team1Input.type = 'text';
  team1Input.placeholder = 'Équipe 1';
  team1Input.name = `team${matchCount}_1`;
  matchDiv.appendChild(team1Input);
  
  const team2Input = document.createElement('input');
  team2Input.type = 'text';
  team2Input.placeholder = 'Équipe 2';
  team2Input.name = `team${matchCount}_2`;
  matchDiv.appendChild(team2Input);
  
  const goalsTeam1Input = document.createElement('input');
  goalsTeam1Input.type = 'number';
  goalsTeam1Input.placeholder = 'Buts Équipe 1';
  goalsTeam1Input.name = `goals_team${matchCount}_1`;
  matchDiv.appendChild(goalsTeam1Input);
  
  const goalsTeam2Input = document.createElement('input');
  goalsTeam2Input.type = 'number';
  goalsTeam2Input.placeholder = 'Buts Équipe 2';
  goalsTeam2Input.name = `goals_team${matchCount}_2`;
  matchDiv.appendChild(goalsTeam2Input);
  
  matchesContainer.appendChild(matchDiv);
  
  matchCount++;
}

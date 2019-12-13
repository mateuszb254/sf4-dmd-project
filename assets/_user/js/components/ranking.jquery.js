const rankingPlayersButton = document.getElementById('ranking-players-button');
const rankingGuildsButton = document.getElementById('ranking-guilds-button');

const rankingPlayers = document.getElementById('ranking-players');
const rankingGuilds = document.getElementById('ranking-guilds');

rankingPlayersButton.addEventListener('click', changeDisplayedRank);
rankingGuildsButton.addEventListener('click', changeDisplayedRank);

function changeDisplayedRank(event) {
    let button = event.srcElement;

    if (button.disabled) {
        return;
    }

    rankingPlayers.style.display = 'none';
    rankingGuilds.style.display = 'none';

    if (button == rankingPlayersButton) {
        rankingPlayers.style.display = 'table';
        rankingGuildsButton.disabled = false;
    } else {
        rankingGuilds.style.display = 'table';
        rankingPlayersButton.disabled = false;
    }

    button.disabled = true;
}

const selectionOne = document.getElementById('selectionOne');
const selectionTwo = document.getElementById('selectionTwo');
const players = document.getElementById('players');
const newPlayer = document.getElementById('newPlayer');
const newButton = document.getElementById('newPlayBut');
const gameButton = document.getElementById('gameButton');

const rows = players.childNodes[1].childNodes;

const rowValues = [];

rows.forEach((row,i) => {
  let values = [];
  if (i > 0) {
    for (let k = 2; k < row.childNodes.length; k++) {
      values.push(row.childNodes[k].innerHTML);
    }
    rowValues.push(values);
  }
})

function checkInput(e) {
  let sameName = false;
  rowValues.forEach(value => {
    if (value[0] === e.target.value) {
      sameName = true;
    }
    if (e.target.value.includes(' ')) {
      sameName = true;
    }
  });

  if (sameName) {
    e.target.style.background = 'red';
    newButton.setAttribute('disabled', 'true');
  } else {
    e.target.style.background = 'lightgreen';
    newButton.removeAttribute('disabled');
  }
}

rowValues.forEach(value => {
  selectionOne.innerHTML += `<option value=${value[0]}>${value[0]}</option>`;
  selectionTwo.innerHTML += `<option value=${value[0]}>${value[0]}</option>`;
})

function checkGame() {
  if (selectionOne.value === selectionTwo.value) {
    gameButton.setAttribute('disabled', true);
  } else {
    gameButton.removeAttribute('disabled');
  }
}

newPlayer.addEventListener('keyup', (e) => checkInput(e));
selectionOne.addEventListener('change', checkGame);
selectionTwo.addEventListener('change', checkGame);

checkGame();
// Following file is using eslint Airbnb styling:
// https://github.com/airbnb/javascript
// I also got rid of var definitions:
// https://blog.pragmatists.com/let-your-javascript-variables-be-constant-1633e56a948d

const clickedArray = [];
// Cell colours
const colours = ['blue', 'red', 'green', 'orange', 'purple', 'pink', 'gray'];
const panelText = document.getElementById('panel');
const minutes = document.getElementById('minute');
const seconds = document.getElementById('second');
let displaySeconds;
let totalSeconds = 0;
let totalMinutes = 0;
let timer;

const btnStart = document.getElementsByClassName('btnStart').button;
addListener('click', btnStart, makeGrid, false);

function timerOn() {
  // Calculate passed time and show it in the timer
  totalSeconds += 0.1;
  totalSeconds = Math.round(totalSeconds * 10) / 10;
  displaySeconds = totalSeconds.toFixed(1);
  seconds.innerHTML = displaySeconds;
  minutes.innerHTML = totalMinutes;

  if (totalSeconds >= 60) {
    totalMinutes += 1;
    totalSeconds = 0;
  }
}

function timerOff() {
  clearInterval(timer);
}

function allClicked(clicked) {
  // If everything is coloured black, return true
  return clicked.value === true;
}

function randomColourSingle(cell) {
  const randomIndex = Math.floor(Math.random() * colours.length);
  const randomColour = colours[randomIndex];
  cell.style.backgroundColor = randomColour;
}

function cellClicked(cell) {
  let oldColour = cell.style.backgroundColor;
  if (oldColour !== 'black') {
    // Colour cell black
    cell.style.backgroundColor = 'black';
    cell.value = true;
    panelText.style.color = oldColour;
    // Start with capital letter
    oldColour = oldColour.charAt(0).toUpperCase() + oldColour.slice(1);
    panelText.innerHTML = oldColour;

    // Return true if every element is black (true)
    if (clickedArray.every(allClicked)) {
      // Win condition
      timerOff();
      panelText.innerHTML = 'GAME OVER!';
      panelText.style.color = 'salmon';
      alert('You beat the game! Time: '
      + totalMinutes + 'minutes and ' + displaySeconds + 'seconds!');
    }
  }
}

function makeGrid() {
  // Hide the button and make grid (and glow) visible
  btnStart.style.visibility = 'hidden';
  document.getElementById('grid').style.visibility = 'visible';
  const grid = document.getElementsByClassName('grid')[0];

  // If any children exists. Remove them before creating new ones
  // This is a failsafe if button appears or is set visible for a new game
  if (grid.firstChild) {
    while (grid.firstChild) {
      grid.removeChild(grid.firstChild);
    }
  }

  for (let i = 0; i < 6; i += 1) {
    const row = document.createElement('div');
    row.classList.add('row');

    for (let j = 0; j < 6; j += 1) {
      const cell = document.createElement('div');
      cell.classList.add('cell');
      cell.value = false; // Add boolean value to indicate if cell is black
      clickedArray.push(cell);
      row.appendChild(cell);

      randomColourSingle(cell);
      // addListener is a function located in ../personalLibrary.js
      addListener('click', cell, cellClicked, true);
    }
    grid.appendChild(row);
  }
  timer = setInterval(timerOn, 100);
}

// Following file is using eslint Airbnb styling:
// https://github.com/airbnb/javascript
// I also got rid of var definitions:
// https://blog.pragmatists.com/let-your-javascript-variables-be-constant-1633e56a948d

const clickedArray = [];
// Cell colours
const colours = ['blue', 'red', 'green', 'orange', 'purple', 'pink', 'gray'];
const paircolours = colours.slice(0); // copy array
const panelText = document.getElementById('panel');
const minutes = document.getElementById('minute');
const seconds = document.getElementById('second');
let displaySeconds;
let idIndex = 0;
let oldCell;
let totalSeconds = 0;
let totalMinutes = 0;
let timer;

const btnStart = document.getElementsByClassName('btnStart').button;
addListener('click', btnStart, makeGrid, false);
fillColourArray();

function fillColourArray() {
  paircolours.splice(Math.floor(Math.random() * paircolours.length), 1); // remove random
  for (let i = 0; i < 6; i += 1) {
    const color = paircolours[i];

    for (let j = 0; j < 5; j += 1) {
      // Copy and add five copies of colour
      paircolours.push(color);
    }
  }
  paircolours.sort(() => 0.5 - Math.random()); // Shuffle array
}

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

function randomColourPair(cell) {
  cell.style.backgroundColor = paircolours[0];
  paircolours.shift();
}

function cellClicked(cell) {
  let backGround = cell.style.backgroundColor;
  if (backGround !== 'black') {
    cell.style.opacity = '0.7';

    // If old cell exists (starting from second click) and cells clicked are different ones
    if (oldCell !== undefined && oldCell.id !== cell.id) {
      oldCell.style.opacity = '1';

      if (oldCell.style.backgroundColor === backGround) {
        // Colour cells black
        cell.style.backgroundColor = 'black';
        oldCell.style.backgroundColor = 'black';
        // Values indicate black colour
        cell.value = true;
        oldCell.value = true;
        panelText.style.color = backGround;

        // Start with capital letter
        backGround = backGround.charAt(0).toUpperCase() + backGround.slice(1);
        panelText.innerHTML = backGround;

        // Remove opacity
        cell.style.opacity = '1';
      }
    }

    oldCell = cell;

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
  // Hide the button and make grid visible (and glow)
  // Also disable button to avoid misuse
  btnStart.disabled = true;
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
      cell.id = idIndex; // Add id (ranges from 0-35)
      clickedArray.push(cell);
      row.appendChild(cell);

      randomColourPair(cell);
      // addListener is a function located in ../personalLibrary.js
      addListener('click', cell, cellClicked, true);
      idIndex += 1;
    }
    grid.appendChild(row);
  }
  timer = setInterval(timerOn, 100);
}

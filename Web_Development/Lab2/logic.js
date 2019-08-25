// Returns HTTMLCollection
var imgChildren = document.getElementById("thumbnails").children;
let childrenArray = [];
let time = setInterval(getTime, 3000);
let clock = document.getElementById("clock");
clock.innerHTML = new Date().toLocaleTimeString('en-GB', { hour: "numeric", minute: "numeric", second: "numeric"});
clock.addEventListener("mouseover", function() {
  clock.style.backgroundColor = getRandomColour();
});
clock.addEventListener("mouseout", function() {
  clock.style.backgroundColor = "transparent";
});

// Loop through children and add click listeners immediately. why:
// http://www.albertgao.xyz/2016/08/21/what-is-a-closure-in-javascript-and-why-they-are-wrong/
// http://www.albertgao.xyz/2016/08/25/why-not-making-functions-within-a-loop-in-javascript/
// TL;DR it's possible to make click listener in loop, but it requires anonymous function
// and that's not recommended style.
for (let i = 0;  i < imgChildren.length; i++) {
  addClickListener(imgChildren[i]);
  childrenArray.push(imgChildren[i]);
}

function addClickListener(child) {
  // Add click listener and send source forward
  child.addEventListener("click", function() {
    imageChanges(child);
  });
}

function imageChanges(srcImg) {
  var bigPic = document.getElementById("bigPic"); // Big image
  var newThumbnail = bigPic.src;                  // Save path to use it later
  bigPic.src = srcImg.src;                        // Replace big image

  childrenArray.every(removeBorder);
  srcImg.style.border = "3px solid salmon";
  srcImg.src = newThumbnail;                      // Replace thumbnail
}

// Manage changes by changing css files
function buttonClick() {
  var cssUsed = document.getElementById("external");

  if (cssUsed.href.endsWith("professional.css"))
    cssUsed.href = "creative.css";
  else
    cssUsed.href = "professional.css";
}

function buttonAnswer(bId, pId) {
  var button = document.getElementById(bId);
  var question = document.getElementById(pId);

  if (question.style.visibility == "hidden") {
    question.style.visibility = "visible";
    button.innerHTML = "Hide Answer";
  }

  else if (question.style.visibility == "visible") {
    question.style.visibility = "hidden";
    button.innerHTML = "Show Answer";
  }
}

function removeBorder(thumbnail) {
  return thumbnail.style.border = "none";
}

function getTime() {
  clock.innerHTML = new Date().toLocaleTimeString('en-GB', { hour: "numeric", minute: "numeric", second: "numeric"});
}

function getRandomColour() {
  var r = Math.floor(Math.random() * 256);
  var g = Math.floor(Math.random() * 256);
  var b = Math.floor(Math.random() * 256);
  var rgb = 'rgb(' + r + ',' + g + ',' + b + ')';
  return rgb;
}

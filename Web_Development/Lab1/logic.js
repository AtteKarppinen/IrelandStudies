function identifier() {
  var className = document.getElementById("doc").className;

  if (className == "Styling") {
    document.getElementById("ditImg").src = "resources/DITNormal.jpg";
    document.getElementById("meImg").src = "resources/meNormal.png";
  }

  else if (className == "Styling Professional") {
    document.getElementById("ditImg").src = "resources/DITProfessional.jpg";
    document.getElementById("meImg").src = "resources/meProfessional.png";
  }

  else if (className == "Styling Creative") {
    document.getElementById("ditImg").src = "resources/DITCreative.jpg";
    document.getElementById("meImg").src = "resources/meCreative.png";
  }

  // Change class programmatically to save switching in index.html
  document.getElementById("divLeft").className = className + " Left";
  document.getElementById("divRight").className = className + " Right";
}

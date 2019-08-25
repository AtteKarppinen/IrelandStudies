<!DOCTYPE html>
<html style="height: 100%;">

<head>
  <link rel="stylesheet" href="styles.css">
  <link rel="stylesheet" href="professional.css" id="external">
  <title>CV Covert Letter</title>

  <!-- Google JQuery library -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <!-- JQuery UI CSS-->
  <link href="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css" rel="stylesheet" type="text/css">
  <!-- JQuery UI Js-->
  <script
    src="https://code.jquery.com/ui/1.11.4/jquery-ui.js"
    integrity="sha256-DI6NdAhhFRnO2k51mumYeDShet3I8AKCQf/tf7ARNhI="
    crossorigin="anonymous"></script>
</head>

<body class="Styling External" id="doc">

  <!-- Big picture -->
  <img src="resources/kaerMorhen.jpg" alt="Big image" id="bigPic">
  <div id="thumbnails">
    <!-- Thumbnail pictures -->
    <img src="resources/hogwarts.jpg" alt="thumbnails">
    <img src="resources/hobbiton.jpg" alt=thumbnails>
    <img src="resources/winterfell.jpg" alt="thumbnails">
  </div>

  <!-- Button to change stylesheets: -->
  <button type="button" onclick="buttonClick()" id="btn">Change Class</button>

  <div class="Container" size="A4">
    <!-- The left side includes: Contact info, Education, Recommenders -->
    <div class="Styling External Left" id="divLeft">

      <img src="resources/meNormal.png" class="rounded" alt="Profile" id="meImg" style="text-align: center;" />

      <div style="word-break: break-all;">
        <h2>CONTACT INFO</h2>
        <p>John Doe</p>
        <p>JohnDoe@gmail.com</p>
        <p>+35 044 055 066 98</p>
        <p>example.com</p>
      </div>
      <hr>

      <h2>EDUCATION</h2>
      <table>
        <tr>
          <th>Education</th>
          <th>Year</th>
          <th>Grade</th>
        </tr>
        <tr>
          <td>Software developer</td>
          <td>TBA</td>
          <td>TBA</td>
        </tr>
      </table>
      <hr>

      <h2>REFERENCES</h2>
      <ul style="text-align: left;">
        <li>One</li>
        <li>Can</li>
        <li>Hope</li>
      </ul>

      <div class="questions">
        <p>What kind</p><button type="button" id="b1" onclick="buttonAnswer('b1', 'p1')">Show Answer</button><br>
        <p>Of resume</p><button type="button" id="b2" onclick="buttonAnswer('b2', 'p2')">Show Answer</button><br>
        <p>has questions?</p><button type="button" id="b3" onclick="buttonAnswer('b3', 'p3')">Show Answer</button><br>
      </div>
    </div>

    <!-- The right side includes: Experience, Projects etc -->
    <div class="Styling External Right" id="divRight">

      <div style="text-align: center;">
        <a href="http://www.dit.ie/" target="_blank">
          <img src="resources/DITNormal.jpg" alt="resources/DITCreative" class="rounded" id="ditImg">
        </a>
        <div class='time'>
          <p id='clock'></p>
        </div>
        <h1>Curriculum Vitae</h1>
      </div>

      <div>
        <h2>Summary</h2>
        <p>Introduction text that tells very generously about me and bit of my Interests.</p>
        <p>This paragraph focus more on my skills as a programmer and what I would like to do in the future.</p>
      </div>

      <!-- Lists -->
      <div>
        <ul style="display: inline;">
          <li>
            <h3>Jobs and responsibilities</h3>
            <ul>
              <li>I worked for this company for a while</li>
              <li>And for this one for a little longer</li><br>
            </ul>
          </li>
          <li>
            <h3>Projects:</h3>
            <ol>
              <li>Amateur project</li>
              <li>Intermediate project</li>
              <li>Pro project</li><br>
            </ol>
          </li>
          <li>
            <h3>Technologies</h3>
            <ul>
              <li>Just the most important</li>
              <li>Technologies that I know</li><br>
            </ul>
          </li>
        </ul>
      </div>

      <!-- Links to old schools -->
      <div>
        <h3>Old schools:</h3><br>
        <a href="https://www.oamk.fi/en/" target="_blank">Link to Oulu University of Applied Sciences</a> <br>
        <a href="https://peda.net/raahe/raahen-lukio" target="_blank">Link to my old upper secondary school</a> <br />
        <a href="https://peda.net/raahe/peruskoulut/pattasten-koulu" target="_blank">Link to my old junior high school</a> <br>
      </div>

      <div class="Styling">
        <p id="p1" style="visibility: hidden;">I</p>
        <p id="p2" style="visibility: hidden;">Wouldn't</p>
        <p id="p3" style="visibility: hidden;">Know</p>
      </div>

      <button type="button" id="ajaxBtn">Show Covert Letter</button><br>

    </div>
  </div>
  <!-- Introduce script last to make eventListeners work -->
  <script src="logic.js"></script>
</body>

</html>

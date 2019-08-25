// This library contains all kinds of useful necessities

// *****************************************************************************
// Add click listener to one element.
// Syntax: addListener(a, b, c, d)
// Where a is the type of event listener you want to add (String),
// b is element you want to attach the listener,
// c is the function you want to run when element is triggered
// and d is boolean if you want to send the element as a parameter

function addListener(eventType, element, functionToRun, forwardElement) {
  try {
    element.addEventListener(eventType, () => {
      // Refer to function when element is triggered:
      if (forwardElement === true) {
        functionToRun(element);
      } else {
        functionToRun();
      }
    });
  } catch (e) {
    console.log('DEV MSG: Check addListener function call \n', e);
  }
}

// *****************************************************************************

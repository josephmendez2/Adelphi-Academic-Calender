var navLeftButton = document.querySelector('.calendar-nav-left');
var navRightButton = document.querySelector('.calendar-nav-right');
var fallSemesterButton = document.querySelector('.fallSemesterButton');
var springSemesterButton = document.querySelector('.springSemesterButton');
var currentButton =  document.querySelector('.currentButton');
var navMonth = document.querySelector('.calendar-nav-date');
const now = moment();
const aug = moment('2019-08-01');
const jan = moment('2019-01-05');

//sets up initial page
navMonth.textContent = now.format('MMMM YYYY');
populateCalendar(now);
getEvents();


// Get reference to the create button
var createButton = document.getElementById("createButton");
var form = document.getElementById("create-event-form");
// Add a click handler on the button
createButton.addEventListener("click", (e) => {
  e.preventDefault();
  // createEventForm.submit();


  createEvent();
})

async function createEvent() {
  const event = grabEventFromForm(form);
  const response = await postEvent(event);
  if (response.ok) {
    addEventToCalendar(moment(event.eventDate), event);
    $('#create-event-modal').modal('hide');
  } else {
    console.log('The response was not okay: ', response);
  }
  var blob = await response.blob();
  blob.text().then(text => console.log(text));
}

function grabEventFromForm(form) {
  const event = {};
  const inputs = form.querySelectorAll("input");
  for ( var i = 0; i <inputs.length; i++) {
    const current = inputs[i];
    event[current.name] = current.value;
  }
  console.log(event);
  return event;
}

async function deleteEvent(event) {
//get event title from form
//get list of all events
//compare name of title requested with those in the list
//if found, remove it from the database
//if not found, dismiss or tell user to reenter
  var eventToBeDeleted = grabEventFromForm(form);
  var eventList = getEvents();
}

async function editEvent(event) {
//get name of event to be changed
//get list of all events
//compare name of title requested with those in the list
//if found, remove it from the database and create a new event using the info from the form
//if not found, dismiss or tell user to reenter
var eventToBeEdited = grabEventFromForm(form);
}

// Get reference to modal form
// call form.submit()

// const data = postEvent({
//   eventName: 'Doctor Appointment',
//   eventDate: '2019-11-29',
//   eventDescription: 'Kill 46 million turkeys on average.',
//   eventTermID: 1
// });

async function postEvent(event) {
  const response = fetch('https://compsci.adelphi.edu:8842/~yaelweiss/seCalendar/Calendar/addEvents.php',{
    method: 'POST',
    mode: 'cors',
    body: JSON.stringify(event)
  });
  return response;
}

function addMonth(e) {
  now.add(1, 'month');
  //itll reset new month, formatted
  navMonth.textContent = now.format('MMMM YYYY');
}
function subtractMonth(e) {
  now.subtract(1, 'month');
  navMonth.textContent = now.format('MMMM YYYY');
}
//2 event listeners
navLeftButton.addEventListener("click", (e) => {
  //submit has a default action (refresh), preventDefault doesn't allow that behavior to occur
  e.preventDefault();
  subtractMonth(e);
  populateCalendar(now);
  getEvents();
})
navRightButton.addEventListener("click", (e) => {
  //submit has a default action (refresh), preventDefault doesn't allow that behavior to occur
  e.preventDefault();
  addMonth(e);
  populateCalendar(now);
  getEvents();
})

// when button is clicked, it adds one year to the month and makes month automatically August of upcoming year
function fallSemester(e) {
  aug.add(1, 'year');
  navMonth.textContent = aug.format('MMMM YYYY');
  now.add(1, 'year').month('August');
}
//add 1 event listener
fallSemesterButton.addEventListener("click", (e) => {
  //submit has a default action (refresh), preventDefault doesn't allow that behavior to occur
  e.preventDefault();
  fallSemester(e);
  populateCalendar(aug);
  getEvents();

  })
// when button is clicked, it adds one year to the month and makes month automatically January of upcoming year
function springSemester(e) {
  jan.add(1, 'year');
  navMonth.textContent = jan.format('MMMM YYYY');
  now.add(1, 'year').month('January');
}
//add 1 event listener
springSemesterButton.addEventListener("click", (e) => {
  //submit has a default action (refresh), preventDefault doesn't allow that behavior to occur
  e.preventDefault();
  springSemester(e);
  populateCalendar(jan);
  getEvents();

  })

 // goes back to the current year and current month.
function gotoCurrent(e) {
  navMonth.textContent = now.format('MMMM YYYY');
}
//add 1 event listener
currentButton.addEventListener("click", (e) => {
  location.reload();
  gotoCurrent(e);
  populateCalendar(now);
  getEvents();

  })

function populateCalendar(date) {

  const days = Array.from(document.querySelectorAll('.day'));
  const dayIndices = new Map([
    ['Monday', 0],
    ['Tuesday', 1],
    ['Wednesday', 2],
    ['Thursday', 3],
    ['Friday', 4],
    ['Saturday', 5],
    ['Sunday', 6]
  ]);
  //can't mutate date, so clone it.
  const firstDayOfMonth = date.clone().date(1);
  //format is not a mutating method
  console.log(firstDayOfMonth.format());
  // Once you have the first day of the month, you need to know the index.
  // The dictionary keys are day names. I get the day of the first month like 'Friday' to match
  // an index of 4.
  const firstDayIndex = dayIndices.get(firstDayOfMonth.format('dddd'));
  const dayOfFirstBox = firstDayOfMonth.clone().subtract(firstDayIndex, 'days');
  let iterator = dayOfFirstBox.clone();

  for (let i = 0; i < days.length; i++) {
    const dayDiv = days[i];
    dayDiv.innerHTML = '';
    dayDiv.textContent = iterator.date();
    dayDiv.dataset.day = iterator.format('DD');
    dayDiv.dataset.month = iterator.format('MM');
    dayDiv.dataset.year = iterator.year();
    iterator = iterator.add(1, 'days');
  }
  console.log(dayOfFirstBox.format('dddd, MM-DD-YYYY'));
}

function hide(element) {
  element.classList.add("hide");
}

function show(element) {
  element.classList.remove("hide");
}

var nav = document.getElementById("nav-bar");
var login = document.getElementById("login-view");
var sidebar = document.getElementById("sidebar");
var calendar = document.getElementById("calendar");

nav.addEventListener("click", (e) => {
  var element = e.target;
  if (element.textContent === "Login") {
    e.preventDefault();
    show(login);
    hide(sidebar);
    hide(calendar);
  }
  else if (element.textContent === "Calendar") {
    e.preventDefault();
    hide(login);
    show(sidebar);
    show(calendar);
  }
})

async function getEvents() {
   const response = await fetch('https://compsci.adelphi.edu:8842/~yaelweiss/seCalendar/Calendar/getEvents.php');
   let events = await response.json();


  console.log('The events: ', events);
   // sort the events
   events.sort((eventA, eventB) => {
    var a = moment(eventA.date);
    var b = moment(eventB.date);
    return a.diff(b);
   })
   console.log(events);
   var days = document.querySelectorAll(".day");




  for (let i = 0; i < days.length; i++) {
    const dayDiv = days[i];
    const dayDivDate = makeDateFromDayDiv(dayDiv);
    for (let j = 0; j < events.length; j++) {
      const event = events[j];
      const eventMoment = moment(event.eventDate);
      if (dayDivDate === eventMoment.format('YYYY-MM-DD')) {
        dayDiv.appendChild(createEventDiv(event));
      }
    }
  }
}

function createEventDiv(event) {
  const div = document.createElement('div');
  div.classList.add('event');
  div.textContent += event.eventName;
  return div;
}

function makeDateFromDayDiv(dayDiv) {
  var day = dayDiv.dataset.day;
  var month = parseInt(dayDiv.dataset.month, 10);
  if (month < 10) {
    month = `0${month}`;
  }
  var year = dayDiv.dataset.year;
  return `${year}-${month}-${day}`; // YYYY-M-D 2019-1-1 or 2019-11-25
}

function getDayDivByMoment(moment) {
  const dayDivs = Array.from(document.querySelectorAll('.day'));
  const div = dayDivs.find(div => {
    const dateOfDiv = makeDateFromDayDiv(div);
    return moment.format('YYYY-MM-DD') === dateOfDiv;
  });
  return div;
}

function addEventToCalendar(moment, event) {
  const div = getDayDivByMoment(moment);
  if (div) {
    div.appendChild(createEventDiv(event));
  } else {
    throw new TypeError('No day div was provided');
  }
}
//  var firstDay, lastDay;
  //  if (days) {
  //    firstDay = parseInt(days[0].textContent, 10);
  //    lastDay = parseInt(days[days.length - 1].textContent, 10);

  //    console.log(firstDay, lastDay);
  //  }
  //  if (firstDay > 1 ) {
  //   //if the first day is greater than one, then that date is part of the previous month
  //   var previousMonth = moment().subtract(1, 'months');
  //   previousMonth.date(firstDay);
  //   firstDay = previousMonth;
  //   console.log('first day: ' , firstDay);
  //  } else {
  //    //the first day is part of the current month
  //    firstDay = moment().date(1);
  //  }
  //  console.log(moment().endOf("month").date())
  //  var currentMonthsLastDate = moment().endOf("month").date()
  //  if (lastDay < currentMonthsLastDate) {
  //    //if the last date in the whole calendar is less then the current Month's last date, then it is part of the next month
  //    var nextMonth = moment().add(1, 'months');
  //    nextMonth.date(lastDay);
  //    lastDay = nextMonth;
  //  } else {
  //    lastDay = currentMonthsLastDate;
  //  }

   // The values are in milliseconds since Unix Epoch
  //  const valueOfFirstDay = firstDay.set({hour:0,minute:0,second:0,millisecond:0}).valueOf();
  //  const valueOfLastDay = lastDay.set({hour:0,minute:0,second:0,millisecond:0}).valueOf();
  //  console.log('first day: ', firstDay, 'last day: ', lastDay);






    // find the event that has the first date in your calendar month view
    // find the event that has the last date in your calendadr month view
    // grab all the events between those two dates
    // for each event object
      // place event info in correct calendar day box


  // const eventsToShow = []
  // for (let event of events) {
  //   const eventValue = moment(event.date).set({hour:0,minute:0,second:0,millisecond:0}).valueOf();
  //   if (eventValue >= valueOfFirstDay && eventValue <= valueOfLastDay) {
  //     eventsToShow.push(event);
  //   }
  // }


  /*
  // [
  //   { "title": "event1", "date": "2019-11-20"},
  //   { "title": "event2", "date": "2019-12-08"},
  //   { "title": "Yael's Birthday", "date": "2019-11-22"},
  //   { "title": "Yael's Birthday", "date": "2019-11-22"},
  //   { "title": "Yael's Birthday", "date": "2019-11-22"},
  //   { "title": "Yael's Super Cool Birthday", "date": "2019-11-22"},
  //   { "title": "event4", "date": "2019-11-23"},
  //   { "title": "event5", "date": "2019-10-28"},
  //   { "title": "event6", "date": "2019-09-21"},
  //   { "title": "event7", "date": "2019-11-22"},
  //   { "title": "event8", "date": "2019-10-23"}

  // ]
  let events = `

  [
    {"title":"Matriculation Day", "date":"2019-08-25"},
    {"title":"First Day of Classes","date":"2019-08-26"},
    {"title":"Labor Day","date":"2019-09-02"},
    {"title":"Last Day to Add a Course","date":"2019-09-09"},
    {"title":"Last day to Drop a Course","date":"2019-09-23"}
  ]
  `;
*/


  // console.log("hello");
  // console.log(events);
  //events = JSON.parse(events);

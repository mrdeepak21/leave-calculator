//Wordpress jQuery
$ = jQuery.noConflict();

var errorFlag = true;
var monthTotal = [];

$('.month').fadeOut();

window.onload = function () {
  $('#prealoader').fadeOut();
}

const getDays = (month) => {
  return new Date(new Date().getFullYear(), month, 0).getDate();
};

function isWeekend(month, date) {
  return new Date(new Date().getFullYear() + ',' + month + ',' + date).getDay() === 0 || new Date(new Date().getFullYear() + ',' + month + ',' + date).getDay() === 6 ? true : false;
}

function generateCalender(month) {
  const day = new Date(new Date().getFullYear() + ',' + month + ',1').getDay() + 1;
  let date = 1;
  let calender = '';
  for (let row = 1; row <= Math.ceil((getDays(month) / 7) + 1); row++) {
    calender += '<tr>';
    for (let column = 1; column <= 7; column++) {
      if ((column < day && row == 1)) {
        calender += '<td></td>';
      } else {
        calender += `<td><small class="small text-muted smalldate">${date}</small><span><input type="number" class="input-hours" name="hours[]" min="0" max="12" isweekend=${isWeekend(month, date)} date="${new Date().getFullYear()}-${month}-${date}" ></span></td>`;
        date++;
      }
      if (date > getDays(month)) {
        break;
      }
    }
    calender += '</tr>';
    if (date > getDays(month)) {
      calender += `<tr><td colspan=7><small>Total: <span id="mo${month}">0</span></small></td></tr>`;
      break;
    }
  }
  $('table#' + month + ' tbody').html(calender);
  fmlaHours();
}


function isLeapYear(year) {
  return ((year % 4 == 0) && (year % 100 != 0)) || (year % 400 == 0);
}

//return Total Used  Hours
function countUsed() {
  let used = 0;
  monthTotal.forEach((val, key) => {
    used += val;
  })
  return used;
}

var avg = Number.parseFloat($('#avg_hours').val());
var total = (avg * 12).toFixed(2);
var calcData = [countUsed(), total - countUsed()];


//Chart
google.charts.load("current", { packages: ["corechart"] });
google.charts.setOnLoadCallback(drawChart);
function drawChart() {
  var data = google.visualization.arrayToDataTable([
    ['Total Hours Used', 'Total Hours Available'],
    ['Total Hours Used', calcData[0]],
    ['Total Hours Available', calcData[1]]
  ]);

  var options = {
    pieHole: 0.5,
    colors: ['#db6926', '#173e64'],
    legend: { position: 'bottom' },
  };

  var chart = new google.visualization.PieChart(document.getElementById('fmlachart'));
  chart.draw(data, options);
}

//Change the Values of Front End of Total Section
function updateTotal() {
  let used = countUsed();
  used = used.toString().split('.')[1]>2 ? Number(used).toFixed(2): used;
  $('#fmla_used').html(used);
  let a_total = total - countUsed();
  a_total = a_total.toString().split('.')[1]>2 ? Number(a_total).toFixed(2): a_total;
  $('#available').html(a_total);
  if(total - countUsed()<0) $('#available').addClass('text-danger');
  else $('#available').removeClass('text-danger');
}

//Update Chart data in front-end in runtime
function updateChart() {
  calcData[0] = Number(countUsed());
  calcData[1] = Number(total - countUsed());
  drawChart();
}

//Update month array
function updatemonthTotal(month, val) {
  let Total = 0;
  for (let i = 0; i < val; i++) {
    if ($('#' + (month + 1) + ' .input-hours').eq(i).val() != '') {
      Total += Number.parseFloat($('#' + (month + 1) + ' .input-hours').eq(i).val());
    }
  }
  Total = Total.toString().split('.')[1]>2 ? Number(Number(Total).toFixed(2)): Total;
  monthTotal[month] = Total;

  $('#mo' + (month + 1)).html(Total);
}

// Update the post data in run-time
function updatePostData() {
  //for post start and end date
  if ($('#name,#start_date,#end_date').val() != '' && $('#fmla_used').html() != '')
    // $('#submit, #popup').removeAttr('disabled');

  //for used hours post data
  $('#used_hidden').val($('#fmla_used').html());

  //for post table data
  $('#each_month_total').val(JSON.stringify(monthTotal));
  $('#chart').val(JSON.stringify(calcData));
}

//Update all the value in runtime
function updateAll() {
  let m1 = Number.parseInt($('#start_date').val().split('-')[1]) - 1;
  let m2 = Number.parseInt($('#end_date').val().split('-')[1]) - 1;
  monthTotal = [];
  for (let a = m1; a <= m2; a++) {
    updatemonthTotal(a, getDays(a + 1));
  }
  updateTotal();
  updateChart();
  updatePostData();

  if ($('#name').val() == '') {
    errorFlag = true;
    $('#name_error').html('Please enter your name.');
    $('#name').focus();
  }


  if (errorFlag) {
    $('#submit, #popup').attr('disabled', 'disabled');
  }
  else {
    $('#submit, #popup').removeAttr('disabled');
  }

}

//Validate year
function valDate() {

  let y1 = Number.parseInt($('#start_date').val().split('-')[0]);
  let y2 = Number.parseInt($('#end_date').val().split('-')[0]);

  let m1 = Number.parseInt($('#start_date').val().split('-')[1]);
  let m2 = Number.parseInt($('#end_date').val().split('-')[1]);

  let yearsDiff = y2 - y1;
  let monthDiff = m2 - m1;
  if (yearsDiff >= 0 && yearsDiff <= 1 && y1 == new Date().getFullYear() && y2 == new Date().getFullYear() && Math.sign(monthDiff) >= 0) {
    for (let j = 0; j < 12; j++) {
      $('.month').eq(j).fadeOut();
    }
    for (let i = m1 - 1; i <= m2 - 1; i++) {
      $('.month').eq(i).fadeIn();
    }
    return true;
  } else {
    return false;
  }
}

//Name
$('#name').keyup((e) => {
  if (e.target.value == '') errorFlag = true;
});

//Start Date
$('#start_date').change(function () {
  if ($('#end_date').val().length == 0) return;
  mydate = $('#start_date').val();
  year = new Date(mydate).getFullYear();

  if (!valDate()) {
    $('.input-hours').attr('disabled', true);
    $('#start_date_error').html('Please enter valid date. i.e. choose date in range of a year and only current year');
    errorFlag = true;
  } else {
    $('.input-hours').removeAttr('disabled');
    $('#start_date_error').html('');
    $('input[type=radio][name=flexRadioDefault]').prop('checked', false);
    $('.input-hours').val('');
    let m1 = Number.parseInt($('#start_date').val().split('-')[1]);
    let m2 = Number.parseInt($('#end_date').val().split('-')[1]);

//Iterate the for all the month
for (let mont = m1; mont <=m2 ; mont++) {
  generateCalender(mont);
}
    updatePostData();
    errorFlag = false;
  }

  // if (isLeapYear(year)) {
  //   $('#2 td').eq(28).fadeIn();
  // } else {
  //   $('#2 td').eq(28).fadeOut();
  // }
});

//End Date
$('#end_date').change(function () {
  if (!valDate()) {
    $('.input-hours').attr('disabled', true);
    $('#end_date_error').html('Please enter valid date. i.e. choose date in range of a year and only current year');
    errorFlag = true;
  } else {
    $('.input-hours').removeAttr('disabled');
    $('#end_date_error').html('');
    $('input[type=radio][name=flexRadioDefault]').prop('checked', false);
    $('.input-hours').val('');
    let m1 = Number.parseInt($('#start_date').val().split('-')[1]);
    let m2 = Number.parseInt($('#end_date').val().split('-')[1]);

//Iterate the for all the month
for (let mont = 1; mont <=12 ; mont++) {
  generateCalender(mont);
}
    updatePostData();
  }
});


//Avg hours
$('#avg_hours').keyup(function () {
  avg = Number.parseFloat($('#avg_hours').val());
  if (avg < 1 || avg > 168) {
    $('#avg_hours').css('border-color', 'red');
    $('#avg_hour_error').html('Invalid average hour');
    errorFlag = true;
    return false;
  } else {
    $('#avg_hours').css('border-color', '#ced4da');
    $('#avg_hour_error').html('');
    // updateTotal();
    // updateChart();
    updateAll()
  }
});

//on change radio
$('input[type=radio][name=flexRadioDefault]').change(function () {
  if ($('#end_date').val() == '') {
    $('#end_date_error').html('Please enter valid date. i.e. choose date in range of a year and only current year');
    $('#end_date').focus();
    return;
  }

  $('#message').fadeOut(500);

  if ($(this).val() == 'continuous') {
    let d1 = new Date($('#start_date').val());
    let d2 = new Date($('#end_date').val());
    for (let d = 0; d <= $('.input-hours').length; d++) {
      let isWeekend = $('.input-hours').eq(d).attr('isweekend');
      if (isWeekend == "true") {
      } 
      else if(new Date($('.input-hours').eq(d+1).attr('date')) >= d1 && new Date($('.input-hours').eq(d).attr('date')) <= d2) {
        $('.input-hours').eq(d).val(avg/5);
      }      
    }
    errorFlag = false;
    updateAll();
  }
  else if ($(this).val() == 'intermittent') {
    $('.input-hours').val('');
    errorFlag = false;
    updateAll();
  }
});

//on hours change
const fmlaHours = ()=> {$('.input-hours').keyup((e)=>{  
if (Number.parseInt($(e.target).val()) > Number.parseInt($(e.target).attr('max'))) {
  $(e.target).css('background-color', '#f7b7bb');
  $('p#message').fadeIn('slow').html('Hours should not be more than 12');

} else {
  $(e.target).css('background-color', '#fff');
  $('p#message').fadeOut('slow');
  errorFlag = false;
  updateAll();
}
});
};


/**
 * charCode [48,57]     Numbers 0 to 9
 * keyCode 46           "delete"
 * keyCode 9            "tab"
 * keyCode 13           "enter"
 * keyCode 116          "F5"
 * keyCode 8            "backscape"
 * keyCode 37,38,39,40  Arrows
 * keyCode 10           (LF)
 */
 function validate_int(myEvento) {
  if ((myEvento.charCode >= 48 && myEvento.charCode <= 57) || myEvento.keyCode == 9 || myEvento.keyCode == 10 || myEvento.keyCode == 13 || myEvento.keyCode == 8 || myEvento.keyCode == 116 || myEvento.keyCode == 46 || (myEvento.keyCode <= 40 && myEvento.keyCode >= 37)) {
    dato = true;
  } else {
    dato = false;
  }
  return dato;
}

function phone_number_mask() {
  var myMask = "___-___-____";
  var myCaja = document.getElementById("phone");
  var myText = "";
  var myNumbers = [];
  var myOutPut = ""
  var theLastPos = 1;
  myText = myCaja.value;
  //get numbers
  for (var i = 0; i < myText.length; i++) {
    if (!isNaN(myText.charAt(i)) && myText.charAt(i) != " ") {
      myNumbers.push(myText.charAt(i));
    }
  }
  //write over mask
  for (var j = 0; j < myMask.length; j++) {
    if (myMask.charAt(j) == "_") { //replace "_" by a number 
      if (myNumbers.length == 0)
        myOutPut = myOutPut + myMask.charAt(j);
      else {
        myOutPut = myOutPut + myNumbers.shift();
        theLastPos = j + 1; //set caret position
      }
    } else {
      myOutPut = myOutPut + myMask.charAt(j);
    }
  }
  document.getElementById("phone").value = myOutPut;
  document.getElementById("phone").setSelectionRange(theLastPos, theLastPos);
}

document.getElementById("phone").onkeypress = validate_int;
document.getElementById("phone").onkeyup = phone_number_mask;
	document.getElementById("phone").setAttribute('title','Phone format: ###-###-####');

$('#popup').click((e)=>{
$(e.target).css('opacity','0.5');
});

$('.btn-close').click(()=>{
  $('#popup').css('opacity','1');
});

$('#email').change((e)=>{
if(new RegExp(/(gmail|yahoo|wordpress|aol|outlook)/i).test($('#email').val())){
  $('#email_error').html('Please enter a valid company email address.');
} else $('#email_error').html('');
}); 

$('form#calculator').submit((e)=>{
  if($('#email,#name,#phone,#companyname').val()!==''){
    $('#exampleModal').modal('toggle');
  }
  setTimeout(()=>{
$('submit').html('GET A REPORT');
  },500);
});
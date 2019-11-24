const PAYMENT_SUCCESS =
  "<h2>Booking Success!</h2>" +
  "<p>Thank you for booking! Please continue to payment.</p>" +
  '<button onclick="window.location.href=\'/transactions\'" class="button">Go to transaction history</button>';
const PAYMENT_FAILED =
  '<h2 class="failed">Payment Failed!</h2>' +
  "<p>Someone has just taken your seat! Please choose another seat.</p>";

const url = `/api/booking.php`;
const urlParams = new URLSearchParams(window.location.search);
let data;
scheduleRefresher();

function scheduleRefresher() {
  const request = new XMLHttpRequest();
  const getUrl = `${url}?id=${urlParams.get("id")}`;

  const activeSeatElement = document.querySelector(".seat-row .active");
  const seatNumber = activeSeatElement && parseInt(activeSeatElement.innerHTML);

  request.open("GET", getUrl);
  request.send();

  request.onload = () => {
    console.log(request.responseText);
    data = JSON.parse(request.responseText);
    loadScheduleDetail();
    if (seatNumber && !data.takenSeats.includes(seatNumber))
      selectSeat(seatNumber);
  };

  setTimeout(scheduleRefresher, 5000);
}

function loadScheduleDetail() {
  const seats = Array.from({ length: data.maxSeats }, (_, k) => k + 1);
  const chunkSeats = chunk(seats, 10);

  const seatContainer = document.getElementById("seat-container");
  seatContainer.innerHTML = "";
  chunkSeats.forEach(chk => {
    const seatRow = document.createElement("div");
    seatRow.setAttribute("class", "seat-row");

    chk.forEach(seat => {
      const seatElement = document.createElement("a");
      if (data.takenSeats.includes(seat))
        seatElement.setAttribute("class", "disabled");
      else seatElement.onclick = () => selectSeat(seat);
      seatElement.innerHTML = seat;
      seatRow.appendChild(seatElement);
    });

    seatContainer.appendChild(seatRow);
  });

  const screenElement = document.createElement("div");
  screenElement.setAttribute("class", "screen-position");
  screenElement.innerHTML = "Screen";
  seatContainer.appendChild(screenElement);

  const bookingSummaryElement = document.querySelector(".booking-summary");
  bookingSummaryElement.innerHTML = "<h3>Booking Summary</h3>";

  const defaultBookingTextElement = document.createElement("p");
  defaultBookingTextElement.innerHTML =
    "You haven't selected any seat yet. Please click on one of the seat provided.";
  bookingSummaryElement.appendChild(defaultBookingTextElement);

  document.querySelector(".booking-movie h3").innerHTML = data.title;
  document.querySelector(".booking-movie h4").innerHTML = data.dateTime;
}

function selectSeat(number) {
  const bookingSummaryElement = document.querySelector(".booking-summary");
  bookingSummaryElement.innerHTML = "<h3>Booking Summary</h3>";
  const childNodes = Array.from(bookingSummaryElement.childNodes);
  childNodes
    .slice(2, childNodes.length)
    .forEach(child => bookingSummaryElement.removeChild(child));

  bookingSummaryElement.innerHTML += `<h4>${data.title}</h4>`;
  bookingSummaryElement.innerHTML += `<h5>${data.dateTime}</h5>`;

  const formattedPrice = data.price
    .toString()
    .replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.");

  bookingSummaryElement.innerHTML += `<h4>Seat #${number}<span class="price">Rp ${formattedPrice}</span></h4>`;
  bookingSummaryElement.innerHTML += `<button class="button" onclick="buyTicket(${number})">Buy Ticket</button>`;

  const seatElements = Array.from(document.querySelectorAll(".seat-row a"));
  seatElements.forEach(seatElement => {
    if (parseInt(seatElement.textContent) === number)
      seatElement.setAttribute("class", "active");
    else if (seatElement.getAttribute("class") === "active")
      seatElement.removeAttribute("class");
  });
}

function buyTicket(number) {
  const modalElement = document.getElementById("modal");
  const modalContentElement = document.querySelector(".modal-content");

  const postRequest = new XMLHttpRequest();
  const postData = {
    id: urlParams.get("id"),
    seat: number
  };

  postRequest.open("POST", url);
  postRequest.send(JSON.stringify(postData));

  postRequest.onload = () => {
    const response = JSON.parse(postRequest.responseText);
    data = response.data;

    if (response.status === "success") {
      console.log(response)
      modalContentElement.innerHTML = PAYMENT_SUCCESS + "<p>transfer to : "+ response.va +"</p>"+ "<p>id transaksi : "+ response.idTransaksi +"</p>";
    } else {
      modalContentElement.innerHTML = PAYMENT_FAILED;
    }

    modalElement.classList.add("shown");
    // loadScheduleDetail();
  };
}

window.onclick = function(event) {
  const modalElement = document.getElementById("modal");
  if (event.target === modalElement) {
    modalElement.classList.remove("shown");
  }
};

const request = new XMLHttpRequest();
const urlParams = new URLSearchParams(window.location.search);
const url = `/api/detail.php?id=${urlParams.get("id")}`;

request.open("GET", url);
request.send();

let data;
request.onload = () => {
    data = JSON.parse(request.responseText);
    loadInitialData();
};

function loadInitialData()
{
  // Movie Detail
    document.getElementById("movie-poster").src = data.posterUrl;
    document.getElementById("movie-name").innerHTML = data.title;
    document.getElementById("movie-category").innerHTML = data.genres.join(", ");
    document.getElementById(
        "movie-duration"
    ).innerHTML = `${data.durationMinutes} mins`;
    document.getElementById(
        "movie-release"
    ).innerHTML = `Release date: ${data.releaseDate}`;
    document.getElementById("movie-rating").innerHTML = data.rating;
    document.querySelector(".synopsis p").innerHTML = data.synopsis;

  // Schedules
    const schedulesElement = document.getElementById("schedules");
    data.schedules.forEach(schedule => {
        const trElement = document.createElement("tr");
        trElement.innerHTML = `<td>${schedule.date}</td>`;
        trElement.innerHTML += `<td>${schedule.time}</td>`;

        const tdElement = document.createElement("td");
        tdElement.setAttribute("class", "black");
        tdElement.innerHTML = `${schedule.availableSeats} seats`;

        const buttonElement = document.createElement("button");

        const scheduleDate = new Date(
            `${schedule.date} ${schedule.time.replace(".", ":")}`
        );
    const currentDate = new Date();
    const isBookingAvailable =
      scheduleDate > currentDate && schedule.availableSeats > 0;

    if (isBookingAvailable) {
        buttonElement.onclick = () => {
            window.location.href = `/booking?id=${schedule.idSchedule}`;
        };
        buttonElement.innerHTML =
        'Book Now <i class="fa fa-chevron-circle-right"></i>';
    } else {
        buttonElement.setAttribute("class", "unavailable");
        buttonElement.innerHTML =
        'Not Available <i class="fa fa-times-circle"></i>';
    }
      tdElement.appendChild(buttonElement);
      trElement.appendChild(tdElement);
      schedulesElement.appendChild(trElement);
    });

  // Reviews
    const reviewsElement = document.getElementById("reviews");
    data.reviews.forEach((review, i) => {
        const rowElement = document.createElement("div");
        rowElement.setAttribute('class', 'row');

        const imgElement = document.createElement("img");
        imgElement.setAttribute("class", "profile-picture");
        imgElement.src = review.profilePicture;
        rowElement.appendChild(imgElement);

        const reviewContainerElement = document.createElement("div");
        reviewContainerElement.setAttribute('class', 'review-container');
        reviewContainerElement.innerHTML = `<p id="username">${review.username}</p>`;
        reviewContainerElement.innerHTML += `<div class="movie-rating small"><span class="fa fa-star checked"></span><span id="movie-rating">${review.rating}</span><span class="movie-rating-out-of">/10</span></div>`;
        reviewContainerElement.innerHTML += `<p id="comment">${review.comment}</p>`;
        rowElement.appendChild(reviewContainerElement);

        reviewsElement.appendChild(rowElement);
        if (i !== data.reviews.length - 1) {
            reviewsElement.appendChild(document.createElement("hr"));
        }
    });
}

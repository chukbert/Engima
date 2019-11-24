// const authRequest = new XMLHttpRequest();
// const authUrl = "/api/auth.php";

// authRequest.open("GET", authUrl);
// authRequest.send();
// authRequest.onload = () => {
//   const auth = JSON.parse(authRequest.responseText);
//   if (auth.status === "logout") window.location = "/login";
//   else {
//     const userElement = document.querySelector(".greetings span");
//     userElement.innerHTML = auth.user;
//   }
// };

// const request = new XMLHttpRequest();
// const url = '/api/home.php';

// request.open("GET", url);
// request.send();

// let data;
// request.onload = () => {
//   data = JSON.parse(request.responseText);
//   loadInitialData();
// };

// loadInitialData();
// function loadInitialData() {
//   const chunkFilms = chunk(data, 5);

//   const contentContainer = document.querySelector(".content-container");
//   chunkFilms.forEach(chk => {
//     const rowElement = document.createElement("div");
//     rowElement.setAttribute("class", "row");

//     chk.forEach(film => {
//       const colElement = document.createElement("a");
//       colElement.setAttribute("href", `/detail?id=${film.idFilm}`);
//       colElement.setAttribute("class", "column");

//       const imgElement = document.createElement("img");
//       imgElement.setAttribute("src", film.posterUrl);

//       colElement.appendChild(imgElement);
//       colElement.innerHTML += `<div class="movie-name">${film.title}</div>`;
//       colElement.innerHTML += `<div class="movie-rating"><span class="fa fa-star checked"></span>${film.rating}</div>`;

//       rowElement.appendChild(colElement);
//     });

//     contentContainer.appendChild(rowElement);
//   });
// }


const authRequest = new XMLHttpRequest();
const authUrl = "/engima/api/auth.php";

authRequest.open("GET", authUrl);
authRequest.send();
authRequest.onload = () => {
<<<<<<< HEAD
  const auth = JSON.parse(authRequest.responseText);
  if (auth.status === "logout") window.location = "/engima/login";
  else {
    const userElement = document.querySelector(".greetings span");
    userElement.innerHTML = auth.user;
  }
=======
    const auth = JSON.parse(authRequest.responseText);
    if (auth.status === "logout") {
        window.location = "/login";
    } else {
        const userElement = document.querySelector(".greetings span");
        userElement.innerHTML = auth.user;
    }
>>>>>>> 15c49ed4358dbf9c5c3bd1244411ae5b2a762403
};

const request = new XMLHttpRequest();
const url = '/engima/api/moviedb.php';

request.open("GET", url);
request.send();

let data;
request.onload = () => {
  data = JSON.parse(request.responseText);
  console.log(data);
  loadInitialData();
};

loadInitialData();
function loadInitialData()
{
    const chunkFilms = chunk(data, 5);

    const contentContainer = document.querySelector(".content-container");
    chunkFilms.forEach(chk => {
        const rowElement = document.createElement("div");
        rowElement.setAttribute("class", "row");

    chk.forEach(film => {
      const colElement = document.createElement("a");
      colElement.setAttribute("href", `/engima/detail?id=${film.id}`);
      colElement.setAttribute("class", "column");

      const imgElement = document.createElement("img");
      imgElement.setAttribute("src", film.poster);

      colElement.appendChild(imgElement);
      colElement.innerHTML += `<div class="movie-name">${film.title}</div>`;
      colElement.innerHTML += `<div class="movie-rating"><span class="fa fa-star checked"></span>${film.score}</div>`;

            rowElement.appendChild(colElement);
        });

    contentContainer.appendChild(rowElement);
    });
}

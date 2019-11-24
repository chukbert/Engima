const request = new XMLHttpRequest();
const url = '/api/moviedb.php';

request.open("GET", url);
request.send();

let data;
request.onload = () => {
  data = JSON.parse(request.responseText);
  console.log(data);
  loadInitialData();
};

loadInitialData();
function loadInitialData() {
  const chunkFilms = chunk(data, 5);

  const contentContainer = document.querySelector(".content-container");
  chunkFilms.forEach(chk => {
    const rowElement = document.createElement("div");
    rowElement.setAttribute("class", "row");

    chk.forEach(film => {
      const colElement = document.createElement("a");
      colElement.setAttribute("href", `/detail?id=${film.id}`);
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

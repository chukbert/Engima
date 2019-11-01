const RESULTS_PER_PAGE = 5;

const request = new XMLHttpRequest();
const urlParams = new URLSearchParams(window.location.search);
const url = `/api/search.php?name=${urlParams.get("name")}`;

request.open("GET", url);
request.send();

let data;
request.onload = () => {
  data = JSON.parse(request.responseText);
  loadInitialData();
};

function loadInitialData() {
  document.querySelector(
    ".content-container h3"
  ).innerHTML = `Showing search result for keyword "${data.query}"`;
  document.querySelector(".content-container h4").innerHTML = `${
    data.results.length
  } result${data.results.length > 1 ? "s" : ""} available`;
  document.querySelector("title").innerHTML += ` &#8211; "${data.query}"`;

  loadPage(1);
}

function loadPage(page) {
  const contentElement = document.querySelector(".content-container");
  const childNodes = Array.from(contentElement.childNodes);
  childNodes
    .slice(4, childNodes.length)
    .forEach(child => contentElement.removeChild(child));

  const films = data.results.slice(
    (page - 1) * RESULTS_PER_PAGE,
    page * RESULTS_PER_PAGE
  );
  films.forEach(film => {
    const rowElement = document.createElement("div");
    rowElement.setAttribute("class", "row");

    const imgElement = document.createElement("img");
    imgElement.src = film.posterUrl;
    imgElement.width = 180;
    imgElement.height = 250;
    rowElement.appendChild(imgElement);

    const movieContainerElement = document.createElement("div");
    movieContainerElement.setAttribute("class", "movie-container");

    movieContainerElement.innerHTML = `<div class="movie-name"><h3>${film.title}</h3></div>`;
    movieContainerElement.innerHTML += `<div class="movie-rating"><span class="fa fa-star checked"></span>${film.rating}</div>`;
    movieContainerElement.innerHTML += `<div class="synopsis"><p>${film.synopsis}</p></div>`;
    rowElement.appendChild(movieContainerElement);

    const detailElement = document.createElement("a");
    detailElement.href = `/detail?id=${film.idFilm}`;
    detailElement.innerHTML =
      'View Details <i class="fa fa-chevron-circle-right"></i>';
    rowElement.appendChild(detailElement);

    contentElement.appendChild(rowElement);
    contentElement.appendChild(document.createElement("hr"));
  });

  const paginationElement = document.createElement("div");
  paginationElement.setAttribute("class", "pagination");
  paginationElement.innerHTML = "";

  const backButton = document.createElement("a");
  backButton.classList.add("adv");
  if (page == 1) backButton.classList.add("disabled");
  else backButton.onclick = () => loadPage(page - 1);
  backButton.innerHTML = "Back";
  paginationElement.appendChild(backButton);

  const totalPages = parseInt(
    ((data.results.length || 1) + RESULTS_PER_PAGE - 1) / RESULTS_PER_PAGE
  );

  for (let i = 1; i <= totalPages; i++) {
    const pageElement = document.createElement("a");
    pageElement.onclick = () => loadPage(i);
    pageElement.innerHTML = i;
    if (page == i) pageElement.setAttribute("class", "active");
    paginationElement.appendChild(pageElement);
  }

  const nextButton = document.createElement("a");
  nextButton.classList.add("adv");
  if (page == totalPages) nextButton.classList.add("disabled");
  else nextButton.onclick = () => loadPage(page + 1);
  nextButton.innerHTML = "Next";
  paginationElement.appendChild(nextButton);

  const paginationContainerElement = document.createElement("div");
  paginationContainerElement.setAttribute("class", "pagination-container");
  paginationContainerElement.appendChild(paginationElement);

  contentElement.appendChild(paginationContainerElement);
}

const request = new XMLHttpRequest();
const url = `/api/transactions.php`;

request.open("GET", url);
request.send();

let data;
request.onload = () => {
  data = JSON.parse(request.responseText);
  loadInitialData();
};

function loadInitialData() {
  const contentElement = document.querySelector(".content-container");
  contentElement.innerHTML = '<h3>Transaction History</h3><h4></h4>';

  data.forEach((film, i) => {
    const rowElement = document.createElement("div");
    rowElement.setAttribute("class", "row");

    const imgElement = document.createElement("img");
    imgElement.src = film.posterUrl;
    imgElement.width = 108;
    imgElement.height = 150;
    rowElement.appendChild(imgElement);

    const movieContainerElement = document.createElement("div");
    movieContainerElement.setAttribute("class", "movie-container");

    movieContainerElement.innerHTML = `<div class="movie-name"><h3>${film.title}</h3></div>`;
    movieContainerElement.innerHTML += `<h4><span class="blue">Schedule: </span>${film.dateTime}</h4>`;

    let deleteElement, addEditElement;
    addEditElement = document.createElement("a");

    if (film.reviewStatus === 'submitted') {

      movieContainerElement.innerHTML += `<h5>Your review has been submitted.</h5>`;

      deleteElement = document.createElement("a");
      deleteElement.setAttribute('class', 'delete-review');
      deleteElement.onclick = () => deleteReview(film.idTransaction);
      deleteElement.innerHTML = 'Delete Review';

      addEditElement.innerHTML = 'Edit Review';
      addEditElement.setAttribute('class', 'edit-review')

    } else if (film.reviewStatus === 'ready') {

      addEditElement.innerHTML = 'Add Review';

    }
    rowElement.appendChild(movieContainerElement);

    addEditElement.onclick = () => { window.location.href = `/review?id=${film.idTransaction}`; };
    if (film.reviewStatus != 'disabled') rowElement.appendChild(addEditElement);
    if (deleteElement) rowElement.appendChild(deleteElement);

    contentElement.appendChild(rowElement);
    if (i < data.length - 1)
      contentElement.appendChild(document.createElement("hr"));
  });
}

function deleteReview(idTransaction) {
  const delRequest = new XMLHttpRequest();
  const postData = {
    id: idTransaction,
  };

  const reviewUrl = `/api/review.php`
  delRequest.open("DELETE", reviewUrl);
  delRequest.send(JSON.stringify(postData));

  delRequest.onload = () => {
    window.location.href = '/transactions';
  };
}
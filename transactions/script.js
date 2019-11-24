// const request = new XMLHttpRequest();
// const url = `/api/transactions.php`;

// request.open("GET", url, true);

// const request = new XMLHttpRequest();
// const url = '/api/moviedb.php';

// request.open("GET", url);
// request.send();

// let data;
// request.onload = () => {
//   data = JSON.parse(request.responseText);
//   console.log(data);
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
//       colElement.setAttribute("href", `/detail?id=${film.id}`);
//       colElement.setAttribute("class", "column");

//       const imgElement = document.createElement("img");
//       imgElement.setAttribute("src", film.poster);

//       colElement.appendChild(imgElement);
//       colElement.innerHTML += `<div class="movie-name">${film.title}</div>`;
//       colElement.innerHTML += `<div class="movie-rating"><span class="fa fa-star checked"></span>${film.score}</div>`;

//       rowElement.appendChild(colElement);
//     });

//     contentContainer.appendChild(rowElement);
//   });
// }


// // //   };

// //   const reviewUrl = `/api/review.php`
// //   delRequest.open("DELETE", reviewUrl);
// //   delRequest.send(JSON.stringify(postData));

// //   delRequest.onload = () => {
// //     window.location.href = '/transactions';
// //   };
// // }



const request = new XMLHttpRequest();
const url = `/api/transactions.php`;

request.open("GET", url);
request.send();

let data;
request.onload = () => {
  data = JSON.parse(request.responseText);
  console.log(data);
  loadInitialData();
};

function loadInitialData() {
  const contentElement = document.querySelector(".content-container");
  contentElement.innerHTML = '<h3>Transaction History</h3><h4></h4>';

  data.forEach((film, i) => {
    const rowElement = document.createElement("div");
    rowElement.setAttribute("class", "row");

    const imgElement = document.createElement("img");
    imgElement.src = film.poster; // ganti poster film
    imgElement.width = 108;
    imgElement.height = 150;
    rowElement.appendChild(imgElement);

    const movieContainerElement = document.createElement("div");
    movieContainerElement.setAttribute("class", "movie-container");

    movieContainerElement.innerHTML = `<div class="movie-name"><h3>${film.title}</h3></div>`;
    movieContainerElement.innerHTML += `<h4><span class="blue">Schedule: </span>${film.datetime}</h4>`;
    movieContainerElement.innerHTML += `<h4><span class="blue">Id Transaksi: </span>${film.idTransaksi}</h4>`;
    movieContainerElement.innerHTML += `<h4><span class="blue">Status: </span>${film.status}</h4>`;

    let deleteElement, addEditElement;
      addEditElement = document.createElement("a");
     if (film.status == 'success') {
      // addEditElement = document.createElement("a"); 
      if (film.reviewStatus === 'submitted') {

        movieContainerElement.innerHTML += `<h5>Your review has been submitted.</h5>`;

        deleteElement = document.createElement("a");
        deleteElement.setAttribute('class', 'delete-review');
        deleteElement.onclick = () => deleteReview(film.idTransaksi);
        deleteElement.innerHTML = 'Delete Review';

        addEditElement.innerHTML = 'Edit Review';
        addEditElement.setAttribute('class', 'edit-review')

      } else if (film.reviewStatus === 'ready') {

        addEditElement.innerHTML = 'Add Review';

      }
    }
      rowElement.appendChild(movieContainerElement);

      addEditElement.onclick = () => { window.location.href = `/review?id=${film.idTransaksi}`; };
      if (film.reviewStatus != 'disabled' && film.status == 'success') rowElement.appendChild(addEditElement);
      if (deleteElement) rowElement.appendChild(deleteElement);
  
    contentElement.appendChild(rowElement);
    if (i < data.length - 1)
      contentElement.appendChild(document.createElement("hr"));
  });
  
}

function deleteReview(idTransaksi) {
  const delRequest = new XMLHttpRequest();
  const postData = {
    id: idTransaksi,
  };

  const reviewUrl = `/api/review.php`
  delRequest.open("DELETE", reviewUrl);
  delRequest.send(JSON.stringify(postData));

  delRequest.onload = () => {
    window.location.href = '/transactions';
  };
}

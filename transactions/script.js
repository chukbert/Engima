const request = new XMLHttpRequest();
const url = `/api/transactions.php`;

request.open("GET", url, true);


let data;
request.onload = () => {
  data = JSON.parse(request.responseText);
  console.log(data);
  loadInitialData(data);
};

request.send();

function loadInitialData(data) {
  const contentElement = document.querySelector(".content-container");
  contentElement.innerHTML = '<h3>Transaction History</h3><h4></h4>';
  
  data.forEach((transaction, i) => {
    const rowElement = document.createElement("div");
    rowElement.setAttribute("class", "row");

    // const imgElement = document.createElement("img");
    // imgElement.src = transaction.posterUrl;
    // imgElement.width = 108;
    // imgElement.height = 150;
    // rowElement.appendChild(imgElement);

    const movieContainerElement = document.createElement("div");
    movieContainerElement.setAttribute("class", "movie-container");

    movieContainerElement.innerHTML = `<div class="movie-name"><h3>${transaction.idTransaksi}</h3></div>`;
    movieContainerElement.innerHTML += `<h4><span class="blue">Schedule: </span>${transaction.status}</h4>`;

    // let deleteElement, addEditElement;
    // addEditElement = document.createElement("a");

    // if (transaction.reviewStatus === 'submitted') {

    //   movieContainerElement.innerHTML += `<h5>Your review has been submitted.</h5>`;

    //   deleteElement = document.createElement("a");
    //   deleteElement.setAttribute('class', 'delete-review');
    //   deleteElement.onclick = () => deleteReview(transaction.idTransaction);
    //   deleteElement.innerHTML = 'Delete Review';

    //   addEditElement.innerHTML = 'Edit Review';
    //   addEditElement.setAttribute('class', 'edit-review')

    // } else if (transaction.reviewStatus === 'ready') {

    //   addEditElement.innerHTML = 'Add Review';

    // }
  //   rowElement.appendChild(movieContainerElement);

  //   addEditElement.onclick = () => { window.location.href = `/review?id=${transaction.idTransaction}`; };
  //   if (transaction.reviewStatus != 'disabled') rowElement.appendChild(addEditElement);
  //   if (deleteElement) rowElement.appendChild(deleteElement);

  //   contentElement.appendChild(rowElement);
  //   if (i < data.length - 1)
  //     contentElement.appendChild(document.createElement("hr"));
  // });
  });
}

// function deleteReview(idTransaction) {
//   const delRequest = new XMLHttpRequest();
//   const postData = {
//     id: idTransaction,
//   };

//   const reviewUrl = `/api/review.php`
//   delRequest.open("DELETE", reviewUrl);
//   delRequest.send(JSON.stringify(postData));

//   delRequest.onload = () => {
//     window.location.href = '/transactions';
//   };
// }
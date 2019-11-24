const request = new XMLHttpRequest();
const urlParams = new URLSearchParams(window.location.search);
const url = `/api/review.php?id=${urlParams.get("id")}`;

request.open("GET", url);
request.send();

let data;
request.onload = () => {
    data = JSON.parse(request.responseText);
    loadInitialData();
};

function loadInitialData()
{
    loadMovie();
    loadStar();
    loadReview();
    submitButton();
}

function loadMovie()
{
    const contentElement = document.querySelector(".reviewed-movie-name h3");
    var movie = data.title;
    contentElement.innerHTML = movie;
}

function loadStar()
{
    const contentElement = document.querySelector(".star-rating");
    contentElement.innerHTML = '';
    for (i = 1; i <= 10; i++) {
        contentElement.innerHTML += `<span class="fa fa-star" id="star" onclick="clickStar(${i})"></span>`;
    }
    var starNum = data.rating;
    const stars = document.querySelectorAll(".fa-star");
    stars.forEach((star, i) => {
        if (i < starNum) {
            star.classList.add("checked");
        } else {
            star.classList.remove("checked");
        }
    })
}

function clickStar(num)
{
    data.rating = num;
    loadStar();
}

function loadReview()
{
    const contentElement = document.getElementById("content-review");
    var content = data.comment;
    contentElement.value = content;
}

function submitButton()
{
    const countElement = document.querySelector(".submit");
    if (data.submitted) {
        countElement.innerHTML = `Edit`;
    } else {
        countElement.innerHTML = `Submit`;
    }
}

function submit()
{
    let currentRating = data.rating;
    let idTransaction = data.idTransaction;
    let currentComment = document.getElementById("content-review").value;

    const postRequest = new XMLHttpRequest();
    const postData = {
        idTransaction: idTransaction,
        rating: currentRating,
        comment: currentComment,
    };

    postRequest.open("POST", url);
    postRequest.send(JSON.stringify(postData));

    postRequest.onload = () => {
        window.location.href = '/transactions';
    };
}

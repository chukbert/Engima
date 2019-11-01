const request = new XMLHttpRequest();
const url = "/api/login.php";
const form = document.querySelector("form");

form.addEventListener("submit", e => {
  e.preventDefault();
  const formData = new FormData(form);

  request.open("POST", url);
  request.send(formData);

  request.onload = () => {
    if (request.status === 200) {
      window.location = "/";
    }
  };
});

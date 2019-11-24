const authRequest = new XMLHttpRequest();
const authUrl = "/api/logout.php";

authRequest.open("GET", authUrl);
authRequest.send();
authRequest.onload = () => {
    if (authRequest.status === 200) {
        window.location = "/login";
    }
};

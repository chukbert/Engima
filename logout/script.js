const authRequest = new XMLHttpRequest();
const authUrl = "/engima/api/logout.php";

authRequest.open("GET", authUrl);
authRequest.send();
authRequest.onload = () => {
    if (authRequest.status === 200) {
        window.location = "/engima/login";
    }
};

const authRequest = new XMLHttpRequest();
const authUrl = "/engima/api/auth.php";

authRequest.open("GET", authUrl);
authRequest.send();
authRequest.onload = () => {
    const auth = JSON.parse(authRequest.responseText);
    if (auth.status === "login") {
        window.location = "/engima";
    }
};

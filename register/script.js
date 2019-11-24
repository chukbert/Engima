const FIELD_COUNT = 6;
const VALIDATORS = {
    username: {
        regex: /^[a-zA-Z0-9_]*$/,
        message: "Username must contain only alphabets, numbers, and _!"
    },
    email: {
        regex: /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/,
        message: "Email format is invalid! Example: asif@std.stei.itb.ac.id"
    },
    phoneNumber: {
        regex: /\d{9,12}/,
        message: "Phone number must contain numbers in between 9 - 12 length!"
    }
};

const uploader = document.querySelector(".inputfile");
uploader.addEventListener("change", e => {
    const fileName = e.target.value.split("\\").pop();
    const element = document.querySelector(".filepath");

    element.innerHTML = fileName;
    _validateFile();
});

const form = document.querySelector("form");
form.addEventListener("submit", e => {
  e.preventDefault();
  const request = new XMLHttpRequest();
  const url = "/engima/api/register.php";
  const form = document.querySelector("form");

    const fieldElements = document.querySelectorAll("form input");
    let isAllFieldsValid = true;

    fieldElements.forEach(element => {
        _validate(element);
        isAllFieldsValid &= element.classList.contains("valid");
    });

if (isAllFieldsValid) {
    const formData = new FormData(form);

    request.open("POST", url);
    request.send(formData);

    request.onload = () => {
      if (request.status === 201) {
        window.location = "/engima";
      }
    };
}
});

function _validate(element) {
  const { name, value } = element;

  if (name === "password") return _validatePassword(element);
  if (name === "confirmPassword") return _validateConfirmPassword(element);
  if (name === "file") return _validateFile();

  const errorElement = document.getElementById(`error-${name}`);
  const validator = VALIDATORS[name];

  if (value.match(validator.regex)) {
    const request = new XMLHttpRequest();
    const apiUrl = "/engima/api/userbase.php";
    const url = `${apiUrl}?${name}=${value}`;
  }
}
function _validatePassword(element)
{
    const { value } = element;
    const confirmPasswordElement = document.getElementById("confirmPassword");
    const errorElement = document.getElementById("error-password");

    if (value.length > 0) {
        errorElement.innerHTML = "";
        element.classList.add("valid");
        _validateConfirmPassword(confirmPasswordElement);
    } else {
        errorElement.innerHTML = "Please enter your password!";
        element.classList.remove("valid");
        confirmPasswordElement.classList.remove("valid");
    }
}

function _validateConfirmPassword(element)
{
    const { value } = element;
    const passwordElement = document.getElementById("password");
    const errorElement = document.getElementById("error-confirmPassword");

    if (passwordElement.value === value) {
        errorElement.innerHTML = "";
        element.classList.add("valid");
    } else {
        errorElement.innerHTML = "Password does not match!";
        element.classList.remove("valid");
    }
}

function _validateFile()
{
    const filepathElement = document.querySelector(".filepath");
    const element = document.getElementById("file");
    const errorElement = document.getElementById("error-file");

    if (!!filepathElement.innerHTML) {
        errorElement.innerHTML = "";
        element.classList.add("valid");
        filepathElement.classList.add("valid");
    } else {
        errorElement.innerHTML = "Please provide your profile picture!";
        element.classList.remove("valid");
        filepathElement.classList.remove("valid");
    }
}

const validate = debounce(_validate, 200);

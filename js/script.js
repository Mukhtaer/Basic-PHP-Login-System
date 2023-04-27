
  // Function to send login request
  function login() {
    // Get form data
    var form = document.getElementById("login-form");
    var formData = new FormData(form);

    // Send login request
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        var response = JSON.parse(xhr.responseText);
        if (xhr.status === 200) {
          // Success
          document.getElementById("login-message").innerHTML = "<div class='alert alert-success' role='alert'>" + response.message + "</div>";
        } else {
          // Error
          document.getElementById("login-message").innerHTML = "<div class='alert alert-danger' role='alert'>" + response.message + "</div>";
        }
      }
    };
    xhr.open("POST", "http://localhost/Basic-PHP-Login-System/backend/login.php", true);
    xhr.send(formData);
  }

  // Form validation
  var form = document.getElementById("login-form");
  form.addEventListener("submit", function(event) {
    event.preventDefault(); // prevent default form submission behavior
    if (!form.checkValidity()) {
      event.preventDefault();
      event.stopPropagation();
    }
    form.classList.add("was-validated");
    login();
  });


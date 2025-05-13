function previewImage(event) {
  const reader = new FileReader();

  reader.onload = function () {
    const output = document.getElementById("preview");
    output.src = reader.result;
    output.style.display = "block"; // Show image
  };

  if (event.target.files && event.target.files[0]) {
    reader.readAsDataURL(event.target.files[0]);
  }
}

setTimeout(() => {
  const alert = document.getElementById("custom-alert");
  if (alert) {
    alert.classList.remove("show");
    alert.classList.add("hide");
  }
}, 3000);

document
  .getElementById("add-course-form")
  .addEventListener("submit", function (event) {
    let formIsValid = true;

    // Check if the course name is valid
    const name = document.querySelector('input[name="name"]');
    if (name.value.trim() === "") {
      formIsValid = false;
      name.classList.add("is-invalid");
    } else {
      name.classList.remove("is-invalid");
    }

    // Check if the cost is valid
    const cost = document.querySelector('input[name="cost"]');
    if (cost.value.trim() === "" || isNaN(cost.value)) {
      formIsValid = false;
      cost.classList.add("is-invalid");
    } else {
      cost.classList.remove("is-invalid");
    }

    // Check if the hours is valid
    const hours = document.querySelector('input[name="hours"]');
    if (hours.value.trim() === "" || isNaN(hours.value)) {
      formIsValid = false;
      hours.classList.add("is-invalid");
    } else {
      hours.classList.remove("is-invalid");
    }

    // Check if the category is valid
    const category = document.querySelector('select[name="category"]');
    if (category.value.trim() === "") {
      formIsValid = false;
      category.classList.add("is-invalid");
    } else {
      category.classList.remove("is-invalid");
    }

    // Prevent form submission if validation fails
    if (!formIsValid) {
      event.preventDefault();
    }
  });

document.querySelector("form").addEventListener("submit", function (e) {
  const password = document.querySelector('input[name="password"]').value;
  const confirm = document.querySelector(
    'input[name="password_confirm"]'
  ).value;
  if (password !== confirm) {
    alert("Passwords do not match!");
    e.preventDefault();
  }
});

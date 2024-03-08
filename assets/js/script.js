const allSideMenu = document.querySelectorAll("#sidebar .side-menu.top li a");

allSideMenu.forEach((item) => {
  const li = item.parentElement;

  item.addEventListener("click", function () {
    allSideMenu.forEach((i) => {
      i.parentElement.classList.remove("active");
    });
    li.classList.add("active");
  });
});

// TOGGLE SIDEBAR
const menuBar = document.querySelector("#content nav .bx.bx-menu");
const sidebar = document.getElementById("sidebar");

menuBar.addEventListener("click", function () {
  sidebar.classList.toggle("hide");
});

// Function to toggle inputs visibility
function toggleInputs() {
  var inputs = document.querySelectorAll(".hidden"); // Select all inputs with class 'hidden'
  inputs.forEach(function (input) {
    input.classList.toggle("hidden"); // Toggle the 'hidden' class
  });
}

// Add click event listener to the button
document.getElementById("toggleButton").addEventListener("click", function () {
  toggleInputs(); // Call the toggleInputs function when the button is clicked
});

document
  .getElementById("add-user-form")
  .addEventListener("submit", function (event) {
    // Prevent the default form submission behavior
    event.preventDefault();

    // Additional custom behavior or validation can be added here
  });

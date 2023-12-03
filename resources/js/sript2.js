const sideMenu = document.querySelector('.side-menu');
const content = document.querySelector('.content');
const toggleButton = document.querySelector('.toggle-btn'); // Add this line

function toggleSideMenu() {
    if (sideMenu.style.left === "-250px") {
        sideMenu.style.left = "0";
        content.style.marginLeft = "250px";
    } else {
        sideMenu.style.left = "-250px";
        content.style.marginLeft = "0";
    }
}

// Add click event listener to toggle button
toggleButton.addEventListener('click', toggleSideMenu); // Use toggleButton here

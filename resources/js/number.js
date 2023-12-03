const selectNumber = document.getElementById("selectContact");
const inputNumber = document.getElementById("phoneNumber");

selectNumber.addEventListener("change", function () {
    let selectedOption = selectNumber.value
    console.log(selectedOption); // Debugging line
    inputNumber.value = selectedOption
});

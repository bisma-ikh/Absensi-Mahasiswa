function updateTotal() {
    // Get all checkboxes with the class 'btn-check'
    var checkboxes = document.querySelectorAll('.btn-check');

    // Filter checked checkboxes
    var checkedCheckboxes = Array.from(checkboxes).filter(checkbox => checkbox.checked);

    // Update the total in the input field
    document.getElementById('inputText').value = checkedCheckboxes.length;

    // Get the hargaInput value (you may need to set the actual value dynamically)
    var hargaInputValue = parseFloat(document.getElementById('hargaInput').value.replace(/\D/g, ''));

    // Calculate the total harga based on the number of selected checkboxes and hargaInput
    var totalHarga = checkedCheckboxes.length * hargaInputValue;

    // Display the total harga
    document.getElementById('total').value = totalHarga.toLocaleString('id-ID');

    // Build and display the table of selected checkboxes
    buildSelectedTimesTable(checkedCheckboxes);
}

function buildSelectedTimesTable(checkedCheckboxes) {
    var selectedTimesInput = document.getElementById('selectedTimesInput');
    selectedTimesInput.value = '';

    // Iterate through checked checkboxes and add values to the input
    checkedCheckboxes.forEach(function (checkbox, index) {
        // Append selected time to the input value
        selectedTimesInput.value += checkbox.labels[0].textContent;

        // If it's not the last checkbox, add a minus sign
        if (index < checkedCheckboxes.length - 1) {
            selectedTimesInput.value += ' - ';
        }
    });
}
function updateFields() {
    let selectedValue = document.querySelector('select[name="type_val"]').value;

    // Hide all fields that have the name attribute
    let allFields = document.querySelectorAll('input');
    allFields.forEach(function(input) {
        input.parentElement.style.display = 'none';
    });

    // Show only those fields whose name attribute contains the selected value
    let matchingFields = document.querySelectorAll('input[name*="_' + selectedValue + '"]');
    matchingFields.forEach(function(input) {
        input.parentElement.style.display = 'block';
    });
}

document.addEventListener('DOMContentLoaded', function() {
    // Attach the updateFields function to the change event of the select
    document.querySelector('select[name="type_val"]').addEventListener('change', updateFields);

    updateFields();
});

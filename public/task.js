$(document).ready(function () {
    // Form validation
    $('#create-form').validate({
        rules: {
            title: "required",
            description: "required",
            due_date: "required"
        },
        messages: {
            title: "Please enter a title.",
            description: "Please enter a description",
            due_date: "Please enter due_date"
        },
        submitHandler: function (form) {
            submitForm(form);
        }
    });

});
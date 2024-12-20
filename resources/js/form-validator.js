// resources/js/formValidator.js
import * as Yup from 'yup';

export function validateForm(formSelector, validationRules) {
    const form = $(formSelector);

    // Create a Yup schema based on the provided validation rules
    const schema = Yup.object().shape(validationRules);

    form.validate({
        submitHandler: async function (formElement) {
            const formData = $(formElement).serializeArray().reduce((acc, { name, value }) => {
                acc[name] = value;
                return acc;
            }, {});

            try {
                // Validate the form data against the schema
                await schema.validate(formData, { abortEarly: false });
                // If validation passes, handle form submission
                console.log('Form submitted:', formData);
                // You can perform your form submission logic here
                formElement.submit(); // Submit the form
            } catch (err) {
                // Handle validation errors
                const errors = {};
                err.inner.forEach(error => {
                    errors[error.path] = error.message;
                });
                // Display errors in the form
                for (const [field, message] of Object.entries(errors)) {
                    const input = form.find(`[name="${field}"]`);
                    input.addClass('is-invalid'); // Add a class to indicate error
                    input.next('.error-message').text(message); // Display error message
                }
            }
        },
        errorPlacement: function (error, element) {
            error.addClass('error-message text-red-500');
            error.insertAfter(element); // Place error message after the input
        },
    });
}

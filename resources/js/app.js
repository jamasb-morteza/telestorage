import './bootstrap';
import './form-validator';
import Alpine from 'alpinejs';
import Inputmask from 'inputmask';
import * as Yup from 'yup';

window.Alpine = Alpine;
window.Inputmask = Inputmask;
window.Yup = Yup;
Alpine.start();

document.addEventListener('DOMContentLoaded', function () {
    const inputs = document.querySelectorAll('input[data-mask]'); // Select all inputs with data-mask

    inputs.forEach(input => {
        const mask = input.getAttribute('data-mask'); // Get the mask from the data attribute
        const im = new Inputmask(mask); // Create a new Inputmask instance with the mask
        im.mask(input); // Apply the mask to the input
    });
});

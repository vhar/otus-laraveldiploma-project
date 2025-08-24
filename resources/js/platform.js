
import '@fancyapps/ui/dist/fancybox/fancybox.css';
import { Fancybox } from '@fancyapps/ui/dist/fancybox/';

Fancybox.bind("[data-fancybox]", {});
document.addEventListener("turbo:load", () => {
    mapSelectAll();

    Fancybox.bind("[data-fancybox]", {});    
});

document.addEventListener("DOMContentLoaded", () => {
    mapSelectAll();
});

function mapSelectAll() {
    const items = document.querySelectorAll('.form-check-input:not(#select-all-tyres)');
    const selectAll = document.getElementById('select-all-tyres');

    function toggleCheckboxes(isChecked) {
        if (items) {
            items.forEach(checkbox => checkbox.checked = isChecked);
        }
    }

    if (selectAll) {
        selectAll.onclick = function() {
            toggleCheckboxes(this.checked);
        };
    }

    function updateSelectAll() {
        const allChecked = [...items].every(item => item.checked);
        const someChecked = [...items].some(item => !item.checked);
  
        selectAll.checked = allChecked;
        selectAll.indeterminate = someChecked && !allChecked;
    }

    items.forEach(item => {
        item.addEventListener('change', () => {
            updateSelectAll();
        });
    });

}

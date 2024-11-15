
document.addEventListener('DOMContentLoaded', function() {

    window.selectAllFiles = function(checkbox_element) {  
        const table = checkbox_element.closest('table');
        const checkboxes = table.querySelectorAll('input.select-file-checkbox[type="checkbox"]');
        checkboxes.forEach(checkbox => {
            checkbox.checked = checkbox_element.checked;
        });
    };

    

    window.toggleDirectory = function(element) {
        // Get the Alpine.js component instance
        const alpineComponent = Alpine.$data(element);
        
        // Toggle the expanded state
        alpineComponent.expanded = !alpineComponent.expanded;
        
        // Get the next sibling element (the ul containing children)
        const childrenContainer = element.nextElementSibling;
        
        if (childrenContainer) {
            if (!alpineComponent.expanded) {
                // Collapse: set max-height to 0
                childrenContainer.style.maxHeight = '0px';
            } else {
                // Expand: reset max-height to original value
                childrenContainer.style.maxHeight = '1000px';
            }
        }
    }
}); 
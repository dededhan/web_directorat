/* SDG Detail Page - Accordion Behavior */

document.addEventListener('DOMContentLoaded', function() {
    // Year buttons are handled by server-side routing
    
    // Initialize collapsible goal items
    const goalHeaders = document.querySelectorAll('.goal-item-header');
    
    goalHeaders.forEach(header => {
        header.addEventListener('click', function() {
            const goalItem = this.closest('.goal-item');
            const isActive = goalItem.classList.contains('active');
            
            // Close all other goal items
            document.querySelectorAll('.goal-item').forEach(item => {
                item.classList.remove('active');
            });
            
            // Toggle current item
            if (!isActive) {
                goalItem.classList.add('active');
            }
        });
    });
});

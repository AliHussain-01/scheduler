// script.js

document.addEventListener("DOMContentLoaded", function() {

    // 1. Highlight current day in schedule table
    const today = new Date().toLocaleString('en-US', { weekday: 'long' });
    const scheduleRows = document.querySelectorAll('table tr');
    scheduleRows.forEach(row => {
        if (row.firstElementChild && row.firstElementChild.textContent.trim() === today) {
            row.style.backgroundColor = "#fffbcc"; // light yellow
        }
    });

    // 2. Confirmation for delete links
    const deleteLinks = document.querySelectorAll('a[href*="delete"]');
    deleteLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            const confirmed = confirm("Are you sure you want to delete this item?");
            if (!confirmed) e.preventDefault();
        });
    });

    // 3. Optional: Smooth scroll for navigation (if page has sections)
    const navLinks = document.querySelectorAll('nav a[href^="#"]');
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({ behavior: 'smooth' });
            }
        });
    });

    // 4. Optional: Highlight hovered table cells in schedule
    const tableCells = document.querySelectorAll('table td, table th');
    tableCells.forEach(cell => {
        cell.addEventListener('mouseenter', () => cell.style.backgroundColor = '#e0f7fa');
        cell.addEventListener('mouseleave', () => {
            // Reset current day row separately
            if (cell.parentElement.firstElementChild.textContent.trim() === today) {
                cell.style.backgroundColor = '#fffbcc';
            } else {
                cell.style.backgroundColor = '';
            }
        });
    });

    console.log("Dashboard/Schedule interactivity initialized.");
});

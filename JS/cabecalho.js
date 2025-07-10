function toggleDropdown(event, element) {
    event.preventDefault();
    const container = element.closest('.dropdown-container');

    document.querySelectorAll('.dropdown-container').forEach(el => {
        if (el !== container) {
            el.classList.remove('active');
            const label = el.querySelector('.dropdown-label');
            if (label) label.textContent = 'Equipas ▼';
        }
    });

    if (container) {
        const isActive = container.classList.toggle('active');
        const label = container.querySelector('.dropdown-label');
        if (label) {
            label.textContent = isActive ? 'Equipas ▲' : 'Equipas ▼';
        }
    }
}

document.addEventListener('click', function (event) {
    const isDropdown = event.target.closest('.dropdown-container');
    if (!isDropdown) {
        document.querySelectorAll('.dropdown-container').forEach(el => {
            el.classList.remove('active');
            const label = el.querySelector('.dropdown-label');
            if (label) label.textContent = 'Equipas ▼';
        });
    }
});

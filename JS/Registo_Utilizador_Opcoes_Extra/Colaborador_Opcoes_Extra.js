const papel = document.getElementById('papel');
const colaboradorOptions = document.getElementById('colaboradorOptions');

document.addEventListener('DOMContentLoaded', function () {
    papel.addEventListener('change', function () {
        const selectedValue = papel.value;

        if (selectedValue === '1') {
            colaboradorOptions.style.display = 'block';
        } else {
            colaboradorOptions.style.display = 'none';
        }
    });
});

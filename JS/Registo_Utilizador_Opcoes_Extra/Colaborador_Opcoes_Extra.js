
const role = document.getElementById('role');

document.addEventListener('DOMContentLoaded', function () {
    const colaboradorDivs = document.querySelectorAll('.colaboradorOptions');
    colaboradorDivs.forEach(div => div.style.display = 'none');
    role.addEventListener('change', function () {
        const selectedValue = role.value;
        if (selectedValue == 'Colaborador') {
            colaboradorDivs.forEach(div => div.style.display = 'block');
        } else {
            colaboradorDivs.forEach(div => div.style.display = 'none');
        }
    });
});

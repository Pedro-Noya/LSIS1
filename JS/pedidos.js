document.addEventListener('DOMContentLoaded', () => {
    const tipoSelect = document.getElementById('tipo');
    const feriasExtras = document.getElementById('FeriasExtras');
    const equipamentoExtras = document.getElementById('EquipamentoExtras');
    const docextras = document.getElementById('DocExtras');
    const trocaTurnoExtras = document.getElementById('TrocaTurnoExtras');
    const remotoExtras = document.getElementById('RemotoExtras');
    const assistenciaExtras = document.getElementById('AssistenciaExtras');
    

    tipoSelect.addEventListener('change', () => {
        feriasExtras.style.display = tipoSelect.value === 'Férias' ? 'block' : 'none';
        equipamentoExtras.style.display = tipoSelect.value === 'Equipamento' ? 'block' : 'none';
        docextras.style.display = tipoSelect.value === 'Documentação' ? 'block' : 'none';
        trocaTurnoExtras.style.display = tipoSelect.value === 'Troca de turno' ? 'block' : 'none';
        remotoExtras.style.display = tipoSelect.value === 'Período de Trabalho Remoto' ? 'block' : 'none';
        assistenciaExtras.style.display = tipoSelect.value === 'Assistência' ? 'block' : 'none';
    });

});
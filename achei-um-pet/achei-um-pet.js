let inputNumero = document.getElementById('numeroSerie');

inputNumero.addEventListener('input', function() {
    // Remove tudo que não for número e limita a 3 dígitos
    let valor = inputNumero.value.replace(/[^0-9]/g, '').slice(0, 3);
    if (valor.length > 0) {
        inputNumero.value = '#' + valor;
    } else {
        inputNumero.value = '';
    }
});

// Garante que o usuário não possa digitar antes da hashtag ou removê-la se houver número
inputNumero.addEventListener('keydown', function(e) {
    // Se já existe número, impede digitar antes da hashtag
    if (inputNumero.value.startsWith('#') && inputNumero.selectionStart === 0 && e.key.length === 1 && /[0-9]/.test(e.key)) {
        e.preventDefault();
    }
    // Impede remover a hashtag se houver número
    if (inputNumero.value.startsWith('#') && inputNumero.selectionStart === 1 && (e.key === 'Backspace' || e.key === 'Delete') && inputNumero.value.length > 1) {
        e.preventDefault();
    }
});

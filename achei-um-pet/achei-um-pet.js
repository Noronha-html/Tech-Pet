//let inputNumero = document.getElementById('numeroSerie');

/*inputNumero.addEventListener('input', function() {
    // Remove tudo que não for número e limita a 3 dígitos
    let valor = inputNumero.value.replace(/[^0-9]/g, '').slice(0, 3);
    if (valor.length > 0) {
        inputNumero.value = '#' + valor;
    } else {
        inputNumero.value = '';
    }
});
const numeroSerie = document.getElementById("numeroSerie");

function validarnumeroSerie() {
    //numeroSerie.addEventListener('input', function() {
        // Remove tudo que não for número e limita a 3 dígitos
        let valor = numeroSerie.value.replace(/[^0-9]/g, '').slice(0, 3);
        if (valor.length > 0) {
            numeroSerie.value = '#' + valor;
        } else {
            numeroSerie.value = '';
        }
    //});

    if(numeroSerie.value === "") {
        return false;
    }

    return true;
}

// Garante que o usuário não possa digitar antes da hashtag ou removê-la se houver número
inputNumero.addEventListener('keydown', function(e) {
    if(validarnumeroSerie()) {
        // Se já existe número, impede digitar antes da hashtag
        if (inputNumero.value.startsWith('#') && inputNumero.selectionStart === 0 && e.key.length === 1 && /[0-9]/.test(e.key)) {
            e.preventDefault();
        }
        // Impede remover a hashtag se houver número
        if (inputNumero.value.startsWith('#') && inputNumero.selectionStart === 1 && (e.key === 'Backspace' || e.key === 'Delete') && inputNumero.value.length > 1) {
            e.preventDefault();
        }
    }
});*/

window.addEventListener('DOMContentLoaded', () => {
    const numeroSerie = document.getElementById("numeroSerie");
    const preview     = document.getElementById("preview");
    const inputImg    = document.getElementById("inputImagem");
  
    // --- prefixa o '#' automaticamente no blur ---
    numeroSerie.addEventListener('blur', () => {
      let v = numeroSerie.value.replace(/[^0-9]/g, '').slice(0, 3);
      if (v.length > 0) {
        // adiciona '#' na frente se não existir
        if (!numeroSerie.value.startsWith('#')) {
          numeroSerie.value = '#' + v;
        } else {
          numeroSerie.value = '#' + v;
        }
      } else {
        numeroSerie.value = '';
      }
    });
  
    // --- valida e formata enquanto digita ---
    numeroSerie.addEventListener('input', () => {
      let v = numeroSerie.value.replace(/[^0-9]/g, '').slice(0, 3);
      if (v.length > 0) {
        numeroSerie.value = '#' + v;
      } else {
        numeroSerie.value = '';
      }
    });
  
    // --- impede remoção indevida do '#' ---
    numeroSerie.addEventListener('keydown', function(e) {
      if (!numeroSerie.value.startsWith('#')) return;
      // não deixa apagar o '#'
      if ((e.key === 'Backspace' || e.key === 'Delete') && this.selectionStart === 1) {
        e.preventDefault();
      }
    });
  
    // --- preview da imagem (mantém seu código) ---
    inputImg.addEventListener('change', () => {
      const file = inputImg.files[0];
      if (!file) {
        preview.src = '../img/img-exemplo.png';
        return;
      }
      if (file.type.startsWith('image/')) {
        const reader = new FileReader();
        reader.onload = () => {
          preview.src = reader.result;
        };
        reader.onerror = () => {
          alert('Erro ao carregar a imagem. Por favor, tente novamente.');
        };
        reader.readAsDataURL(file);
      } else {
        alert('Selecione um arquivo de imagem válido.');
        inputImg.value = '';
        preview.src    = '../img/img-exemplo.png';
      }
    });
  });
  

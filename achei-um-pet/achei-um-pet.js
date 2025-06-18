window.addEventListener('DOMContentLoaded', () => {
    const numeroSerie = document.getElementById("numeroSerie");
    const preview     = document.getElementById("preview");
    const inputImg    = document.getElementById("inputImagem");
  
    //adiciona a "#" no início do campo de número de série
    numeroSerie.addEventListener('blur', () => {
      let v = numeroSerie.value.replace(/[^0-9]/g, '').slice(0, 3);
      if (v.length > 0) {
        if (!numeroSerie.value.startsWith('#')) {
          numeroSerie.value = '#' + v;
        } else {
          numeroSerie.value = '#' + v;
        }
      } else {
        numeroSerie.value = '';
      }
    });
  
    //valida e formata enquanto digita
    numeroSerie.addEventListener('input', () => {
      let v = numeroSerie.value.replace(/[^0-9]/g, '').slice(0, 3);
      if (v.length > 0) {
        numeroSerie.value = '#' + v;
      } else {
        numeroSerie.value = '';
      }
    });
  
    //impede remoção do "#"
    numeroSerie.addEventListener('keydown', function(e) {
      if (!numeroSerie.value.startsWith('#')) return;

      if ((e.key === 'Backspace' || e.key === 'Delete') && this.selectionStart === 1) {
        e.preventDefault();
      }
    });
  
    //preview da imagem
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
  

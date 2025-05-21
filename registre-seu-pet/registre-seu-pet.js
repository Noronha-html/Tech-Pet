window.addEventListener('DOMContentLoaded', () => {
  const input = document.getElementById('inputImagem');
  const preview = document.getElementById('preview');

  input.addEventListener('change', () => {
    const file = input.files[0];
    if (!file) {
      // Se o usuário cancelar, volta para a imagem placeholder
      preview.src = '../img/img-exemplo.png';
      return;
    }

    if (file.type.startsWith('image/')) {
      const reader = new FileReader();
      reader.onload = () => {
        preview.src = reader.result;
        preview.style.display = 'block'; // Garante visibilidade
      };
      reader.onerror = () => {
        alert('Erro ao carregar a imagem. Por favor, tente novamente.');
      };
      reader.readAsDataURL(file);
    } else {
      alert('Por favor, selecione um arquivo de imagem válido.');
      input.value = ''; // Reseta o campo de input
      preview.src = '../img/img-exemplo.png'; // Reseta para o placeholder
    }
  });
});


/*document.addEventListener('DOMContentLoaded', () => {
    const submitBtn = document.getElementById('submit');

    submitBtn.addEventListener('click', () => {
        window.location.href = "../pet/pet.html";
    });
});*/

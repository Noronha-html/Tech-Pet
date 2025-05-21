window.addEventListener('DOMContentLoaded', () => {
  const input   = document.getElementById('inputImagem');
  const preview = document.getElementById('preview');

  input.addEventListener('change', () => {
    const file = input.files[0];
    if (!file) {
      // se o usuário cancelou, volta pro placeholder
      preview.src = '../img/img-exemplo.png';
      return;
    }
    const reader = new FileReader();
    reader.onload = () => {
      preview.src = reader.result;
      // garante que está visível
      preview.style.display = 'block';
    };
    reader.readAsDataURL(file);
  });
});


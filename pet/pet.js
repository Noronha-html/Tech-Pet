function criarCardPet(usuario, pet) {
  const container = document.querySelector('.col-12.justify-content-start.align-items-start');
  container.innerHTML = ''; // Limpa conteúdo anterior

  //Cria o card
  const card = document.createElement('div');
  card.className = 'card p-3 mb-3';
  card.style.maxWidth = '350px';

  //Usuário
  const nomeUsuario = document.createElement('p');
  nomeUsuario.textContent = `Usuário: ${usuario.nome || ''}`;
  card.appendChild(nomeUsuario);

  const emailUsuario = document.createElement('p');
  emailUsuario.textContent = `Email: ${usuario.email || ''}`;
  card.appendChild(emailUsuario);

  //Pet
  const nomePet = document.createElement('p');
  nomePet.textContent = `Nome do Pet: ${pet.nome || ''}`;
  card.appendChild(nomePet);

  const nascimentoPet = document.createElement('p');
  nascimentoPet.textContent = `Nascimento: ${pet.nascimento || ''}`;
  card.appendChild(nascimentoPet);

  const pesoPet = document.createElement('p');
  pesoPet.textContent = `Peso: ${pet.peso || ''}`;
  card.appendChild(pesoPet);

  const vacinasPet = document.createElement('p');
  vacinasPet.textContent = `Vacinas: ${pet.vacinas || ''}`;
  card.appendChild(vacinasPet);

  const alergiasPet = document.createElement('p');
  alergiasPet.textContent = `Alergias: ${pet.alergias || ''}`;
  card.appendChild(alergiasPet);

  //Imagem do Pet
  const imgPet = document.createElement('img');
  imgPet.src = pet.imagem || '';
  imgPet.alt = 'Imagem do Pet';
  imgPet.style.maxWidth = '200px';
  imgPet.style.maxHeight = '200px';
  imgPet.style.objectFit = 'cover';
  card.appendChild(imgPet);

  container.appendChild(card);
}

//Exemplo de uso após o fetch:
fetch('get_pet.php')
  .then(response => response.json())
  .then(data => {
    if (data.usuario && data.pet) {
      criarCardPet(data.usuario, data.pet);
    }
  })
  .catch(error => {
    console.error('Erro ao buscar dados:', error);
  });
Pessoas
- PessoaID*
- Nome
- Cidade
- Email
- DataNascimento
- Whatszap

PessoaPet
- Pessoa.PessoaID
- Pet.PetID

Pet
- PetID*
- Identificacao 
- Nome
- Peso
- DataNascimento
- Alergias
- Foto
- Vacinas


IDs: chave primaria  - inteiro Not null primary key AI
Nomes, cidade, whatszap e e-mail: texto - varchar 
DataNascimento: data - date
Peso: inteiros int - 3
Alergias e vacinas: texto longo - LONGTEXT
foto - varchar 255
Identificaçâo: VARCHAR 150
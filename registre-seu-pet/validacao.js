//Validações do formulário de registro de pet
function validarNome() {
    const name = document.getElementById("name");

    if(name.value === "") {
        return false;
    }

    return true;
}

function validarDataNascimento() {
    const dtnasc = document.getElementById("dtnasc");

    if(dtnasc.value === "") {
        return false;
    }   

    return true;
}

function validarPeso() {
    const peso = document.getElementById("peso");

    let valor = peso.value.replace(/[^0-9]/g, '').slice(0, 3);
        if (valor.length > 0) {
            peso.value = valor;
        } else {
            peso.value = '';
        }

    if(peso.value === "") {
        return false;
    }

    return true;
}

function validarFoto() {
    const foto = document.getElementById("inputImagem");

    if(foto.value === "") {
        return false;
    }

    return true;
}

function validarnumeroSerie() {
    const numeroSerie = document.getElementById("numeroSerie");
        //Remove tudo que não for número e limita a 3 dígitos
        let valor = numeroSerie.value.replace(/[^0-9]/g, '').slice(0, 3);
        if (valor.length > 0) {
            numeroSerie.value = '#' + valor;
        } else {
            numeroSerie.value = '';
        }

    if(numeroSerie.value === "") {
        return false;
    }

    return true;
}

const submit = document.getElementById("submit");
submit.addEventListener("click", () => {
    //Se algum campo não for preenchido, exibe uma mensagem de erro
    if(!validarNome()) {
        document.getElementById("label-name").innerHTML = "Nome: <span style='color: red;'>*</span>";
    }

    if(validarNome()) {
        document.getElementById("label-name").innerHTML = "Nome:";
    }

    if(!validarDataNascimento()) {
        document.getElementById("label-dtnasc").innerHTML = "Data de nascimento: <span style='color: red;'>*</span>";
    }

    if(validarDataNascimento()) {
        document.getElementById("label-dtnasc").innerHTML = "Data de nascimento:";
    }

    if(!validarPeso()) {
        document.getElementById("label-peso").innerHTML = "Peso: <span style='color: red;'>*</span>";
    }

    if(validarPeso()) {
        document.getElementById("label-peso").innerHTML = "Peso:";
    }

    if(!validarFoto()) {
        document.getElementById("label-foto").innerHTML = "Escolher imagem: <span style='color: red;'>*</span>";
    }

    if(validarFoto()) {
        document.getElementById("label-foto").innerHTML = "Escolher imagem:";
    }

    if(!validarnumeroSerie()) {
        document.getElementById("label-numeroSerie").innerHTML = "número de série: <span style='color: red;'>*</span>";
    }

    if(validarnumeroSerie()) {
        document.getElementById("label-numeroSerie").innerHTML = "número de série:";
    }

    //Se todos os campos forem preenchidos, envia o formulário
    if(validarNome() && validarDataNascimento() && validarPeso() && validarFoto() && validarnumeroSerie()) {
        document.getElementById("formRegistraPet").submit();
    }

    return;
});
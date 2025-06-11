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

/*function validarVacinas() {
    const vacinas = document.getElementById("vacinas");

    if(vacinas.value === "") {
        return false;
    }

    return true;
}

function validarAlergias() {
    const alergias = document.getElementById("alergias");

    if(alergias.value === "") {
        return false;
    }

    return true;
}*/

function validarFoto() {
    const foto = document.getElementById("inputImagem");

    if(foto.value === "") {
        return false;
    }

    return true;
}

function validarnumeroSerie() {
    const numeroSerie = document.getElementById("numeroSerie");

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

const submit = document.getElementById("submit");
submit.addEventListener("click", () => {

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

    /*if(!validarVacinas()) {
        document.getElementById("label-vacinas").innerHTML = "Vacinas: <span style='color: red;'>*</span>";
    }

    if(validarVacinas()) {
        document.getElementById("label-vacinas").innerHTML = "Vacinas:";
    }

    if(!validarAlergias()) {
        document.getElementById("label-alergias").innerHTML = "Alergias: <span style='color: red;'>*</span>";
    }

    if(validarAlergias()) {
        document.getElementById("label-alergias").innerHTML = "Alergias:";
    }

    if(!validarFoto()) {
        document.getElementById("label-foto").innerHTML = "Escolher imagem: <span style='color: red;'>*</span>";
    }

    if(validarFoto()) {
        document.getElementById("label-foto").innerHTML = "Escolher imagem:";
    }*/

    if(!validarnumeroSerie()) {
        document.getElementById("label-numeroSerie").innerHTML = "número de série: <span style='color: red;'>*</span>";
    }

    if(validarnumeroSerie()) {
        document.getElementById("label-numeroSerie").innerHTML = "número de série:";
    }

    if(validarNome() && validarDataNascimento() && validarPeso() /*&& validarVacinas() && validarAlergias() && validarFoto()*/ && validarnumeroSerie()) {
        document.getElementById("formRegistraPet").submit();
    }

    return;
});
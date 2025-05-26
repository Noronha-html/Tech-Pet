function validarNome() {
    const name = document.getElementById("name");
    if (name.value === "") {
        return false;
    }
    return true;
}

function validarSenha() {
    const senha = document.getElementById("senhaRegistro");

    if (senha.value === "") {
        return false;
    }
    else if(!senha.value.match(/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/)) {
        document.getElementById("label-senha").innerHTML = "Senha: <span style='color: red;'>*<span style='font-size: 0.8rem'>(Precisa conter no mínimo 8 caracteres <br> -números e letras-)</span></span>";
        return false;
    }
    return true;
}
 
function confirmarSenha() {
    const senhaConfirmada = document.getElementById("confirmarSenhaRegistro");
    const senha = document.getElementById("senhaRegistro");
 
    if (senhaConfirmada.value === "") {
        return false;
    }
 
    if (senha.value !== senhaConfirmada.value) {
        document.getElementById("label-confirmarSenha").innerHTML = "Confirmar Senha: <span style='color: red;'>*<span style='font-size: 0.8rem'>(As senhas precisam ser iguais)</span></span>";
        return false;
    }
    return true;
}
 
function validarEstadoeCidade() {
    const estado = document.getElementById("estados");
    const cidade = document.getElementById("cidades");
 
    if (estado.value === "") {
        document.getElementById("label-estado").innerHTML = "Estado: <span style='color: red;'>*</span>";
        return false;
    }
    if (cidade.value === "") {
        document.getElementById("label-cidade").innerHTML = "Cidade: <span style='color: red;'>*</span>";
        return false;
    }
    return true;
}

function validarEmail() {
    const email = document.getElementById("email");

    if(email.value === "") {
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

function validarTelefone() {
    const telefone = document.getElementById("wpp");

    if(telefone.value === "") {
        return false;
    }

    return true;
}

const submit = document.getElementById("enviar");
submit.addEventListener("click", () => {
    if(!validarNome()) {
        document.getElementById("label-name").innerHTML = "Nome: <span style='color: red;'>*</span>";
    }
    
    if(validarNome()) {
        document.getElementById("label-name").innerHTML = "Nome:";
    }
   
    if(!validarSenha()) {
        document.getElementById("label-senha").innerHTML = "Senha: <span style='color: red;'>*</span>";
    }
    
    if(validarSenha()) {
        document.getElementById("label-senha").innerHTML = "Senha:";
    }
 
    if(!confirmarSenha()) {
        document.getElementById("label-confirmarSenha").innerHTML = "Confirmar Senha: <span style='color: red;'>*</span>";
    }
    
    if(confirmarSenha()) {
        document.getElementById("label-confirmarSenha").innerHTML = "Confirmar senha:";
    }

    if(!validarEmail()) {
        document.getElementById("label-email").innerHTML = "Email: <span style='color: red;'>*</span>";
    }
    
    if(validarEmail()) {
        document.getElementById("label-email").innerHTML = "Email:";
    }

    if(!validarDataNascimento()) {
        document.getElementById("label-dtnasc").innerHTML = "Data de nascimento: <span style='color: red;'>*</span>";
    }
    
    if(validarDataNascimento()) {
        document.getElementById("label-dtnasc").innerHTML = "Data de nascimento:";
    }

    if(!validarTelefone()) {
        document.getElementById("label-wpp").innerHTML = "Número de celular: <span style='color: red;'>*</span>";
    }
    
    if(validarTelefone()) {
        document.getElementById("label-wpp").innerHTML = "Número de celular:";
    }
   
    if(validarNome() && validarSenha() && confirmarSenha() && validarEstadoeCidade() && validarEmail() && validarDataNascimento() && validarTelefone()) {
        //window.location.href = "../registre-seu-pet/registre-seu-pet.html";
        document.getElementById("formRegistreSe").submit();
    }
 
    return;
});
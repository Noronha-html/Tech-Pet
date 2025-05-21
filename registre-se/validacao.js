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
        document.getElementById("label-senha").innerHTML = "Senha <span style='color: red;'>*<span style='font-size: 0.8rem'>(Precisa conter números e letras)</span></span>";
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
        document.getElementById("label-confirmarSenha").innerHTML = "Confirmar Senha <span style='color: red;'>*<span style='font-size: 0.8rem'>(As senhas precisam ser iguais)</span></span>";
        return false;
    }
    return true;
}
 
function validarEstadoeCidade() {
    const estado = document.getElementById("estados");
    const cidade = document.getElementById("cidades");
 
    if (estado.value === "") {
        document.getElementById("label-estado").innerHTML = "Estado <span style='color: red;'>*<span style='font-size: 0.8rem'>(Obrigatório)</span></span>";
        return false;
    }
    if (cidade.value === "") {
        document.getElementById("label-cidade").innerHTML = "Cidade <span style='color: red;'>*<span style='font-size: 0.8rem'>(Obrigatório)</span></span>";
        return false;
    }
    return true;
}
 
const submit = document.getElementById("enviar");
submit.addEventListener("click", () => {
    if(!validarNome()) {
        document.getElementById("label-name").innerHTML = "Nome <span style='color: red;'>*<span style='font-size: 0.8rem'>(Obrigatório)</span></span>";
    }
   
    if(!validarSenha()) {
        document.getElementById("label-senha").innerHTML = "Senha <span style='color: red;'>*<span style='font-size: 0.8rem'>(Obrigatório)</span></span>";
    }
 
    if(!confirmarSenha()) {
        document.getElementById("label-confirmarSenha").innerHTML = "Confirmar Senha <span style='color: red;'>*<span style='font-size: 0.8rem'>(Obrigatório)</span></span>";
    }
   
    if(validarNome() && validarSenha() && confirmarSenha() && validarEstadoeCidade()) {
        window.location.href = "../registre-seu-pet/registre-seu-pet.html";
    }
 
    return;
});
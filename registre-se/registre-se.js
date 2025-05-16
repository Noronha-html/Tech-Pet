const submit = document.querySelector(".submit");

submit.addEventListener("click", () => {
    window.location.href = "../registre-seu-pet/registre-seu-pet.html";
});

//Pegar id dos estados para usar para as cidades depois
const estados = document.getElementById("estados");
estados.innerHTML = "<option value=''>Selecione o estado</option>";
fetch(`https://servicodados.ibge.gov.br/api/v1/localidades/estados`)
.then(res => res.json())
.then(data => {
    data.forEach(estado => {
        const option = document.createElement("option");
        option.value = estado.id;
        option.ariaLabel = estado.nome;
        option.textContent = estado.nome;
        estados.appendChild(option);
    });
})
.catch(err => console.error(err));

const cidades = document.getElementById("cidades");
cidades.innerHTML = "<option value=''>Selecione a cidade</option>";
estados.addEventListener("change", () => {
    const estadoId = estados.value;
    cidades.innerHTML = "<option value=''>Selecione a cidade</option>";
    if (estadoId) {
        fetch(`https://servicodados.ibge.gov.br/api/v1/localidades/estados/${estadoId}/distritos`)
        .then(res => res.json())
        .then(data => {
            data.forEach(cidade => {
                const option = document.createElement("option");
                option.value = cidade.id;
                option.ariaLabel = cidade.nome;
                option.textContent = cidade.nome;
                cidades.appendChild(option);
            });
        })
        .catch(err => console.error(err));
    }
});

// Função exibir senha
const checkboxExibirSenha = document.getElementById("exibirSenha"); 
function exibirSenha() {
    const senhaRegistro = document.getElementById("senhaRegistro");
    const confirmarSenhaRegistro = document.getElementById("confirmarSenhaRegistro");
    if (checkboxExibirSenha.checked) {
        senhaRegistro.type = "text";
        confirmarSenhaRegistro.type = "text";
    } else {
        senhaRegistro.type = "password";
        confirmarSenhaRegistro.type = "password";
    }
    checkboxExibirSenha.setAttribute("aria-checked", checkboxExibirSenha.checked);
    if (checkboxExibirSenha.checked) {
        checkboxExibirSenha.setAttribute("aria-label", "Desmarcar para ocultar a senha");
    } else {
        checkboxExibirSenha.setAttribute("aria-label", "Marcar para exibir a senha");
    }
}

checkboxExibirSenha.addEventListener("click", exibirSenha);

const telefoneInput = document.getElementById("wpp");
telefoneInput.addEventListener("input", function() {
    let valor = telefoneInput.value.replace(/\D/g, ''); // Remove caracteres não numéricos
    if (valor.length > 11) {
        valor = valor.slice(0, 11); // Limita a 11 dígitos
    }
    if (valor.length > 0) {
        if (valor.length <= 10) {
            //(XX) XXXX-XXXX
            valor = `(${valor.slice(0, 2)}) ${valor.slice(2, 6)}${valor.length > 6 ? '-' + valor.slice(6) : ''}`;
        } else {
            //(XX) XXXXX-XXXX
            valor = `(${valor.slice(0, 2)}) ${valor.slice(2, 7)}${valor.length > 7 ? '-' + valor.slice(7) : ''}`;
        }
    }
    telefoneInput.value = valor;
    telefoneInput.setAttribute("aria-label", "Número de telefone com DDD");
});

// Apaga o último dígito ao pressionar Backspace
telefoneInput.addEventListener("keydown", function(e) {
    if (e.key === "Backspace") {
        e.preventDefault();
        let valor = telefoneInput.value.replace(/\D/g, '');
        valor = valor.slice(0, -1); // Remove o último dígito
        if (valor.length > 0) {
            if (valor.length <= 10) {
                valor = `(${valor.slice(0, 2)}) ${valor.slice(2, 6)}${valor.length > 6 ? '-' + valor.slice(6) : ''}`;
            } else {
                valor = `(${valor.slice(0, 2)}) ${valor.slice(2, 7)}${valor.length > 7 ? '-' + valor.slice(7) : ''}`;
            }
        }
        telefoneInput.value = valor;
    }
});
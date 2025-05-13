const submit = document.querySelector(".submit");

const values = [];


submit.addEventListener("click", () => {
    const name = document.getElementById("name").value;
    const age = document.getElementById("age").value;
    const weight = document.getElementById("weight").value;
    const alergies = document.getElementById("alergies").value;
    const healthProblems = document.getElementById("healthProblems").value;
    const telefoneNumber = document.getElementById("telefoneNumber").value;

    values.push({
         name: name,
         age: age,
         weight: weight,
         alergies: alergies,
         healthProblems: healthProblems,
         telefoneNumber: telefoneNumber
    });

    jsonValues = JSON.stringify(values);

    const fs = require("fs");
    fs.writeFileSync("../register/register.json", values);

    console.log(jsonValues);
});
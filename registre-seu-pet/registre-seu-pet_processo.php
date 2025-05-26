<?php
// faz a conexao com o banco
include_once "../conexao.php";
 
echo '<pre>'; print_r($_POST);echo '</pre>';
// variaveis
$msg = '';
if(isset($_POST)){
    
    $registro = $_POST['registro'];
    $name = $_POST['name'];
    $birthDate = $_POST['dtnasc'];
    $weight = $_POST['peso'];
    $vaccines = $_POST['vacinas'];
    $alergies = $_POST['alergias'];
    $serialNumber = $_POST['numeroSerie'];
    $filePhoto = $_FILES['inputImagem']['name'];
 
    $select1 = "SELECT * FROM `pets` WHERE Identificacao = '$serialNumber'";
    $selectUser = mysqli_query($conn, $select1);
    if(mysqli_num_rows($selectUser) > 0){
        $msg = 'cadastro inválido';
    }else{
        // verifica se o pet já foi cadastrado por outra pessoa
        $sql_consulta_pet_outra_pessoa = "SELECT * 
                                        FROM `pessoapet` AS pp
                                        INNER JOIN pessoas AS p
                                        ON pp.PessoaID = p.PessoaID
                                        INNER JOIN pets AS pt
                                        ON pp.PetID = pt.PetID
                                        WHERE pt.Identificacao = '$serialNumber'
                                        AND pp.PessoaID <> '$registro'
                                        AND pp.Excluido = 0
                                        AND pt.Excluido = 0
                                        AND p.Excluido = 0";
        mysqli_query($conn, $sql_consulta_pet_outra_pessoa);
        $outraPessoa = mysqli_insert_id($conn);

        if( empty($outraPessoa)){
            // faz o uplod da foto
            //$photo = 'pet_'.$name.$serialNumber.$registro.'.jpg';
            //$uploadFile = __DIR__ . '/images/' .$photo
            //move_uploaded_file($image_file["tmp_name"], $uploadFile);
            // cadastra
            $insert1 = "INSERT INTO `pets`(`Identificacao`, `Nome`, `Peso`, `DataNascimento`, `Especie`, `Alergias`, `Vacinas`, `Foto`, `Excluido`) VALUES ('$serialNumber','$name','$weight','$birthDate','null','$alergies','$vaccines','$photo', 0)";  
            exit($insert1);
            mysqli_query($conn, $insert1);
            $id = mysqli_insert_id($conn);
            exit("Cadastro realizado com sucesso!");
        }else{
            exit("Pet já cadastrado por outra pessoa!");
        }
    }
    //header("Location: ../conta-usuario/conta-usuario.html");
    //?registro="$id"
    //WHERE Email = '$email' AND Senha = '$password'
}
?>
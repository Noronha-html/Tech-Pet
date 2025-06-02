<?php
// faz a conexao com o banco
include_once "../conexao.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (headers_sent($file, $line)) {
    exit("Headers já foram enviados em $file na linha $line");
}
 

// variaveis
$msg = '';
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    
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
        //exit('a'.rand(0, 9999));
        $msg = 'cadastro inválido';
    }else{
        //exit('bOi'.rand(0, 9999));
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
        $result = mysqli_query($conn, $sql_consulta_pet_outra_pessoa);
        $outraPessoa = mysqli_insert_id($conn);

        
        if(empty($outraPessoa)){
            // faz o uplod da foto
            $photo = 'pet_'.base64_encode($name.$serialNumber.$registro.'-'.rand(0,9999)).'.jpg';
            $uploadDir = __DIR__ . DIRECTORY_SEPARATOR . 'pets' . DIRECTORY_SEPARATOR;
            $filePath = $uploadDir . $photo;

            // Se não existir, cria (com permissão 0755)
            if (!is_dir($uploadDir) && !mkdir($uploadDir, 0755, true)) {
                exit("Erro: não foi possível criar o diretório de imagens.");
            }else{

                if (move_uploaded_file($_FILES['inputImagem']['tmp_name'], $filePath)) { 
                    // cadastra
                    $insert1 = "INSERT INTO `pets`(`Identificacao`, `Nome`, `Peso`, `DataNascimento`, `Especie`, `Alergias`, `Vacinas`, `Foto`, `Excluido`) VALUES ('$serialNumber','$name','$weight','$birthDate','null','$alergies','$vaccines','$photo', 0)";  
                    //exit($insert1);
                    mysqli_query($conn, $insert1);
                    $id = mysqli_insert_id($conn);
                    /*header("Location: ../conta-usuario/conta-usuario.php?registro=$id");
                    exit("Cadastro realizado com sucesso!");*/
                    header("Location: ../conta-usuario/conta-usuario.php?id=$id");
                    exit;
                } 
                else { 
                    echo "Erro, o arquivo n&atilde;o pode ser enviado."; 
                }    
            }
        }else{
            exit("Pet já cadastrado por outra pessoa!");
        }
    }
}
?>
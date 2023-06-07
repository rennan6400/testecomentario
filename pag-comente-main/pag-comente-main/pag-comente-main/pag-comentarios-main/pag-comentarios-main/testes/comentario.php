<?php
session_start(); // Inicia a sessão

// Definição das variáveis de conexão com o banco de dados
$servidor = "localhost";
$usuario = "root";
$senha = "123456";
$dbname = "cadastro";

// Verifica se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Coleta os dados do formulário
    $nome = $_POST["nome"];
    $nome_academia = $_POST["nome_academia"];
    $comentario = $_POST["comentario"];

    // Conecta ao banco de dados
    $conn = new mysqli($servidor, $usuario, $senha, $dbname);
    if ($conn->connect_error) {
        die("Falha na conexão: " . $conn->connect_error);
    }

    // Prepara a consulta de inserção
    $stmt = $conn->prepare("INSERT INTO comentario (nome, nome_academia, comentario) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nome, $nome_academia, $comentario);

    // Executa a consulta de inserção
    if ($stmt->execute()) {
        echo "<script>alert(Dados salvos com sucesso!)</script>";
    } else {
        echo "Erro ao salvar os dados: " . $stmt->error;
    }

    // Fecha a conexão com o banco de dados
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="coment.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;700&display=swap" rel="stylesheet">
    
    
</head>
<body>

    <header>
            <div class="container">
                <div class="logo"><img src="./logo.jpg"></div>
                <div class="menu">
                    <nav>
                        <a href="index.html">Home</a>
                        <a href="#equipe">Nossa equipe</a>
                        <a href="login.php">Login</a>
                        <a href="cadastro.php">Cadastro</a>
                        <a href="https://mail.google.com">encontreacademias@gmail.com</a>
                    </nav>
            </div>
    </header>

    <div class="content">
    <div id="form-container">
    <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <label for="nome" class="center1">Nome:</label><br>
        <input type="text" name="nome" id="nome"><br>
        <label for="nome_academia">Nome da Academia:</label><br>
        <input type="text" name="nome_academia" id="nome_academia"><br>
        <label for="comentario">Comentário:</label><br>
        <textarea name="comentario" id="comentario"></textarea><br>
       
        <select name="format" id="format" style="width: 850px;">
  <option selected disabled>Nome da Academia</option>
  <option value="pdf">SpaceFitness</option>
  <option value="txt">TopFitness</option>
  <option value="epub">ClubFit</option>
  <option value="fb2">fb2</option>
  <option value="mobi">mobi</option>
</select>


        <input type="submit" value="Salvar" style="background-color: black; color: white;">

    </form>
</div>


        <div id="saved-data" class="comentarios">
            <h2>Comentários:</h2>
  
    <?php
		if(isset($_SESSION['msg'])){
			echo $_SESSION['msg']."<br><br>";
			unset($_SESSION['msg']);
		}
		?> 
		
			


<div class="left-align">
    

    <?php
    // Conecta novamente ao banco de dados
    $conn = new mysqli($servidor, $usuario, $senha, $dbname);
    if ($conn->connect_error) {
        die("Falha na conexão: " . $conn->connect_error);
    }

    // Consulta os dados salvos
    $sql = "SELECT nome, nome_academia, comentario FROM comentario";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<strong>Nome:</strong> " . $row["nome"] . "<br>";
            echo "<strong>Nome da Academia:</strong> " . $row["nome_academia"] . "<br>";
            echo "<strong>Comentário:</strong> " . $row["comentario"] . "<br><br>";
        }
    } else {
        echo "Nenhum comentário encontrado.";
    }

    // Fecha a conexão com o banco de dados
    $conn->close();
    ?>
    </div>
</body>
</html>
</body>
</html>

<!doctype html>
<html lang="en">

<head>
  <title>Title</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS v5.2.0-beta1 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css"
    integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">

</head>

<body>
  <header>
    <!-- place navbar here -->
  </header>
  <main class="container gap-5">
    <h1><?= isset($_GET['id']) ? 'Modifier le tag' : 'Créer un tag' ?></h1>
    <span>Mot clé</span>
    <form action="create_tag.php" method="post">
      <input class="form-control" name="tag" require>
      <?php 
        if(isset($_GET['id'])){
          echo '<input type="hidden" name="id" value="' . $_GET['id'] . '" />';
        }
      ?>
      <button type="submit" class="btn btn-success"><?= isset($_GET['id']) ? 'Mettre à jour' : 'Créer' ?></button>
    </form>
  </main>
  <footer>
    <!-- place footer here -->
    <?php
      $dbconnect = null;
      try {
        $host = "localhost";
        $port = "3306";
        $dbName = "db_blog";
        $dsn = "mysql:host=$host;port=$port;dbname=$dbName";
        $user = "root";
        $pass = "";
        $dbconnect = new PDO($dsn, $user, $pass, array(
          PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
          PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        ));
      } catch(PDOException $e){
        echo "Erreur de connexion à la base de données : $e->getMessage()";
      }
      if(!isset($_POST['id'])){
        if(isset($dbconnect) && !empty($_POST["tag"])){
          $sql = "INSERT INTO tag (title, is_deleted) VALUES (?, ?)";
          $statment = $dbconnect->prepare(($sql));
          $values = [$_POST['tag'], 0];
          $result = $statment->execute($values);
          if($result && $statment->rowCount() == 1){
            header("Location: http://php.loc/list_tag.php");
            die();
          } else {
            echo "Le tag n'a pas pu être créé";
          }
        }
      } else {
        if(isset($dbconnect) && !empty($_POST["id"]) && !empty($_POST["tag"])){
          $sql = "UPDATE tag SET title = ? WHERE Id_tag = ?";
          $statment = $dbconnect->prepare($sql);
          $values = [$_POST['tag'], $_POST['id']];
          $result = $statment->execute($values);
          if($result && $statment->rowCount() == 1){
            header("Location: http://php.loc/list_tag.php");
            die();
          } else {
            echo "Le tag n'a pas pu être mis à jour !";
          }
        }
      }
    ?>
  </footer>
  <!-- Bootstrap JavaScript Libraries -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js"
    integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous">
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js"
    integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK" crossorigin="anonymous">
  </script>
</body>

</html>
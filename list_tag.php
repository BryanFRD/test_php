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
          PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
        ));
      } catch(PDOException $e){
        echo "Erreur de connexion à la base de données : $e->getMessage()";
      }
      
      if($dbconnect != null){
        if(isset($_POST['delete'])){
          $sql = "UPDATE tag SET is_deleted = ? WHERE Id_tag = ?";
          $statment = $dbconnect->prepare($sql);
          $values = [1, $_POST['Id_tag']];
          $result = $statment->execute($values);
        }
        
        
        $sql = "SELECT * FROM tag WHERE is_deleted = ?";
        $statment = $dbconnect->prepare($sql);
        $result = $statment->execute([0]);
        $rows = $statment->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE);
      }
    ?>
  </header>
  <main class="container">
    <h1>Liste des tags</h1>
    <a href="create_tag.php" class="btn btn-primary">Créer un tag</a>
    <table class="table">
      <thead>
        <tr>
          <th>#</th>
          <th>Mot clé</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
          foreach($rows as $row){
            echo "<tr>
                    <th>$row->Id_tag</th>
                    <td>$row->title</td>
                    <td class='d-flex'>
                      <form method='POST' action='list_tag.php'>
                        <input type='hidden' name='Id_tag' value='$row->Id_tag'/>
                        <button class='btn btn-danger me-1' name='delete'>Delete</button>
                      </form>
                      <a href='create_tag.php?id=$row->Id_tag' class='btn btn-info'>Update</a>
                    </td>
                  </tr>";
          }
        ?>
      </tbody>
    </table>
  </main>
  <footer>
    <!-- place footer here -->
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
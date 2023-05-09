<?php 

require './ManagerPage.php';

$managerTask = new ManagerTask();
$allTasks = $managerTask->getAllTask();

    if(isset($_POST['title']) && isset($_POST['description']) && isset($_POST['important'])) {
        $newTask = new Task();
        $newTask->setTitle($_POST['title']);
        $newTask->setDescription($_POST['description']);
        $newTask->setImportant(boolval($_POST['important']));
        $managerTask->create($newTask);
    } 

// Gère la suppression
if (isset($_GET['delete']) && !empty($_GET['delete'])) {
    $managerTask->delete($_GET['delete']);
}

$getAllTasks = $managerTask->getAllTask();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo list</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <section id="formulaire" class="formulaire">
        <form method="POST" action="">
           <h1>Tableau des tâches</h1>
           <div class="séparation">
            <div class="corps-formulaire">
                <div class="contenu">
                    <div class="boite">
                        <label for="title">Titre</label>
                        <input type="text" name="title" maxlength="50" value="">
                    </div>
                    <div class="boite">
                        <label for="description">Description</label>
                        <input type="text" name="description" maxlength="150" value="">
                    </div>
                    <div class="boite">
                        <label for="important">Important</label>
                        <select type="select" name="important">
                          <option value="false">Pas important</option>
                          <option value="true">Important</option>
                        </select>

                    </div>
                </div>
            </div>
            <div class="pied-formulaire">
                <button name="submit"><strong>Envoyer</strong></button>
            </div>
           </div>
        </form>
    </section>

    <section id="list" class="list">
        <h1>Listes des tâches</h1>
        <div class="tab">
          <table> 
            <thead>
            <tr>
                <th>Titre</th>
                <th>Description</th>
                <th>Important</th>
                <th>Supprimer</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($getAllTasks as $task) { ?>
            <tr>
             <td><?php echo $task->getTitle(); ?></td> 
             <td><?php echo $task->getDescription(); ?></td> 
             <td><?php echo $task->getImportant() ? 'Important' : 'Pas important'; ?></td>
             <td><a href="index.php?delete=<?php echo $task->getId(); ?>" class="trash">Supprimer</a></td>  
            </tr>
             <?php } ?>
            </tbody>
          </table>
        </div>
    </section> 
</body>
</html>
<?php 

require_once ('./DBManager.php');
require ('./Class.php');

class ManagerTask extends DBManager {

    public function getAllTask() {
        $res = $this->getConnexion()->query('SELECT * from task Order by task.id ASC');

        $tasks = [];

        foreach($res as $row) {
          $newTask = new Task();
          $newTask->setId($row['id']);
          $newTask->setTitle($row['title']);
          $newTask->setDescription($row['description']);
          $newTask->setImportant($row['important']);

          $tasks[] = $newTask;
        }
        return $tasks;
    }

    public function create($task) {
    $request = 'INSERT INTO task (title, description, important) VALUE (?, ?, ?)';
    $query = $this->getConnexion()->prepare($request);

    $query->execute([
        $task->getTitle(), $task->getDescription(), $task->getImportant()
    ]);
    // Rafraichie la page
    header('Location:index.php');
  }

  public function findById($taskId) {
  $request = 'SELECT * FROM task WHERE id = :id';
  $query = $this->getConnexion()->prepare($request);
  $query->execute([':id' => $taskId]);
  $row = $query->fetch();

  if ($row) {
      $newTask = new Task();
      $newTask->setId($row['id']);
      $newTask->setTitle($row['title']);
      $newTask->setDescription($row['description']);
      $newTask->setImportant($row['important']);
      return $newTask;
  }

  return null;
}

public function delete($taskId) {
    $taskToDelete = $this->findById($taskId);
    if($taskToDelete) {
      $request = 'DELETE from task WHERE id = ' . $taskId;
      $query = $this->getConnexion()->prepare($request);
      $query->execute();

     header('Location:index.php');
      exit();
    }
}

}

?>
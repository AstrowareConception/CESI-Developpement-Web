<?php 
namespace App\Controllers;

use App\Models\TaskModel;

class TaskController extends Controller {

    public function __construct($templateEngine) {
        $this->model = new TaskModel();
        $this->templateEngine = $templateEngine;
    }

    public function welcomePage() {
        // Retrieve the list of tasks from the model
        $tasks = $this->model->getToDoTasks();
        echo $this->templateEngine->render('todo.twig.html', ['tasks' => $tasks]);
    }

    public function addTask() {
        // First, we check if the 'task' parameter is present in the POST request
        if (!isset($_POST['task']) || empty(trim($_POST['task']))) {
            // If not, we redirect the user to the home page
            header('Location: ' . BASE_URL);
            exit();
        }

        // Then, we retrieve the value of the 'task' parameter
        $taskName = $_POST['task'];
        // We call the addTask method of the model with the task as a parameter
        $this->model->addTask($taskName);
        // Finally, we redirect the user to the home page
        header('Location: ' . BASE_URL);
        exit();
    }

    public function checkTask() {
        // First, we check if the 'id' parameter is present in the POST request
        if (!isset($_POST['id'])) {
            // If not, we redirect the user to the home page
            header('Location: ' . BASE_URL);
            exit();
        }

        // Then, we retrieve the value of the 'id' parameter
        $id = $_POST['id'];
        // We call the checkTask method of the model with the id as a parameter
        $this->model->checkTask($id);
        // Finally, we redirect the user to the home page
        header('Location: ' . BASE_URL);
        exit();
    }

    public function historyPage() {
        // Retrieve the list of tasks from the model
        $tasks = $this->model->getDoneTasks();
        // Render the history.twig.html template with the list of tasks
        echo $this->templateEngine->render('history.twig.html', ['tasks' => $tasks]);
    }

    public function uncheckTask() {
        // First, we check if the 'id' parameter is present in the POST request
        if (!isset($_POST['id'])) {
            header('Location: ' . BASE_URL . '?uri=history');
            exit();
        }

        // Then, we retrieve the value of the 'id' parameter
        $id = $_POST['id'];
        // We call the uncheckTask method of the model with the id as a parameter
        $this->model->uncheckTask($id);
        // Finally, we redirect the user to the history page
        header('Location: ' . BASE_URL . '?uri=history');
        exit();
    }

    public function aboutPage() {
        // Render the about.twig.html template
        echo $this->templateEngine->render('about.twig.html');
    }


}

<?php
namespace App\Tests;
use PHPUnit\Framework\TestCase;
use App\Models\TaskModel;
use App\Models\FileDatabase;

class TaskModelTest extends TestCase {

    public function testGetToDoTasks() {
        
        $connection = $this->createStub(FileDatabase::class);
        $connection->method('getAllRecords')->willReturn([
            ['task' => 'test task 1', 'status' => 'todo'],
            ['task' => 'test task 2', 'status' => 'todo'],
            ['task' => 'test task 3', 'status' => 'done'],
        ]);

        $model = new TaskModel($connection);
        $tasks = $model->getToDoTasks();

        $this->assertCount(2, $tasks);
        $this->assertContains( ['task' => 'test task 1', 'status' => 'todo'], $tasks);
        $this->assertContains( ['task' => 'test task 2', 'status' => 'todo'], $tasks);
    }

    public function testAddTask() {
        
        $connection = $this->createMock(FileDatabase::class);
        $connection->expects($this->once())
            ->method('insertRecord')
            ->with(['task' => 'test task', 'status' => 'todo'])
            ->willReturn(true);

        $model = new TaskModel($connection);
        $result = $model->addTask('test task');

        $this->assertTrue($result);
    }

    public function testGetDoneTasks() {
        $connection = $this->createStub(FileDatabase::class);
        $connection->method('getAllRecords')->willReturn([
            ['task' => 'test task 1', 'status' => 'todo'],
            ['task' => 'test task 2', 'status' => 'todo'],
            ['task' => 'test task 3', 'status' => 'done'],
        ]);

        $model = new TaskModel($connection);
        $tasks = $model->getDoneTasks();

        $this->assertCount(1, $tasks);
        $this->assertContains(['task' => 'test task 3', 'status' => 'done'], $tasks);
    }

}
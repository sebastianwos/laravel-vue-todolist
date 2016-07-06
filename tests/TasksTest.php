<?php

use App\User;
use App\Task;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TasksTest extends TestCase
{

    use DatabaseTransactions;

    /**
     * @test
     */
    public function a_user_can_add_a_task_to_his_list()
    {

        $user = factory(App\User::class)->create();
//        $task = factory(App\Task::class)->create(['user_id' => $user->id]);
        $task = new App\Task;
        $task->body = 'body';
        $task->end_date = '2016-06-25';

        $user->addTask($task);

        $this->seeInDatabase('tasks', ['user_id' => $user->id, 'body' => 'body', 'end_date' => '2016-06-25']);

    }

    /**
     * @test
     */
    public function task_can_be_changed_to_completed(){

        $user = factory(App\User::class)->create();
        $task = new App\Task;
        $task->body = 'body';
        $task->end_date = '2016-06-25';

        $user->addTask($task);

        $currentStatus = $task->completed;

        $task->toggleStatus();

        $this->assertTrue($task->completed, !$currentStatus);

    }

    /**
     * @test
     */
    public function a_user_can_delete_task_from_his_list(){

        $user = factory(App\User::class)->create();
        $task = new App\Task;
        $task->body = 'body';
        $task->end_date = '2016-06-25';
        $user->addTask($task);

        $this->assertEquals(1, count(App\Task::all()));

        $task->deleteTask();

        $this->assertEquals(0, count(App\Task::all()));
    }

    /**
     * @test
     */
    public function a_user_can_get_list_of_his_tasks(){

        $user = factory(App\User::class)->create();
        $task = factory(App\Task::class)->create(['user_id' => $user->id]);
        $task2 = factory(App\Task::class)->create(['user_id' => $user->id]);
        $task3 = factory(App\Task::class)->create(['user_id' => $user->id]);
        $user->addTask($task)
             ->addTask($task2)
             ->addTask($task3);

        $this->assertEquals(3, count($user->tasks));

    }

}

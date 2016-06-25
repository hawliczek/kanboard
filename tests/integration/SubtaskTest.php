<?php

require_once __DIR__.'/BaseIntegrationTest.php';

class SubtaskTest extends BaseIntegrationTest
{
    protected $projectName = 'My project to test subtasks';
    private $subtaskId = 0;

    public function testAll()
    {
        $this->assertCreateTeamProject();
        $this->assertCreateTask();
        $this->assertCreateSubtask();
        $this->assertGetSubtask();
        $this->assertUpdateSubtask();
        $this->assertGetAllSubtasks();
        $this->assertRemoveSubtask();
    }

    public function assertCreateSubtask()
    {
        $this->subtaskId = $this->app->createSubtask(array(
            'task_id' => $this->taskId,
            'title' => 'subtask #1',
        ));

        $this->assertNotFalse($this->subtaskId);
    }

    public function assertGetSubtask()
    {
        $subtask = $this->app->getSubtask($this->subtaskId);
        $this->assertEquals($this->taskId, $subtask['task_id']);
        $this->assertEquals('subtask #1', $subtask['title']);
    }

    public function assertUpdateSubtask()
    {
        $this->assertTrue($this->app->execute('updateSubtask', array(
            'id' => $this->subtaskId,
            'task_id' => $this->taskId,
            'title' => 'test',
        )));

        $subtask = $this->app->getSubtask($this->subtaskId);
        $this->assertEquals('test', $subtask['title']);
    }

    public function assertGetAllSubtasks()
    {
        $subtasks = $this->app->getAllSubtasks($this->taskId);
        $this->assertCount(1, $subtasks);
        $this->assertEquals('test', $subtasks[0]['title']);
    }

    public function assertRemoveSubtask()
    {
        $this->assertTrue($this->app->removeSubtask($this->subtaskId));

        $subtasks = $this->app->getAllSubtasks($this->taskId);
        $this->assertCount(0, $subtasks);
    }
}

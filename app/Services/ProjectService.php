<?php

namespace App\Services;

use App\Contracts\Services\ProjectServiceInterface;
use App\Helpers\Calculator;
use App\Models\Action;
use App\Models\Project;

class ProjectService implements ProjectServiceInterface
{
    /** @var Project $project */
    private $project;

    /**
     * Constructor.
     * 
     * @param Project $project
     */
    public function __construct(Project $project)
    {
        $this->project = $project;
    }

    /**
     * List projects.
     * 
     * @return array
     */
    public function list()
    {
        $projects = array();
        $calculator = new Calculator;
        
        foreach ($this->project->all() as $project) {
            $timeInMinutes = 0;
            foreach ($project->action as $action) {
                $timeInMinutes = $timeInMinutes + intval($calculator->timeInMinutes($action->started_at, $action->stoped_at));
            }
            $project->time = intval(floor($timeInMinutes / 60));

            $projects[] = $project;
        }

        return $projects;
    }

    /**
     * Get project by ID.
     *
     * @param  int $id
     * 
     * @return false|Project
     */
    public function getById(int $id)
    {
        $project = $this->project->find($id);
        
        if(empty($project))
            return false;

        return $project;
    }

    /**
     * Create project.
     *
     * @param  array $data
     * 
     * @return Response
     */
    public function store(array $data)
    {
        $project = $this->project->create($data);
        if($project){
            $action = array(
                'project_id' => $project->id
            );

            $actionModel = new Action();
            $actionModel->create($action);
        }

        return $project;
    }

    /**
     * Update project.
     * 
     * @param  int $id
     * @param  array $data
     * 
     * @return array
     */
    public function update(int $id, array $data)
    {
        $project = $this->getById($id);
        if(empty($project)){
            return array(
                'status' => false,
                'msg' => 'Project not found.'
            );
        }

        if($project->update($data)){
            return array(
                'status' => true,
                'msg' => 'Project updated with success!'
            );
        }

        return array(
            'status' => false,
            'msg' => 'Error to update project. Please, try again!'
        );
    }

    /**
     * Delete project.
     * 
     * @param  int $id
     * 
     * @return array
     */
    public function delete(int $id)
    {
        $project = $this->getById($id);
        if(empty($project)){
            return array(
                'status' => false,
                'msg' => 'Project not found.'
            );
        }

        try {
            foreach ($project->action as $action) {
                $action->delete();
            }

            $project->delete();

            return array(
                'status' => true,
                'msg' => 'Project removed with success!'
            );
        } catch (\Throwable $th) {
            throw $th;
        }

        return array(
            'status' => false,
            'msg' => 'Error to remove project. Please, try again!'
        );
    }

    /**
     * Finish project.
     * 
     * @param int $id
     * 
     * @return boolean
     */
    public function finish($id)
    {
        $project = $this->project->find($id);      
        $project->status = 'finished';

        foreach ($project->action as $action) {
            if(empty($action->stoped_at)){
                $action->stoped_at = date("Y-m-d H:i:s");
                $action->save();
            }
        }

        if($project->save())
            return true;

        return false;
    }
}
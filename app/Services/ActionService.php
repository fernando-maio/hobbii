<?php

namespace App\Services;

use App\Contracts\Services\ActionServiceInterface;
use App\Helpers\Calculator;
use App\Models\Action;
use App\Models\Project;

class ActionService implements ActionServiceInterface
{
    const TAX_DKK = 500;

    /** @var Action $action */
    private $action;

    /** @var Project $project */
    private $project;

    /**
     * Constructor.
     * 
     * @param Action $action
     */
    public function __construct(Action $action)
    {
        $this->action = $action;
        $this->project = new Project();
    }

    /**
     * List actions.
     * 
     * @return array
     */
    public function list()
    {
        $projects = array();
        $calculator = new Calculator;
        $allProjects = $this->project->where('status', '<>', 'finished')->get();
        
        foreach ($allProjects as $project) {
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
     * Run actions.
     * 
     * @param int $id
     * 
     * @return boolean
     */
    public function run($id)
    {
        $project = $this->project->find($id);

        if(empty($project->action->first()->started_at)){
            $project->action->first()->started_at = date("Y-m-d H:i:s");
            $project->action->first()->save();
        } else{
            $action = array(
                'project_id' => $project->id,
                'started_at' => date("Y-m-d H:i:s")
            );

            $this->action->create($action);
        }

        $project->status = 'running';

        if($project->save())
            return true;

        return false;
    }

    /**
     * Stop actions.
     * 
     * @param int $id
     * 
     * @return boolean
     */
    public function stop($id)
    {
        $action = $this->action->where('project_id', $id)->where('stoped_at', null)->first();

        if(!$action){
            return false;
        }

        $action->stoped_at = date("Y-m-d H:i:s");        
        $action->project->status = 'stopped';

        if($action->save() && $action->project->save())
            return true;

        return false;
    }

    /**
     * Generate Invoice.
     * 
     * @param int $id
     * 
     * @return array|false
     */
    public function invoice($id)
    {
        $actions = $this->action->where('project_id', $id)->where('invoiced', 0)->get();

        if(count($actions) == 0)
            return false;

        $calculator = new Calculator;
        $timeInMinutes = 0;
        $timeInhours = 0;
        foreach ($actions as $action) {
            $timeInMinutes = $timeInMinutes + intval($calculator->timeInMinutes($action->started_at, $action->stoped_at));
            $action->invoiced = 1;
            $action->save();
        }

        $timeInhours = intval(floor($timeInMinutes / 60));

        $data = array(
            'time' => $timeInhours,
            'value' => $timeInhours * self::TAX_DKK,
            'project' => $actions->first()->project
        );

        return $data;
    }
}
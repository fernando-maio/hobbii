<?php

namespace App\Http\Controllers;

use App\Contracts\Services\ClientServiceInterface;
use App\Contracts\Services\ProjectServiceInterface;
use App\Helpers\Validations;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /** @var ProjectServiceInterface $projectService */
    private $projectService;

    /** @var ClientServiceInterface $clientService */
    private $clientService;

    /**
     * Constructor.
     * 
     * @param ProjectServiceInterface $projectServiceInterface
     * @param ClientServiceInterface $clientServiceInterface
     */
    public function __construct(ProjectServiceInterface $projectServiceInterface, ClientServiceInterface $clientServiceInterface)
    {
        $this->projectService = $projectServiceInterface;
        $this->clientService = $clientServiceInterface;
    }

    /**
     * List projects.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $projects = $this->projectService->list();

        return view('projects.index', array('projects' => $projects));
    }

    /**
     * Create project.
     * 
     * @return Response
     */
    public function create()
    {
        $clients = $this->clientService->list();

        return view('projects.create', array('clients' => $clients));
    }

    /**
     * Post create project.
     * Validate data with mandatory requests.
     *
     * @param  Request  $request
     * 
     * @return Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $validation = Validations::projectValidation($data);
        
        if (!$validation->passes()) {
            return redirect()
            ->back()
            ->withErrors($validation)
            ->withInput();
        }

        if($this->projectService->store($data))
            return redirect()->route("projects")->with('status', 'Project created with success!');
        
        return redirect()->back()->withErrors('Error to create project. Please, try again!')->withInput();
    }

    /**
     * Get data project.
     * 
     * @param int $id project ID
     * 
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $project = $this->projectService->getById($id);
        $clients = $this->clientService->list();

        if(!$project)
            return redirect()->route("projects")->withErrors('Project not found!');
        
        return view('projects.edit', array('project' => $project, 'clients' => $clients));
    }

    /**
     * Update project.
     *
     * @param int $id project id 
     * @param Request $request
     * 
     * @return Response
     */
    public function update($id, Request $request)
    {
        $data = $request->all();
        $project = $this->projectService->getById($id);
        $validation = Validations::projectValidation($data, $project);
        if (!$validation->passes()) {
            return redirect()
            ->back()
            ->withErrors($validation)
            ->withInput();
        }

        $response = $this->projectService->update($id, $data);
        if($response['status'])
            return redirect()->route("projects")->with('status', $response['msg']);
        
        return redirect()->back()->withErrors($response['msg'])->withInput();
    }

    /**
     * Delete project.
     *
     * @param  int $id
     * 
     * @return array
     */
    public function remove(int $id)
    {
        $response = $this->projectService->delete($id);

        if($response['status'])
            return redirect()->route("projects")->with('status', $response['msg']);

        return redirect()->back()->withErrors($response['msg']);
    }

    /**
     * Finish project.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function finish($id)
    {
        $actions = $this->projectService->finish($id);

        if($actions)
            return redirect()->route("actions")->with('status', 'Job is finished. The project will be on the project list.');

        return redirect()->route("actions")->withErrors('Error to finish job. Try again latter.');
    }
}

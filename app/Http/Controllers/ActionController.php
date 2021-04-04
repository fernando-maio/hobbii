<?php

namespace App\Http\Controllers;

use App\Contracts\Services\ActionServiceInterface;
use App\Contracts\Services\ClientServiceInterface;
use App\Contracts\Services\ProjectServiceInterface;
use Illuminate\Http\Request;

class ActionController extends Controller
{
    /** @var ActionServiceInterface $actionService */
    private $actionService;

    /** @var ProjectServiceInterface $projectService */
    private $projectService;

    /** @var ClientServiceInterface $clientService */
    private $clientService;

    /**
     * Constructor.
     * 
     * @param ActionServiceInterface $actionServiceInterface
     * @param ProjectServiceInterface $projectServiceInterface
     * @param ClientServiceInterface $clientServiceInterface
     */
    public function __construct(
        ActionServiceInterface $actionServiceInterface, 
        ProjectServiceInterface $projectServiceInterface, 
        ClientServiceInterface $clientServiceInterface
    ) {
        $this->actionService = $actionServiceInterface;
        $this->projectService = $projectServiceInterface;
        $this->clientService = $clientServiceInterface;
    }

    /**
     * List actions.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $actions = $this->actionService->list();

        return view('actions.index', array('actions' => $actions));
    }

    /**
     * Run action.
     * 
     * @param int $id
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function run($id)
    {
        $actions = $this->actionService->run($id);

        if($actions)
            return redirect()->route("actions")->with('status', 'Job is running');

        return redirect()->route("actions")->withErrors('Error to run job. Try again latter.');
    }

    /**
     * Stop action.
     * 
     * @param int $id
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function stop($id)
    {
        $actions = $this->actionService->stop($id);

        if($actions)
            return redirect()->route("actions")->with('status', 'Job is stoped');

        return redirect()->route("actions")->withErrors('Error to stop job. Try again latter.');
    }

    /**
     * Generate Invoice.
     * 
     * @param int $id
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function invoice($id)
    {
        $actions = $this->actionService->invoice($id);

        if(!$actions)
            return redirect()->route("actions")->withErrors('Any invoice was found.');

        return view('actions.invoice', array('actions' => $actions));
    }
}

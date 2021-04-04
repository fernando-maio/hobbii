<?php

namespace Tests\Feature;

use App\Models\Action;
use App\Models\Client;
use App\Models\Project;
use App\Services\ActionService;
use App\Services\ClientService;
use App\Services\ProjectService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ActionTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_list_all_actions()
    {
        $action = Action::factory()->make();
        $service = new ActionService($action);

        $this->assertIsArray($service->list());
    }

    public function test_run_project_started_null()
    {
        $client = Client::factory()->make();
        $service = new ClientService($client);
        $client->save();
        
        $project = Project::factory()->make();
        $service = new ProjectService($project);
        
        $project->client_id = $client->id;
        $project->save();

        $action = Action::factory()->make();
        $service = new ActionService($action);
        $action->project_id = $project->id;
        $action->save();
        
        $this->assertTrue($service->run($project->id));
    }

    public function test_run_project_started_not_null()
    {
        $client = Client::factory()->make();
        $service = new ClientService($client);
        $client->save();
        
        $project = Project::factory()->make();
        $service = new ProjectService($project);
        
        $project->client_id = $client->id;
        $project->save();

        $action = Action::factory()->make();
        $service = new ActionService($action);
        $action->project_id = $project->id;
        $action->started_at = $this->faker->dateTime;
        $action->stoped_at = date("Y-m-d H:i:s");
        $action->save();
        
        $this->assertTrue($service->run($project->id));
    }
    
    public function test_stop_action()
    {
        $client = Client::factory()->make();
        $service = new ClientService($client);
        $client->save();
        
        $project = Project::factory()->make();
        $service = new ProjectService($project);
        
        $project->client_id = $client->id;
        $project->save();

        $action = Action::factory()->make();
        $service = new ActionService($action);
        $action->project_id = $project->id;
        $action->save();

        $this->assertTrue($service->stop($project->id));
    }

    public function test_stop_action_with_inexistent_project_id()
    {
        $action = Action::factory()->make();
        $service = new ActionService($action);

        $this->assertFalse($service->stop(400));
    }

    public function test_generate_invoice()
    {
        $client = Client::factory()->make();
        $service = new ClientService($client);
        $client->save();
        
        $project = Project::factory()->make();
        $service = new ProjectService($project);
        
        $project->client_id = $client->id;
        $project->save();

        $action = Action::factory()->make();
        $service = new ActionService($action);
        $action->project_id = $project->id;
        $action->save();

        $this->assertIsArray($service->invoice($project->id));
    }

    public function test_generate_invoice_with_inexistent_project_id()
    {
        $action = Action::factory()->make();
        $service = new ActionService($action);

        $this->assertFalse($service->invoice(400));
    }
}

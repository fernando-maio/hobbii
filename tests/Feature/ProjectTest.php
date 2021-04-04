<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Project;
use App\Services\ClientService;
use App\Services\ProjectService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_list_all_projects()
    {
        $project = Project::factory()->make();
        $service = new ProjectService($project);

        $this->assertIsArray($service->list());
    }

    public function test_get_project_by_valid_id()
    {
        $client = Client::factory()->make();
        $service = new ClientService($client);
        $client->save();
        
        $project = Project::factory()->make();
        $service = new ProjectService($project);
        
        $project->client_id = $client->id;
        $project->save();
        
        $this->assertIsObject($service->getById($project->id));
    }
    
    public function test_get_project_by_inexistent_id()
    {
        $project = Project::factory()->make();
        $service = new ProjectService($project);
        
        $this->assertFalse($service->getById(400));
    }
    
    public function test_store_project()
    {
        $client = Client::factory()->make();
        $service = new ClientService($client);
        $client->save();

        $project = Project::factory()->make();
        $service = new ProjectService($project);
        
        $data = array(
            'name' => $this->faker->name,
            'client_id' => $client->id
        );
        
        $this->assertIsObject($service->store($data));
    }
    
    public function test_update_project()
    {
        $client = Client::factory()->make();
        $service = new ClientService($client);
        $client->save();

        $project = Project::factory()->make();
        $service = new ProjectService($project);
        $project->client_id = $client->id;
        $project->save();
        
        $data = array(
            'name' => $this->faker->name
        );
        
        $this->assertTrue($service->update($project->id, $data)['status']);
    }
    
    public function test_update_inexistent_project()
    {
        $client = Client::factory()->make();
        $service = new ClientService($client);
        $client->save();

        $project = Project::factory()->make();
        $service = new ProjectService($project);
        $project->client_id = $client->id;
        $project->save();
        
        $data = array(
            'name' => $this->faker->name
        );
        
        $this->assertFalse($service->update(400, $data)['status']);
    }
    
    public function test_remove_project()
    {
        $client = Client::factory()->make();
        $service = new ClientService($client);
        $client->save();

        $project = Project::factory()->make();
        $service = new ProjectService($project);
        $project->client_id = $client->id;
        $project->save();
        
        $this->assertTrue($service->delete($project->id)['status']);
    }

    public function test_remove_client_by_inexistent_id()
    {
        $client = Client::factory()->make();
        $service = new ClientService($client);
        $client->save();

        $project = Project::factory()->make();
        $service = new ProjectService($project);
        $project->client_id = $client->id;
        $project->save();
        
        $this->assertFalse($service->delete(400)['status']);
    }

    public function test_finish_project()
    {
        $client = Client::factory()->make();
        $service = new ClientService($client);
        $client->save();

        $project = Project::factory()->make();
        $service = new ProjectService($project);
        $project->client_id = $client->id;
        $project->save();
        
        $this->assertTrue($service->finish($project->id));
    }
}

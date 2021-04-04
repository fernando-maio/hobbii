<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Services\ClientService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ClientTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_list_all_clients()
    {
        $client = Client::factory()->make();
        $service = new ClientService($client);

        $this->assertIsObject($service->list());
    }

    public function test_get_client_by_valid_id()
    {
        $client = Client::factory()->make();
        $service = new ClientService($client);
        $client->save();

        $this->assertIsObject($service->getById($client->id));
    }

    public function test_get_client_by_inexistent_id()
    {
        $client = Client::factory()->make();
        $service = new ClientService($client);

        $this->assertFalse($service->getById(400));
    }

    public function test_store_client()
    {
        $client = Client::factory()->make();
        $service = new ClientService($client);

        $data = array(
            'client_name' => $this->faker->name,
            'contact_name' => $this->faker->name,
            'phone' => $this->faker->phoneNumber,
            'email' => $this->faker->unique()->safeEmail
        );

        $this->assertIsObject($service->store($data));
    }

    public function test_update_client()
    {
        $client = Client::factory()->make();
        $service = new ClientService($client);
        $client->save();

        $data = array(
            'contact_name' => $this->faker->name,
            'phone' => $this->faker->phoneNumber
        );

        $this->assertTrue($service->update($client->id, $data)['status']);
    }

    public function test_update_inexistent_client()
    {
        $client = Client::factory()->make();
        $service = new ClientService($client);
        $client->save();

        $data = array(
            'contact_name' => $this->faker->name,
            'phone' => $this->faker->phoneNumber
        );

        $this->assertFalse($service->update(400, $data)['status']);
    }

    public function test_remove_client()
    {
        $client = Client::factory()->make();
        $service = new ClientService($client);
        $client->save();

        $this->assertTrue($service->delete($client->id)['status']);
    }

    public function test_remove_client_by_inexistent_id()
    {
        $client = Client::factory()->make();
        $service = new ClientService($client);

        $this->assertFalse($service->delete(400)['status']);
    }
}

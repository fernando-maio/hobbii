<?php

namespace App\Services;

use App\Contracts\Services\ClientServiceInterface;
use App\Models\Client;

class ClientService implements ClientServiceInterface
{
    /** @var Client $client */
    private $client;

    /**
     * Constructor.
     * 
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * List clients.
     * 
     * @return Response
     */
    public function list()
    {
        return $this->client->all();
    }

    /**
     * Get client by ID.
     *
     * @param  int $id
     * 
     * @return false|Response
     */
    public function getById(int $id)
    {
        $client = $this->client->find($id);
        
        if(empty($client))
            return false;

        return $client;
    }

    /**
     * Create client.
     *
     * @param  array $data
     * 
     * @return Response
     */
    public function store(array $data)
    {
        return $this->client->create($data);
    }

    /**
     * Update client.
     * 
     * @param  int $id
     * @param  array $data
     * 
     * @return array
     */
    public function update(int $id, array $data)
    {
        $client = $this->getById($id);
        if(empty($client)){
            return array(
                'status' => false,
                'msg' => 'Client not found.'
            );
        }

        if($client->update($data)){
            return array(
                'status' => true,
                'msg' => 'Client updated with success!'
            );
        }

        return array(
            'status' => false,
            'msg' => 'Error to update client. Please, try again!'
        );
    }

    /**
     * Delete client.
     * 
     * @param  int $id
     * 
     * @return array
     */
    public function delete(int $id)
    {
        $client = $this->getById($id);
        if(empty($client)){
            return array(
                'status' => false,
                'msg' => 'Client not found.'
            );
        }

        if($client->delete()){
            return array(
                'status' => true,
                'msg' => 'Client removed with success!'
            );
        }
        else{
            return array(
                'status' => false,
                'msg' => 'Error to remove client. Please, try again!'
            );
        } 
    }
}
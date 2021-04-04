<?php

namespace App\Http\Controllers;

use App\Contracts\Services\ClientServiceInterface;
use App\Helpers\Validations;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /** @var ClientServiceInterface $clientService */
    private $clientService;

    /**
     * Constructor.
     * 
     * @param ClientServiceInterface $clientServiceInterface
     */
    public function __construct(ClientServiceInterface $clientServiceInterface)
    {
        $this->clientService = $clientServiceInterface;
    }

    /**
     * List clients.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $clients = $this->clientService->list();

        return view('clients.index', array('clients' => $clients));
    }

    /**
     * Create client.
     * 
     * @return Response
     */
    public function create()
    {
        return view('clients.create');
    }

    /**
     * Post create client.
     * Validate data with mandatory requests.
     *
     * @param  Request  $request
     * 
     * @return Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $validation = Validations::clientValidation($data);
        
        if (!$validation->passes()) {
            return redirect()
            ->back()
            ->withErrors($validation)
            ->withInput();
        }

        if($this->clientService->store($data))
            return redirect()->route("clients")->with('status', 'Client created with success!');
        
        return redirect()->back()->withErrors('Error to create client. Please, try again!')->withInput();
    }

    /**
     * Get data client.
     * 
     * @param int $id client ID
     * 
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $client = $this->clientService->getById($id);

        if(!$client)
            return redirect()->route("clients")->withErrors('Client not found!');
        
        return view('clients.edit', array('client' => $client));
    }

    /**
     * Update client.
     *
     * @param int $id client id 
     * @param Request $request
     * 
     * @return Response
     */
    public function update($id, Request $request)
    {
        $data = $request->all();
        $validation = Validations::clientValidation($data);
        if (!$validation->passes()) {
            return redirect()
            ->back()
            ->withErrors($validation)
            ->withInput();
        }

        $response = $this->clientService->update($id, $data);
        if($response['status'])
            return redirect()->route("clients")->with('status', $response['msg']);
        
        return redirect()->back()->withErrors($response['msg'])->withInput();
    }

    /**
     * Delete client.
     *
     * @param  int $id
     * 
     * @return array
     */
    public function remove(int $id)
    {
        $response = $this->clientService->delete($id);

        if($response['status'])
            return redirect()->route("clients")->with('status', $response['msg']);

        return redirect()->back()->withErrors($response['msg']);
    }
}

<?php

namespace App\Helpers;

use App\Models\Project;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class Validations
{
    /**
     * Validate client data. It's used to create and update actions
     * 
     * @param array $data
     * 
     * @return Validator
     */
    public static function clientValidation($data)
    {
        $rules = array(
            'client_name' => 'required',
            'contact_name' => 'required',
            'phone' => 'required',
            'email' => 'required|email'
        );

        $messages = array(
	    	'client_name.required' => 'Insert a client name.',
	    	'contact_name.required' => 'Insert a contact name.',
	    	'phone.required' => 'Insert a phone.',
	    	'email.required' => 'Insert an email.',
	    	'email.email' => 'Email format is wrong.'
        );
        
        return Validator::make($data, $rules, $messages);
    }

    /**
     * Validate project data. It's used to create and update actions
     * 
     * @param array $data
     * @param Project|null $project
     * 
     * @return Validator
     */
    public static function projectValidation($data, $project = null)
    {        
        $rules = array(
            'client_id' => 'required'
        );
        
        $messages = array(
            'name.required' => 'Insert name',
	    	'client_id.required' => 'Select client'
        );
        
        if(empty($project) || $project->name != $data['name']){
            $rules['name'] = 'required|unique:projects';
            $messages['name.unique'] = 'This project name already exists';
        } else {
            $rules['name'] = 'required';
        }
        
        return Validator::make($data, $rules, $messages);
    }
}
<?php

use Illuminate\Support\Arr;

function changeKeyReturnRequest(array $params)
        /**
    * @params [array,string,any]
    *
    *request => $request,
    *name_key => 'name' ,
    *data_key => 'any'
    *----------------------
    *return data_request
    *-----------------
    */
{
    $data = $params['request'];
    Arr::pull($data,$params['name_key']);
    Arr::set($data,$params['name_key'],$params['data_key']);

    return  $data;
}


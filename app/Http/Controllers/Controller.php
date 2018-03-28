<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


		//TODO
    protected function metaSuccess(){
		    $meta['ec']=0;
		    $meta['msg']="Success";
		    return $meta;
    }

    protected function metaFailed($message=false){
		    $meta['ec']=100;
		    $meta['msg']= $message===false ? "Failed" : $message;
				return $meta;
    }
}

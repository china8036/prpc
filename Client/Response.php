<?php
namespace Witgame\Rpc\Client;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Response
 *
 * @author wang
 */
use Witgame\Rpc\RpcException;
class Response {
    //put your code here
    
    /**
     * call_data
     * @var mix 
     */
    private  $call_data;


    /**
     * __construct
     * @param type $response_json
     * @throws RpcException
     */
    public function __construct($response_json) {
       $this->call_data  = json_decode($response_json, true);
       if($this->call_data === null){
           throw new RpcException($response_json, RpcException::HTTP_INTERNAL_SERVER_ERROR);
       }
       if($this->call_data['code'] != RpcException::HTTP_OK){
           throw new RpcException($this->call_data['msg'], $this->call_data['code']);
       }
    }
    
    /**
     * getData
     * @return mix
     */
    public function getData(){
        return $this->call_data['data'];
    }
    
    
}

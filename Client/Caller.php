<?php

namespace Witgame\Rpc\Client;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Request
 *
 * @author wang
 */
use Witgame\Rpc\RpcException;
use Witgame\Rpc\Client\UrlBuilderContract;
class Caller {
    //put your code here
    
    /**
     *$base_url
     * @var string 
     */
    private $base_url = '';
    
    /**
     *$namespace
     * @var string 
     */
    private $namespace = '';
    
    /**
     * $args
     * @var array
     */
    private $args = [];
    
    /**
     * UrlBuilderContract
     * @var UrlBuilderContract
     */
    private $urlContract = '';
    
    /**
     * host
     * @var sting
     */
    private $host = '';
    
    


    /**
     * __construct
     * @param type $base_url
     */
    public function __construct(UrlBuilderContract $urlContract, $base_url, $host = '') {
        $this->base_url = $base_url;
        $this->host = $host;
        $this->urlContract = $urlContract;
    }
    
    /**
     * set namespace
     * @param type $namespace
     */
    public function withNamespace($namespace){
        $this->namespace = $namespace;
        return $this;
    }
    
    /**
     * set Args
     * @param type $args
     * @return $this
     */
    public function withArgs(array $args){
        $this->args =  $args;
        return $this;
    }
    
    /**
     *  invoke
     * @param type $class
     * @param type $method
     */
    public function invoke($class, $method){
        $url = $this->base_url . $this->urlContract->buildCallUrl($this->namespace, $class, $method);
        return (new Response($this->post($url, $this->args)))->getData();
        
    }
    

    
    /**
     * 直接把data当做postfield的值传递
     * @param sting $url
     * @param string $data
     * @return type
     */
    public  function post($url, $data) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        if (strpos($this->base_url, 'https') === 0) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        }
        if($this->host){
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Host:' .$this->host]);
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3); // 连接超时（秒）
        curl_setopt($ch, CURLOPT_TIMEOUT, 4); // 执行超时（秒）
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    

        $outPut = curl_exec($ch);
        if(curl_errno($ch) !== 0 ){
            throw new RpcException('code[' .curl_errno($ch) . ']error:' . curl_error($ch) ,RpcException::HTTP_SERVICE_UNAVAILABLE);
        }
        curl_close($ch);

        return $outPut;
    }

}

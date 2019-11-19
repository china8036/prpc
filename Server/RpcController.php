<?php

namespace Witgame\Rpc\Server;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RpcController
 *
 * @author wang
 */
use Exception;
use Witgame\Rpc\RpcException;
trait RpcController {
    
    
    /**
     * 
     * @param type $key
     * @param string $default
     * @return type
     */
    public function getCallData($key, $default = ''){
        return $this->getPostData($key, $default);
    }
    
    /**
     * 处理异常 抛出rpcExcetpion
     * @param Exception $exception
     */
    public function handleException(Exception $exception) {
        // disable error capturing to avoid recursive errors
        restore_error_handler();
        restore_exception_handler();

        if (!$exception instanceof RpcException) {//Sytem Exception
            $this->responseException(RpcException::HTTP_INTERNAL_SERVER_ERROR, $exception->getCode() . '-' . $exception->getMessage());
        }
        $this->responseException($exception->getCode(), $exception->getMessage());
    }

    /**
     * 回复正常数据
     * @param int $code
     * @param array $data
     * @params RpcController 
     * @return null
     */
    protected function responseData($data = []) {
        $this->response(RpcException::HTTP_OK, '', $data);
    }

    /**
     * 回复异常
     * @param int $code
     * @param string $msg
     * @params RpcController 
     * @return null
     */
    protected function responseException($code, $msg) {
        $this->response($code, $msg);
    }

    /**
     * 回复数据
     * @param int $code
     * @param string $msg
     * @param array $data
     * @return null
     */
    protected function response($code, $msg = '', $data = []) {
        $r = array(
            'code' => $code,
            'msg' => $msg,
            'data' => $data,
        );
        header("content:application/json;chartset=uft-8");
        exit(json_encode($r));
    }

}

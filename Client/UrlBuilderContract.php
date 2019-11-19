<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Witgame\Rpc\Client;

/**
 * Description of Contract
 *
 * @author wang
 */
interface UrlBuilderContract {
    //put your code here
    
     public function buildCallUrl($namespace, $class, $method);
}

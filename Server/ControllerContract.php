<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Witgame\Rpc\Server;

/**
 * Description of Contract
 *
 * @author wang
 */
interface ControllerContract {
    //put your code here
    
     public function getPostData($key, $default = '');
}

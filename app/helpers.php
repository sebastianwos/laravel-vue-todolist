<?php
/**
 * Created by PhpStorm.
 * User: Sebastian
 * Date: 2016-07-04
 * Time: 08:49
 */


/**
 * Flash message to session
 * @param $message
 */
function flash($message){
    session()->flash('message', $message);
}
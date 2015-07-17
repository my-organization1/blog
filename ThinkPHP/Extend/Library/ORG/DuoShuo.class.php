<?php
class DuoShuo
{
    private $key = '';

    public function __construct()
    {
        $this->key = !empty(C('DUOSHUO_KEY')) ? C('DUOSHUO_KEY') : $key;
    }

    public function getCount()
    {

    }
}
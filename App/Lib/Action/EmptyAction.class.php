<?php

class EmptyAction extends BaseAction
{
    public function _empty()
    {
        dump($_GET);
    }
}

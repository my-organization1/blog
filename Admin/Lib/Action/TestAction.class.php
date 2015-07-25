<?php

class TestAction extends Action
{
    function index()
    {
        D('Router')->getInsId();
    }
}
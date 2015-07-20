<?php

class TestAction extends Action
{
    function index()
    {
        echo PinYin::encode('php教程','all');
    }
}
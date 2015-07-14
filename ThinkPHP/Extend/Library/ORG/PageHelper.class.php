<?php
class PageHelper
{
    private $page = 1;      //当前页
    private $page_size = 10;    //每页条数
    private $page_roll = 5;     //显示页数
    private $theme_first = '第一页';
    private $theme_prev = '上一页';
    private $theme_next = '下一页';
    private $theme_last = '最后一页';


    public function __construct($total, $page = 1, $page_size = 10, $page_roll = 5)
    {
        $this->page = $page;
        $this->total = $total;
        $this->page_size = $page_size;
        $this->page_roll = $page_roll;
    }

    public function show()
    {
        $page_list = array();
        $page_total = ceil($this->total/$this->page_size);


        //将首页写入数组
        $page_first['name'] = $this->theme_first;
        $page_first['page'] = 1;
        array_push($page_list, $page_first);

        //将第一页写入数组
        $page_prev['name'] = $this->theme_prev;
        $page_prev['page'] = '-1';
        array_push($page_list, $page_prev);


        for ($i=1; $i<=$page_total; $i++) {
            $page['name'] = $i;
            $page['page'] = $i;
            array_push($page_list, $page);
            if (count($page_list)-2 == $this->page_roll) {
                break;
            }
        }

        //将下一页写入数组
        $page_next['name'] = $this->theme_next;
        $page_next['page'] = '+1';
        array_push($page_list, $page_next);

        //将最后一页写入数组
        $page_last['name'] = $this->theme_last;
        $page_last['page'] = $page_total;
        array_push($page_list, $page_last);

        return $page_list;
    }

    public function setTheme($name, $val)
    {
        $this->$name = $val;
    }
}

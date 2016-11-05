<?php
/*
* @Created by: DUY NGUYEN
* @Author	 : nguyenduypt86@gmail.com
* @Date 	 : 01/2016
*/

class BaseSiteController extends BaseController{
    protected $layout = 'site.BaseLayouts.index';
    public function __construct(){
       //Init
    }

    public function header(){
        $this->layout->header = View::make("site.BaseLayouts.header");
    }

    public function footer(){
        $this->layout->footer = View::make("site.BaseLayouts.footer");
    }
}
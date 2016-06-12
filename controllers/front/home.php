<?php
/**
 * Created by PhpStorm.
 * User: Whuan
 * Date: 16-5-27
 * Time: 上午11:17
 */

class RyhomeHomeModuleFrontController extends ModuleFrontController
{
    public function init()
    {
        $this->name = 'home';

        parent::init();
    }
    public function initContent()
    {
        // Disable header and footer
        $this->display_header = false;
        $this->display_footer = false;
        // Disable left and right column
        $this->display_column_left = false;
        $this->display_column_right = false;

        parent::initContent();


        $this->context->smarty->assign(array('base_directory'=>"/modules/".$this->module->name."/views",'allCategory'=>array(),'allslider'=>array()));
        $this->setTemplate('home.tpl');
    }
}
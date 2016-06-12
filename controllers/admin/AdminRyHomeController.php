<?php

require_once(dirname(__FILE__).'/../../models/HomeSliders.php');
require_once(dirname(__FILE__).'/../../models/HomeMenu.php');
require_once(dirname(__FILE__).'/../../models/HomeFloors.php');

class AdminRyHomeController extends ModuleAdminController
{
    public function __construct()
    {
        $this->bootstrap = true;
        $this->context = Context::getContext();

        $this->show_page_header_toolbar = true;
        $this->page_header_toolbar_title = "聚合页配置";

        parent::__construct();
    }
    public function init()
    {
        if (Tools::isSubmit('addhome_slider') || Tools::isSubmit('updatehome_slider')){
            $this->table = 'home_slider';
            $this->className = 'HomeSliders';
            $this->identifier = 'id_home_slider';
            $this->display = 'edit';
        }
        if (Tools::isSubmit('addhome_menu') || Tools::isSubmit('updatehome_menu')){
            $this->table = 'home_menu';
            $this->className = 'HomeMenus';
            $this->identifier = 'id_home_menu';
            $this->display = 'edit';
        }
        if (Tools::isSubmit('addhome_floor') || Tools::isSubmit('updatehome_floor')){
            $this->table = 'home_floor';
            $this->className = 'HomeFloors';
            $this->identifier = 'id_home_floor';
            $this->display = 'edit';
        }
        parent::init();
    }
    public function postProcess()
    {
        $error = array();
        $this->_postProcessMenu();
        $this->_postProcessSlider();
        $this->_postProcessFloor();
        if(Tools::getValue('action') == 'updatePositions'){
            if(Tools::getIsset('home_menu')){
                $this->ajaxProcessUpdatePositions('home_menu','HomeMenus');
            }
            if(Tools::getIsset('home_slider')){
                $this->ajaxProcessUpdatePositions('home_slider','HomeSliders');
            }
            if(Tools::getIsset('home_floor')){
                $this->ajaxProcessUpdatePositions('home_floor','HomeFloors');
            }
        }
        if (Tools::isSubmit('saveConfirmation')){
            $this->confirmations[] = 'Added successfully';
        }
        if (Tools::isSubmit('deleteConfirmation')){
            $this->confirmations[] = 'Deleted successfully';
        }
        $this->errors = $error;
        parent::postProcess();


    }
    public function _postProcessMenu()
    {
        $menu = new HomeMenus(Tools::getValue("id_home_menu"));
        if(Tools::isSubmit('submitAddHomeMenu')){
            $menu->copyFromPost();
            $errors = $menu->validateController();
            if (sizeof($errors)) {
                $error[] = $errors;
            }else {
                Tools::getValue('id_home_menu') ? $menu->update() : $menu->add();
                Tools::redirectAdmin($this->context->link->getAdminLink('AdminRyHome', false).'&token='.Tools::getAdminTokenLite('AdminRyHome').'&saveConfirmation');
            }
        }
        if (Tools::isSubmit('deletehome_menu') && Tools::getValue('id_home_menu'))
        {
            $menu->delete();
            Tools::redirectAdmin($this->context->link->getAdminLink('AdminRyHome', false).'&token='.Tools::getAdminTokenLite('AdminRyHome').'&deleteConfirmation');
        }
        if(Tools::isSubmit('statushome_menu')){
            $menu->updateStatus($menu->display);
        }
    }
    public function _postProcessSlider()
    {
        $slider = new HomeSliders(Tools::getValue("id_home_slider"));
        if(Tools::isSubmit('submitAddHomeSlider')){
            $slider->copyFromPost();
            $errors = $slider->validateController();
            if (sizeof($errors)) {
                $error[] = $errors;
            }else {
                Tools::getValue('id_home_slider') ? $slider->update() : $slider->add();
                Tools::redirectAdmin($this->context->link->getAdminLink('AdminRyHome', false).'&token='.Tools::getAdminTokenLite('AdminRyHome').'&saveConfirmation');
            }
        }
        if (Tools::isSubmit('deletehome_slider') && Tools::getValue('id_home_slider'))
        {
            $slider->delete();
            Tools::redirectAdmin($this->context->link->getAdminLink('AdminRyHome', false).'&token='.Tools::getAdminTokenLite('AdminRyHome').'&deleteConfirmation');
        }
        if(Tools::isSubmit('statushome_slider')){
            $slider->updateStatus($slider->display);
        }

    }
    public function _postProcessFloor()
    {

    }
    /**
     * AdminController::renderForm() override
     * @see AdminController::renderForm()
     */
    public function renderForm()
    {
        if (!($obj = $this->loadObject(true)))
            return;

        $this->fields_form = array('');
        if(Tools::isSubmit('addhome_menu') || Tools::isSubmit('updatehome_menu')){
            $this->tpl_form_vars = array(
                'menu' => $obj,
                'admin_link' => $this->context->link->getAdminLink('AdminRyHome')
            );
        }
        if(Tools::isSubmit('addhome_slider') || Tools::isSubmit('updatehome_slider')){
            $this->tpl_form_vars = array(
                'slider' => $obj,
                'admin_link' => $this->context->link->getAdminLink('AdminRyHome')
            );
        }
        if(Tools::isSubmit('addhome_floor') || Tools::isSubmit('updatehome_floor')){
            $this->tpl_form_vars = array(
                'floor' => $obj,
                'admin_link' => $this->context->link->getAdminLink('AdminRyHome')
            );
        }
        return parent::renderForm();
    }
    /**
     * AdminController::renderList() override
     * @see AdminController::renderList()
     */
    public function renderList()
    {
        /**
         * First list
         * Home Slider List
         */
        $first_list = null;
        // generates a list of the first

        $first_list = $this->initHomeMenuList();
        $second_list = $this->initHomeSliderList();
        $third_list = $this->initHomeFloorList();
        return $first_list.$second_list.$third_list;
    }
    public function initHomeMenuList()
    {
        $this->table = 'home_menu';
        $this->className = 'HomeMenus';
        $this->identifier = 'id_home_menu';
        $this->position_identifier = 'id_home_menu';
        $this->lang = false;
        $this->_orderBy = null;
        $this->_defaultOrderBy = 'position';
        $this->bootstrap = true;
        $this->toolbar_title = $this->l('导航: 聚合页顶部导航');
        $this->deleted = false;
        $this->display = 'list';
        $this->initToolbar();


        $this->fields_list = array(
            'id_home_menu' => array(
                'title' => '编号',
                'width' => 100,
                'align' => 'text-center',
                'filter_key' => 'a!id_home_menu',
                'search' => false
            ),
            'title' => array(
                'title' => '名称',
                'align' => 'text-center',
                'filter_key' => 'title',
                'orderby' => false,
                'filter' => false,
                'search' => false
            ),
            'position' => array(
                'title' => '位置',
                'align' => 'text-center',
                'class' => 'pointer',
                'position' => 'position',
                'filter_key' => 'a!position',
            ),
            'display' => array(
                'title' => '启用',
                'align' => 'text-center',
                'class' => 'fixed-width-xs',
                'active' => 'status',
                'type' => 'bool',
                'orderby' => false,
                'filter_key' => 'a!display'
            ),
        );
        return parent::renderList();
    }
    public function initHomeSliderList()
    {
        $this->table = 'home_slider';
        $this->className = 'HomeSliders';
        $this->identifier = 'id_'.$this->table;
        $this->position_identifier = 'id_home_slider';
        $this->lang = false;
        $this->_orderBy = null;
        $this->_defaultOrderBy = 'position';
        $this->bootstrap = true;
        $this->toolbar_title = $this->l('幻灯: 聚合页幻灯列表');

        $this->deleted = false;
        $this->display = 'list';
        $this->initToolbar();
        $this->addRowAction('edit');
        $this->addRowAction('delete');

        $this->fields_list = array(
            'id_home_slider' => array(
                'title' => '编号',
                'width' => 100,
                'align' => 'text-center',
                'filter_key' => 'a!id_home_slider',
                'search' => false
            ),
            'image' => array(
                'title' => '图片',
                'align' => 'text-center',
                'callback' => 'getSliderThumbs',
                'orderby' => false,
                'filter' => false,
                'search' => false
            ),
            'position' => array(
                'title' => '位置',
                'align' => 'text-center',
                'class' => 'pointer',
                'position' => 'position',
                'filter_key' => 'a!position',
            ),
            'display' => array(
                'title' => '启用',
                'align' => 'text-center',
                'class' => 'fixed-width-xs',
                'active' => 'status',
                'type' => 'bool',
                'orderby' => false,
                'filter_key' => 'a!display'
            ),
        );

        return parent::renderList();
    }
    public function initHomeFloorList()
    {
        $this->table = 'home_floor';
        $this->className = 'HomeFloors';
        $this->identifier = 'id_'.$this->table;
        $this->position_identifier = 'id_home_floor';
        $this->lang = false;
        $this->_orderBy = null;
        $this->_defaultOrderBy = 'position';
        $this->bootstrap = true;
        $this->toolbar_title = $this->l('幻灯: 聚合页楼层');

        $this->deleted = false;
        $this->display = 'list';
        $this->initToolbar();
        $this->addRowAction('edit');
        $this->addRowAction('delete');

        $this->fields_list = array(
            'id_home_floor' => array(
                'title' => '编号',
                'width' => 100,
                'align' => 'text-center',
                'filter_key' => 'a!id_home_floor',
                'search' => false
            ),
            'title' => array(
                'title' => '名称',
                'align' => 'text-center',
                'filter_key' => 'title',
                'orderby' => false,
                'filter' => false,
                'search' => false
            ),
            'position' => array(
                'title' => '位置',
                'align' => 'text-center',
                'class' => 'pointer',
                'position' => 'position',
                'filter_key' => 'a!position',
            ),
            'display' => array(
                'title' => '启用',
                'align' => 'text-center',
                'class' => 'fixed-width-xs',
                'active' => 'status',
                'type' => 'bool',
                'orderby' => false,
                'filter_key' => 'a!display'
            ),
        );

        return parent::renderList();
    }
    public function getSliderThumbs($vaule,$slider){
        return "<img src='/modules/ryhome/views/img/slider/thumbs/slider_".$slider['id_home_slider'].".jpg' alt='' class='imgm img-thumbnail' style='height:40px'>";
    }
    public function ajaxProcessUpdatePositions($p,$class)
    {

        $positions = Tools::getValue($p);
        $page = (int)Tools::getValue('page');
        $selected_pagination = (int)Tools::getValue('selected_pagination');

        if (is_array($positions)) {
            foreach ($positions as $position => $value) {
                $pos = explode('_', $value);
                if (isset($pos[2])) {
                    if ($page > 1) {
                        $position = $position + (($page - 1) * $selected_pagination);
                    }
                    if ($c = new $class((int)$pos[2])) {
                        if (isset($pos[2]) ) {
                            $c->updatePosition($position,$pos[2]);
                        }
                    }
                }
            }
        }
    }
}
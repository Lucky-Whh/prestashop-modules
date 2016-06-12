<?php

if (!defined('_PS_VERSION_'))
    exit;

class RyHome extends Module
{
    public function __construct()
    {
        $this->name = 'ryhome';
        $this->tab = 'others';
        $this->version = '1.0';
        $this->author = 'Rongyao Dev Team';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = 'RongYao Home';
        $this->description = 'RongYao Home Module';

        $this->confirmUninstall = $this->l('Are you sure you want to delete this module ?');
    }
    public function install()
    {
        // Install SQL
        $sql = array();
        include(dirname(__FILE__) . '/sql/install.php');
        foreach ($sql as $s)
            if (!Db::getInstance()->execute($s))
                return false;

        return parent::install() && $this->installTab() && $this->registerHook('moduleRoutes');
    }
    public function uninstall()
    {
        // Uninstall SQL
        $sql = array();
        include(dirname(__FILE__) . '/sql/uninstall.php');
        foreach ($sql as $s)
            if (!Db::getInstance()->execute($s))
                return false;

        return parent::uninstall() && $this->unregisterHook('moduleRoutes') && $this->uninstallTab();
    }
    private function installTab()
    {
        $tab = new Tab();
        $tab->id_parent = (int)Tab::getIdFromClassName("AdminPreferences");
        $tab->name = array();
        foreach(Language::getLanguage(true) as $lang){
            $tab->name[$lang['id_lang']] = '聚合页配置';
        }
        $tab->class_name = 'AdminRyHome';
        $tab->module = $this->name;
        $tab->active = 1;

        return $tab->add();
    }
    private function uninstallTab()
    {
        $id_tab = (int)Tab::getIdFromClassName('AdminRyHome');
        $tab = new Tab($id_tab);

        return $tab->delete();
    }

}
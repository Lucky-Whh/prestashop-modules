<?php
/**
 * Created by PhpStorm.
 * User: Whuan
 * Date: 16-6-9
 * Time: 上午8:42
 */
class HomeMenus extends ObjectModel
{
    public $id_home_menu;
    public $title;
    public $position;
    public $url;
    public $display;
    public $temp_url = "{home_menu_url}";
    /**
     * @see ObjectModel::$definition
     */
    public static $definition = array(
        'table' => 'home_menu',
        'primary' => 'id_home_menu',
        'fields' => array(
            'title'         => 		array('type' => self::TYPE_HTML, 'validate' => 'isString'),
            'url'               => 	    array('type' => self::TYPE_STRING, 'validate' => 'isString', 'size' => 255),
            'position'          => 		array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt'),
            'display'           => 	    array('type' => self::TYPE_INT, 'validate' => 'isBool', 'required' => true)
        ),
    );

    /**
     * Build an home_menu
     *
     * @param integer $id_home_menu Existing home_menu_id to load object (optional)
     */
    public	function __construct($id_home_menu = null, $id_lang = null)
    {
        parent::__construct($id_home_menu, $id_lang);
        if ($this->id)
        {
            $this->title = $this->getField('title');
            $this->position = $this->getField('position');
            $this->display = $this->getField('display');
            $this->url = $this->getField('url');
            $languages = Language::getLanguages(false);
            foreach ($languages as $language)
            {
                if (isset($this->url))
                {
                    $temp = str_replace($this->temp_url, _PS_BASE_URL_.__PS_BASE_URI__, $this->url);
                    $this->url = $temp;
                }
            }
        }
    }
    public function updateStatus($status)
    {
        if (!isset($status))
            return false;
        if($status == 0)
            $status = 1;
        else
            $status = 0;
        $result = (Db::getInstance()->Execute('
			UPDATE `'._DB_PREFIX_.'home_menu`
			SET `display`='.$status.'
			WHERE `id_home_menu`='.(int)($this->id_home_menu)));
        return $result;
    }
    public function getField($field)
    {
        $sql = 'SELECT '.$field.' FROM '._DB_PREFIX_.'home_menu hm
		WHERE hm.id_home_menu = '.$this->id.'';
        $position = Db::getInstance()->getValue($sql);
        return $position;
    }
    public function add($autodate = true, $null_values = false)
    {
        parent::add($autodate, $null_values);
        $this->updatePositionMax();
    }
    public function update($null_values = false)
    {
        parent::update($null_values);
    }
    public function delete($autodate = true, $null_values = false)
    {
        parent::delete($autodate, true);
    }
    public function updatePositionMax()
    {
        $result = (Db::getInstance()->Execute('
					UPDATE `'._DB_PREFIX_.'home_menu`
					SET `position`='.$this->getNextPosition().'
					WHERE `id_home_menu`='.(int)($this->id)));
        return $result;
    }

    public static function getNextPosition()
    {
        $max = Db::getInstance()->getValue('SELECT MAX(position)+1 FROM `'._DB_PREFIX_.'home_menu`');
        return ($max ? $max : 0);
    }
    public function copyFromPost()
    {
        $this->title=Tools::getValue('title');
        $this->url = Tools::getValue('url_1');
        $this->display=Tools::getValue('display');
    }
    public function updatePosition($position,$moved_id)
    {
        $query = 'UPDATE `'._DB_PREFIX_.'home_menu`
			SET `position` = '.(int)$position.'
			WHERE `id_home_menu` = '.(int)$moved_id;

        Db::getInstance()->execute($query);
    }
}
<?php

class HomeFloors extends ObjectModel {

    public $id_home_floor;

    public $animation;
    public $url;
    public $position;
    public $type;
    public $display;
    public $temp_url = "{home_floor_url}";
    private $max_image_size = 8388608;
    /**
     * @see ObjectModel::$definition
     */
    public static $definition = array(
        'table' => 'home_floor',
        'primary' => 'id_home_floor',
        'fields' => array(
            'title'           => 	array('type' => self::TYPE_HTML, 'validate' => 'isString'),
            'animation'       => 	array('type' => self::TYPE_HTML, 'validate' => 'isString'),
            'url'             => 	array('type' => self::TYPE_STRING, 'validate' => 'isString', 'size' => 255),
            'type'            =>    array('type' => self::TYPE_STRING),
            'position'        =>    array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt'),
            'display'         => 	array('type' => self::TYPE_INT, 'validate' => 'isBool', 'required' => true)
        ),
    );

    /**
     * Build an home_floor
     *
     */
    public	function __construct($id_tab = null, $id_lang = null, $id_shop = null)
    {
        parent::__construct($id_tab, $id_lang, $id_shop);
        if ($this->id)
        {
            $this->animation = $this->getField('animation');
            $this->title = $this->getField('title');
            $this->url = $this->getField('url');
            $this->type = $this->getField('type');
            $this->position = $this->getField('position');
            $this->display = $this->getField('display');
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
        $this->animation = Tools::jsonDecode($this->animation);
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
			UPDATE `'._DB_PREFIX_.'home_floor`
			SET `display`='.$status.'
			WHERE `id_home_floor`='.(int)($this->id_home_floor)));
        return $result;
    }
    public function getField($field)
    {
        $sql = 'SELECT '.$field.' FROM '._DB_PREFIX_.'home_floor hs
		WHERE hs.id_home_floor = '.$this->id.'';
        $position = Db::getInstance()->getValue($sql);
        return $position;
    }
    public function add($autodate = true, $null_values = false)
    {
        parent::add($autodate, $null_values);
        $this->updatePositionMax();
        $this->updateInforImage();
    }
    public function update($null_values = false)
    {
        parent::update($null_values);
        $this->updateInforImage();
    }
    public function delete($autodate = true, $null_values = false)
    {
        parent::delete($autodate, true);
        $image = $this->image;
        if(file_exists(_PS_MODULE_DIR_.'ryhome/views/img/floor/'.$image->value)){
            unlink(_PS_MODULE_DIR_.'ryhome/views/img/floor/'.$image->value);
        }
        if(file_exists(_PS_MODULE_DIR_.'ryhome/views/img/floor/thumbs/'.$image->value)){
            unlink(_PS_MODULE_DIR_.'ryhome/views/img/floor/thumbs/'.$image->value);
        }
    }
    public function updatePositionMax()
    {
        $result = (Db::getInstance()->Execute('
					UPDATE `'._DB_PREFIX_.'home_floor`
					SET `position`='.$this->getNextPosition().'
					WHERE `id_home_floor`='.(int)($this->id)));
        return $result;
    }

    public static function getNextPosition()
    {
        $max = Db::getInstance()->getValue('SELECT MAX(position)+1 FROM `'._DB_PREFIX_.'home_floor`');
        return ($max ? $max : 0);
    }

    public function updateInforImage()
    {
        $return=true;
        $floor_update = Db::getInstance()->getRow(
            'SELECT * FROM `'._DB_PREFIX_.'home_floor`
					WHERE `id_home_floor` = '.(int)($this->id));
        $image = Tools::jsonDecode($floor_update['image']);
        $new_name = 'floor_'.$this->id.'.jpg';
        if($new_name != $image->value)
        {
            $new_image = Tools::jsonEncode(array("type"=>$image->type,"value"=>$new_name));
            copy(_PS_MODULE_DIR_.'ryhome/views/img/floor/'.$image->value,_PS_MODULE_DIR_.'ryhome/views/img/floor/'.$new_name);
            copy(_PS_MODULE_DIR_.'ryhome/views/img/floor/'.$image->value,_PS_MODULE_DIR_.'ryhome/views/img/floor/thumbs/'.$new_name);
            $sql = 'UPDATE `'._DB_PREFIX_.'home_floor`
					SET `image` = \''.$new_image.'\'
					WHERE `id_home_floor` = '.(int)($this->id);
            $return &= Db::getInstance()->Execute($sql);

            if(file_exists(_PS_MODULE_DIR_.'ryhome/views/img/floor/'.$image->value))
                unlink(_PS_MODULE_DIR_.'ryhome/views/img/floor/'.$image->value);
            if(file_exists(_PS_MODULE_DIR_.'ryhome/views/img/floor/thumbs/'.$image->value))
                unlink(_PS_MODULE_DIR_.'ryhome/views/img/floor/thumbs/'.$image->value);
        }

        return $return;
    }

    public function copyFromPost()
    {
        $image_post=Tools::getValue('image');
        $imagehidden=Tools::getValue('imagehidden');

        if($image_post['type'] == "image")
        {
            if(Tools::getIsset('imagehidden') && $imagehidden!= '' && $_FILES['image']['name']['value'] == "")
            {
                $arr = array("type"=>$image_post['type'],"value"=>$imagehidden);
            }
            else if ($dot_pos = strrpos($_FILES['image']['name']['value'],'.'))
            {
                $ext = Tools::substr($_FILES['image']['name']['value'], $dot_pos+1);
                $newname = 'floor_'.($this->id ? $this->id : $this->getNextId());
                $newname .= '.'.$ext;
                $arr = array("type"=>$image_post['type'],"value"=>$newname);
            }
            $value_img = Tools::jsonEncode($arr);

        }
        else
        {
            $value_img = Tools::jsonEncode($image_post);
        }
        $this->image=$value_img;

        $animation = Tools::getValue('animation');
        $this->animation=Tools::jsonEncode($animation);
        $this->url = Tools::getValue('url_1');
        $this->type = Tools::getValue('type');
        $this->display=Tools::getValue('display');

    }

    public function uploadImage($id_home_floor = null)
    {
        $errors = "";
        if (isset($_FILES['image']) AND isset($_FILES['image']['tmp_name']) AND !empty($_FILES['image']['tmp_name']))
        {
            if ($dot_pos = strrpos($_FILES['image']['name']['value'],'.'))
            {
                $ext = Tools::substr($_FILES['image']['name']['value'], $dot_pos+1);
                $newname = 'floor_'.($id_home_floor ? $id_home_floor : $this->getNextId());

                if($id_home_floor){

                    ImageManager::resize($_FILES['image']['tmp_name']['value'],_PS_MODULE_DIR_.'ryhome/views/img/floor/'.$newname.'.'.$ext);
                    ImageManager::resize($_FILES['image']['tmp_name']['value'], _PS_MODULE_DIR_.'ryhome/views/img/floor/thumbs/'.$newname.'.'.$ext, 200, 45);

                }else{
                    if (!move_uploaded_file($_FILES['image']['tmp_name']['value'],_PS_MODULE_DIR_.'ryhome/views/img/floor/'.$newname.'.'.$ext) && !move_uploaded_file($_FILES['image']['tmp_name']['value'],_PS_MODULE_DIR_.'ryhome/views/img/floor/thumbs/'.$newname.'.'.$ext))
                    {
                        $errors .= Tools::displayError('Error move uploaded file');
                    }
                    else
                    {
                        ImageManager::resize(_PS_MODULE_DIR_.'ryhome/views/img/floor/'.$newname.'.'.$ext, _PS_MODULE_DIR_.'ryhome/views/img/floor/thumbs/'.$newname.'.'.$ext, 200, 45);
                    }
                }

            }
        }
        return ($errors != "" ? $errors : false);
    }

    public function validateController($htmlentities = true, $copy_post = false)
    {
        $errors = array();
        $temp_img = Tools::getValue('image');
        $temp_imagehidden = Tools::getValue('imagehidden');
        if($temp_img['type'] == "image")
        {
            if($_FILES['image']['name']['value'] == '' && !isset($temp_imagehidden))
            {
                $errors[] = Tools::displayError('Image is empty.');
                return $errors;
            }
            if($error = $this->uploadImage($this->id_home_floor))
            {
                $errors[] = $error;
                return $errors;
            }

        }
        return $errors;
    }

    public static function getNextId()
    {
        $max = Db::getInstance()->getValue('SELECT MAX(id_home_floor) FROM `'._DB_PREFIX_.'home_floor`');
        return ($max ? $max + 1 : 1);
    }
    public function getAllFloors(){
        return Db::getInstance()->getRow(
            'SELECT * FROM `'._DB_PREFIX_.'home_floor`');
    }
    /**
     * @param boolean $way Up (1)  or Down (0)
     * @param integer $position
     * return boolean Update result
     */
    public function updatePosition($position,$moved_id)
    {
        $query = 'UPDATE `'._DB_PREFIX_.'home_floor`
			SET `position` = '.(int)$position.'
			WHERE `id_home_floor` = '.(int)$moved_id;

        Db::getInstance()->execute($query);
    }
}
<?php

class CForm_Gallery
{

    public $ci = NULL;

    public $name = '';

    public $field = NULL;

    public function __construct($name, $field = []) {

        $this->form =& get_instance();
        $this->form = $this->form->load->module('forms');

        $this->name = $name;
        $this->field = (object) $field;

        return $this;
    }

    public function render() {

        $this->field->html = $this->renderHtml();
        $result = $this->form->standartRender($this->name, $this->field);
        return $result;
    }

    public function setInitial($data) {

        $this->field->initial = $data;
    }

    public function setAttributes($data) {

        $this->field->initial = $data;
    }

    public function getData() {

        if (isset($_POST[$this->name])) {
            return $_POST[$this->name];
        }
    }

    public function runValidation() {

        if ($this->field->validation) {
            $this->form->form_validation->set_rules($this->name, $this->field->label, $this->field->validation);
        }
        if ($this->form->form_validation->run($this->ci) == FALSE) {
            return form_error($this->name, ' ', ' ');
        } else {
            return FALSE;
        }
    }

    public function renderHtml() {
        $html='';
if (htmlspecialchars($this->field->initial)!=''){
    
    $ar=explode(',',$this->field->initial);
    $im=0;
    foreach ($ar as $image){
        if (stristr($image,'smartfieldsdata')){
           $image=$image; 
        } else {
           $image='/uploads/multiimage/'.$image; 
        };
        $html.='<div class="gal_cont" id="im'.$im.'" onclick="naher(\''.$im.'\')" data-file="'.$image.'"><span class="close"></span><img src="'.$image.'"  ></div>';
        $im++;
    }
    
}

$html.='
<link href="/templates/administrator/mif/styles.imageuploader.css" rel="stylesheet" type="text/css">

<section role="main" class="l-main" >
   
        <div class="uploader__box js-uploader__box l-center-box">
            <form action="your/nonjs/fallback/" method="POST">
                <div class="uploader__contents">
                    <label class="button button--secondary" for="fileinput">Выберите файлы</label>
                    <input id="fileinput" class="uploader__file-input" type="file" multiple value="Выбрать файлы">
                </div>
                <input class="button button--big-bottom" type="submit" value="Загрузить выбранные">
            </form>
        </div>
    </section>

<script src="/templates/administrator/mif/jquery.imageuploader.js"></script>
<script>
(function(){
            var options = {};
            $(".js-uploader__box").uploader(options);
        }());
</script>';
$html.='<input type="hidden" '.$this->form->_check_attr($this->name, $this->field).' value="'.htmlspecialchars($this->field->initial).'" />';
        return $html;
    }

}
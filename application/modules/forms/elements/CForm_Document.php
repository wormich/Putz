<?php

class CForm_Document
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

        //$this->field->html = $this->renderHtml();
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
        return '<div class="f-dock"><div class="frmss"><div class="new-oh">
                <div class="group_icon pull-right">
                <span onclick="dels($(this))" class="btn deldock">Удалить</span>
                                                <a href="/application/third_party/filemanager/dialog.php?type=2&amp;field_id='.$this->name.'1" class="btn iframe-btn" type="button">
                                                    <i class="icon-picture"></i>
                                                    Выберите файл                                                </a>
                                        </div>
          <input type="text" onchange="ch($(this))" class="docinp" name='.$this->name.'1 id="'.$this->name.'1" value="" /> 
          <input type="text" onchange="ch($(this))" class="docname" value="" placeholder="Альтернативное имя" />
          </div>  
          
          </div>
        <div class="adds">
          <span class="btn">Добавить</span>    
          </div>                       
        <input type="hidden" class="docinplast" '.$this->form->_check_attr($this->name, $this->field).' value="'.htmlspecialchars($this->field->initial).'" /></div>';
    }

}
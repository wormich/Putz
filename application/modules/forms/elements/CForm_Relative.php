<?php

class CForm_Relative
{

    public $ci = null;

    public $name = '';

    public $field = null;

    public function __construct($name, $field = [])
    {

        $this->form = &get_instance();
        $this->form = $this->form->load->module('forms');

        $this->name = $name;
        $this->field = (object)$field;

        return $this;
    }

    public function render()
    {

        $this->field->html = $this->renderHtml();
        $result = $this->form->standartRender($this->name, $this->field);
        return $result;
    }

    public function setInitial($data)
    {

        $this->field->initial = $data;
    }

    public function setAttributes($data)
    {

        $this->field->selected = $data;
    }

    public function getData()
    {

        if (isset($_POST[$this->name])) {
            return $_POST[$this->name];
        }
    }

    public function runValidation()
    {


        return false;

    }

    public function renderHtml()
    {

        $name = $this->name;
        if (is_string($this->field->initial)) {
            
            $this->field->initial = explode("\n", $this->field->initial);
            
        }

        $this->CI = &get_instance();



            $xt = array();
            $item=array();

   foreach($this->field->initial as $oneh){  
                $this->CI->db->where('category =', $oneh); 
              $q = $this->CI->db->get('content');
               foreach ($q->result_array() as $rowfi) {

                $xt[$rowfi['id']] = $rowfi['title'];

            };
            foreach (get_sub_categories($oneh) as $row){
                if ($row['id']!=null){
                    
            $this->CI->db->where('category =', $row["id"]); 
              $q = $this->CI->db->get('content');
               foreach ($q->result_array() as $row) {

                $xt[$row['id']] = $row['title'];

            };
             foreach (get_sub_categories($row['id']) as $rows){
                            $this->CI->db->where('category =', $rows["id"]); 
              $q = $this->CI->db->get('content');
               foreach ($q->result_array() as $rows) {
                $xt[$rows['id']] = $rows['title'];
            };
                         foreach (get_sub_categories($rows['id']) as $rowss){
                            $this->CI->db->where('category =', $rowss["id"]); 
              $q = $this->CI->db->get('content');
               foreach ($q->result_array() as $rowss) {
                $xt[$rowss['id']] = $rowss['title'];
            };
                };
                };
           };
           };
           };



        if (!isset($this->field->selected)) {
            $this->field->selected = [];
        }

        $multiple = 'multiple="multiple"';
        $name .= '[]';


        $select = '<select ' . $this->form->_check_attr($name, $this->field) . ' ' . $multiple .
            '>';

        if (isset($xt) and count($xt)) {
            foreach ($xt as $key => $val) {
                $selected = '';
                
                  foreach ($this->field->selected as $s_key => $s_val) {
                        if ($s_val == $key) {
                            $selected = 'selected="selected"';
                        }
                        }

                $select .= '<option value="' . $key . '" ' . $selected . '>' . trim($val) .
                    '</option>';

            }
        }

      return $select . '</select>';
    }

}

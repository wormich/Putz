<?php

use cmsemail\email;

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Image CMS
 *
 * Feedback module
 */
class Feedback extends MY_Controller
{

    public $username_max_len = 30;

    public $message_max_len = 600;

    public $theme_max_len = 150;

    public $admin_mail = 'admin@localhost';

    public $message = '';

    protected $formErrors = [];

    public function __construct()
    {
        parent::__construct();
        $this->load->module('core');
        $this->load_settings();

        $this->formErrors = ['required' => lang('Field is required'), 'min_length' =>
            lang('Length is less than the minimum'), 'valid_email' => lang('Email is not valid'),
            'max_length' => lang('Length greater than the maximum'), ];
        $lang = new MY_Lang();
        $lang->load('feedback');
    }

    public function autoload()
    {

    }

    public function captcha_check($code)
    {
        if (!$this->dx_auth->captcha_check($code)) {
            return false;
        } else {
            return true;
        }
    }

    public function recaptcha_check()
    {
        $result = $this->dx_auth->is_recaptcha_match();
        if (!$result) {
            $this->form_validation->set_message('recaptcha_check', lang('Improper protection code',
                'feedback'));
        }

        return $result;
    }

    // Index function

    public function index()
    {
        $this->template->registerMeta('ROBOTS', 'NOINDEX, NOFOLLOW');

        $this->core->set_meta_tags(lang('Feedback', 'feedback'));

        $this->load->library('form_validation');

        // Create captcha
        $this->dx_auth->captcha();
        $tpl_data['cap_image'] = $this->dx_auth->get_captcha_image();

        $this->template->add_array($tpl_data);

        if (count($this->input->post()) > 0) {
            $this->form_validation->set_rules('name', lang('Your name', 'feedback'),
                'trim|required|min_length[3]|max_length[' . $this->username_max_len .
                ']|xss_clean');
            $this->form_validation->set_rules('email', lang('Email', 'feedback'),
                'trim|required|valid_email|xss_clean');
            $this->form_validation->set_rules('theme', lang('Subject', 'feedback'),
                'trim|max_length[' . $this->theme_max_len . ']|xss_clean');
            $this->form_validation->set_rules('message', lang('Message', 'feedback'),
                'trim|required|max_length[' . $this->message_max_len . ']|xss_clean');

            if ($this->dx_auth->use_recaptcha) {
                $this->form_validation->set_rules('recaptcha_response_field', lang('Protection code',
                    'feedback'), 'trim|xss_clean|required|callback_recaptcha_check');
            } else {
                $this->form_validation->set_rules('captcha', lang('Protection code', 'feedback'),
                    'trim|required|xss_clean|callback_captcha_check');
            }

            if ($this->form_validation->run($this) == false) { // there are errors
                $this->form_validation->set_error_delimiters('', '');
                CMSFactory\assetManager::create()->setData('validation', $this->form_validation);
                form_error();
            } else { // form is validate

                $feedback_variables = ['Theme' => $this->input->post('theme'), 'userName' => $this->
                    input->post('name'), 'userEmail' => $this->input->post('email'), 'userMessage' =>
                    $this->input->post('message'), ];
                email::getInstance()->sendEmail($this->input->post('email'), 'feedback', $feedback_variables);
                CMSFactory\assetManager::create()->appendData('message_sent', true);

            }
        }

        CMSFactory\assetManager::create()->render('feedback');
    }

    private function load_settings()
    {
        $this->db->limit(1);
        $this->db->where('name', 'feedback');
        $query = $this->db->get('components')->row_array();

        $settings = unserialize($query['settings']);

        if (is_int($settings['message_max_len'])) {
            $this->message_max_len = $settings['message_max_len'];
        }

        if ($settings['email']) {
            $this->admin_mail = $settings['email'];
        }
    }

    public function sender()
    { 
if ($_POST['captcha'] && $_POST['captcha'] > 0) {
    if ($_POST['captcha'] != $_SESSION["primer"]) {
        return 'N';
    } else {
        $name = '<h1>Форма заполнена - '.$_POST['name_form'] . ' ' . date('d.m.Y H:i:s', time()) .
            '</h1><hr><br>Имя клиента: ' . $_POST['name'] . '<br>';
        $phone = '<br>Телефон клиента: ' . $_POST['phone'] . '<br>';
        
        $sell = '';

        if (isset($_POST['sell']) && $_POST['sell'] != '') {
            $sell = '<br>Название продавца: ' . $_POST['sell'] . '<br>';

        }
        
        $object = '';

        if (isset($_POST['object']) && $_POST['object'] != '') {
            $object = '<br>Серийный номер оборудования: ' . $_POST['object'] . '<br>';

        }

        $comment = '';

        if (isset($_POST['comment']) && $_POST['comment'] != '') {
            $comment = '<br>Комментарий: ' . $_POST['comment'] . '<br>';

        }
        
        $url = '';

        if (isset($_POST['url']) && $_POST['url'] != '') {
            $url = '<br>Ссылка на страницу: ' . $_POST['url'] . '<br>';

        }
        
        $firm = '';

        if (isset($_POST['firm']) && $_POST['firm'] != '') {
            $firm = '<br>Фирма: ' . $_POST['firm'] . '<br>';

        }
        
        $city = '';

        if (isset($_POST['city']) && $_POST['city'] != '') {
            $city = '<br>Город: ' . $_POST['city'] . '<br>';

        }
        
        $real_city = '';

        if (isset($_POST['real_city']) && $_POST['real_city'] != '') {
            $real_city = '<br>Реальный город: ' . $_POST['real_city'] . '<br>';

        }
        
        
        $check = '';

        if (isset($_POST['check']) && $_POST['check'] != '') {
            $check = '<br>Получать рассылку: Да<br>';
        } else {
           $check = '<br>Получать рассылку: Нет<br>'; 
        };

        $email = '';

        if (isset($_POST['email']) && $_POST['email'] != '') {
            $email = '<br>E-mail: ' . $_POST['email'] . '<br>';

        }
        
        $news = '';
        
        if (isset($_POST['news']) && $_POST['news'] != '') {
            $news = '<br>Подписка на новости: ' . $_POST['news'] . '<br>';

        }
        
        $cats = '';
        
        if (isset($_POST['cats']) && $_POST['cats'] != '') {
            $cats = '<br>Категория: ' . $_POST['cats'] . '<br>';

        }
        
        $model = '';
        
        if (isset($_POST['model']) && $_POST['model'] != '') {
            $model = '<br>Модель: ' . $_POST['model'] . '<br>';

        }


        $html = $name . $phone . $email . $object . $sell . $comment . $firm . $city . $real_city . $check . $news . $cats . $model . $url;


        $this->load->library('email');

        // prepare email
        $this->email->from('info@t2.artofseo.ru', 'Обращение с сайта')->to($_POST['admin_email'])->
            subject('Поступило новое обращение с сайта')->message($html)->set_mailtype('html');

        // send email
        $this->email->send();
        return 'Сообщение отправлено';
    };
} else {
return 'N';    
}
}

public function newnum () {

    $first = rand(1, 9); //получаем случайное значение
$second = rand(1, 7);

if ($first == $second) { //убираем возможность одинаковости первого и второго числа и исключаем тем самым нулевой результат
    $first = rand(1, 5);
    $second = rand(1, 5);
}

$t = time(); //инициализируем переменную для смены операций временем в секундах на момент запроса
$result = 0;

if ($t % 2) {

    $action = '+';
    $lbl = 'плюс';

} else {


    $action = '-';
    $lbl = 'минус';

}

if ($first < $second) {
    $first = $first + $second;


}

if ($first > 9) {

    $firs = 9;
}

if ($action == '+') {

    $result = $first + $second;

} else {
    $result = $first - $second;

}
$_SESSION["primer"] = $result;
$str = $first . ' ' . $lbl . ' ' . $second . ' = ';

return $str;
}


    public function idout() {
        if ($_POST['model']!=''){
            return $_POST['model'];
        } else if ($_POST['type']!='') {
          return $_POST['type'];  
        } else if ($_POST['cat']!='') {
          return $_POST['cat'];  
        };
    }
public function idcat () {
    $idarray=array();
$hrart = $this->db->where(array('data' => 1177, 'field_name' => 'field_relative_tovs','item_type'=>'page'))->get('content_fields_data')->result();
foreach($hrart as $omeh){
    $idarray[]=$omeh->item_id;
}
$idarray=json_encode($idarray);
     echo '<pre>';
 var_dump($idarray); 
 echo '</pre>';     
    }
    
}
/* End of file sample_module.php */

<?php

(defined('BASEPATH')) or exit('No direct script access allowed');

/**
 * Image CMS
 * Module Sample
 */
class Sample_Module extends MY_Controller
{

    /** Подготовим необходимые свойства для класса */
    private $key = false;

    private $mailTo = false;

    private $useEmailNotification = false;

    public function __construct()
    {
        parent::__construct();
        $lang = new MY_Lang();
        $lang->load('sample_module');
        $this->load->module('core');

        /** Запускаем инициализацию переменых. Значения будут взяты з
         *  Базы Данных, и присвоены соответствующим переменным */
        $this->initSettings();
    }

    public function index()
    {
        $this->core->error_404();
    }

    /**
     * Метод относится к стандартным методам ImageCMS.
     * Будет вызван каждый раз при обращении к сайту.
     * Запускается при условии включении "Автозагрузка модуля-> Да" в панели
     * уплавнеия модулями.
     */
    public function autoload()
    {
        if ('TRUE' == $this->useEmailNotification) {
            //            \CMSFactory\Events::create()->setListener('handler', 'Sample_Module:__construct');
            \CMSFactory\Events::create()->setListener('handler', 'Commentsapi:newPost');
        }
    }
    public function del_image($filename = '')
    {

        if ($filename != '') {


            $this->load->helper("file");
            unlink('/uploads/multiimage/' . $filename);
        }

    }
    public function upload()
    {


        if (isset($_FILES['files']) && !empty($_FILES['files'])) {
            $no_files = count($_FILES["files"]['name']);
            for ($i = 0; $i < $no_files; $i++) {
                if ($_FILES["files"]["error"][$i] > 0) {
                    echo "Error: " . $_FILES["files"]["error"][$i] . "<br>";
                } else {
                    if (file_exists('uploads/multiimage/' . $_FILES["files"]["name"][$i])) {
                        $status = 'Уже есть файлы с такими именами: ' . $_FILES["files"]["name"][$i];
                    } else {
                        move_uploaded_file($_FILES["files"]["tmp_name"][$i], 'uploads/multiimage/' . $_FILES["files"]["name"][$i]);
                        $status = 'Файл успешно загружен';


                    }
                }

                $result[] = array('status' => $status, 'file' => $_FILES["files"]["name"][$i]);
                $files[] = $_FILES["files"]["name"][$i];
            }
            $result['files'] = $files;

            echo json_encode($result);

        }
    }


    function allPoints()
    {

        $city = $_GET['fields_filter']['city_filter'];


        $this->db->where('item_type', 'page');

        if ($city != '') {


            $this->db->where('data', $city);

        }


        $q = $this->db->get('content_fields_data');

        $rst = array();
        $rst['list'] = array();


        foreach ($q->result_array() as $row) {


            $page = $this->getPage($row['item_id']);


            if ($page['field_main'] == 1) {

                $status = 'head-office';
            } else {

                $status = 'dealer';
            }


            $info = array(
                'site' => $page['field_site'],
                'address' => strip_tags($page['prev_text']),
                'email' => strip_tags($page['full_text']),
                'phone' => $page['field_phone'],
                'fax' => $page['field_fax'],
                'status' => $status);


            $rst['list'][] = array(
                'id' => $row['item_id'],
                'lat' => $page['field_lat'],
                'lon' => $page['field_lon'],
                'name' => $page['title'],
                'info' => $info);


        }


        echo json_encode($rst);
    }
    public function getPage($id)
    {

        // Select page permissions and page data
        $this->db->select('content.*');
        $this->db->select("IF(route.parent_url <> '', concat(route.parent_url, '/', route.url), route.url) as full_url", false);
        $this->db->where('content.id', $id);

        $this->db->where('post_status', 'publish');
        $this->db->where('publish_date <=', time());
        $this->db->where('lang', config_item('cur_lang'));
        $this->db->join('content_permissions',
            'content_permissions.page_id = content.id', 'left');
        $this->db->join('route', 'route.id = content.route_id');

        $query = $this->db->get('content', 1);

        if ($query->num_rows() > 0) {
            $page = $query->row_array();
            $page['roles'] = unserialize($page['roles']);
            $page['full_text'] = $page['full_text'] ? : $page['prev_text'];
            $page = $this->cfcm->connect_fields($page, 'page');

            return $page;
        }
    }


    function dump()
    {

        include ('shd.php');
        $html = file_get_html('http://www.putzmeister.ru/info/');
        $arnews = array();
        $cnt = 0;
        foreach ($html->find('.one-news .news-b .name') as $element) {

            $temp = $element->innertext();


            $link = $element->href;
            $tar = explode('/', $link);

            $url = $tar[4];




                $ft = $this->get_news_page2($link);

                $xr = array(
                    'title' => $temp,
                    'prev_text' => $ft['text'],
                    'full_text' => '<p>&nbsp;</p>',
                    'meta_title' => $ft['title'],
                    'description' => $ft['description'],
                    'keywords' => $ft['keywords'],
                    'publish_date' => time(),
                    'created' => time(),
                    'updated' => time(),
                    'category' => '42',
                    'author' => 'Administrator',
                    'post_status' => 'publish',
                    'full_tpl' => '',
                    'main_tpl' => '',
                    'position' => '0',
                    'lang' => '3');
                $this->db->insert('content', $xr);
                $pid = $this->db->insert_id();


                $xa = array(
                    'type' => 'page',
                    'parent_url' => 'info',
                    'url' => $url,
                    'entity_id' => $pid);

                $this->db->insert('route', $xa);

                $rid = $this->db->insert_id();

                $data = array('route_id' => $rid);
                $this->db->where('id', $pid);
                $this->db->update('content', $data);


                $cnt++;

            

        }


    }


    function get_news_page2($link)
    {

        $html = file_get_html($link);

        $headers["title"] = $html->find("title", 0)->plaintext;
        $headers["keywords"] = $html->find("meta[name=keywords]", 0)->getAttribute('content');
        $headers["description"] = $html->find("meta[name=description]", 0)->
            getAttribute('content');


        $xt = $html->find('h1', 0)->innertext();
        $temp1 = str_get_html($xt);


        $xx = $html->find('.text-block', 0)->innertext();

        $x = str_replace('/images/', '/uploads/', $xx);

        $headers["text"] = $x;

        return $headers;
    }


    function get_news_page($link)
    {

        $html = file_get_html($link);

        $headers["title"] = $html->find("title", 0)->plaintext;
        $headers["keywords"] = $html->find("meta[name=keywords]", 0)->getAttribute('content');
        $headers["description"] = $html->find("meta[name=description]", 0)->
            getAttribute('content');


        $xt = $html->find('h1', 0)->innertext();
        $temp1 = str_get_html($xt);

        $headers["date"] = $temp1->find('.r-fl', 0)->innertext();
        $headers["date"] = str_replace('г.', '', $headers["date"]);

        $xx = $html->find('.text-block', 0)->innertext();
        $temp2 = str_get_html($xx);
        $x = $temp2->find('div', 1)->innertext();
        $x = str_replace('/images/', '/uploads/', $x);

        $headers["text"] = $x;

        return $headers;
    }


    function dump2()
    {

        include ('shd.php');
        $html = file_get_html('http://www.putzmeister.ru/catalog/');
        $arnews = array();
        $cnt = 7;
        $aa = 0;
        foreach ($html->find('.container .production .main-side .list-item li') as $element) {
$docfile=array();
$docfiles=array();
            $aa++;


            if ($aa > 0 && $aa < 20) {

                $temp = $element->innertext();
                $ht2 = str_get_html($temp);

                $x = $ht2->find('.desc', 0);
                $y = $ht2->find('.n2', 0);

                $image = $ht2->find('img', 0)->src;
                $image = str_replace('/images/', '/uploads/', $image);

                $link = $ht2->find('a', 0)->href;


                $ft = $this->get_cat('http://www.putzmeister.ru' . $link);
$lll = 'http://www.putzmeister.ru' . $link;
                $lll = substr($lll, 0, -1);
            $xmlstr = $lll . '.xml';    
$page = new SimpleXMLElement($xmlstr, null, true); 
                $za = explode('/', $link);
                $cpu = $za[count($za) - 2];
                
$newtitle=(string)$page["header"];
var_dump($newtitle);
/*
                $xr = array(
                    'name' => $y->innertext(),
                    'short_desc' => $ft['text'],
                    'title' => $ft['title'],
                    'description' => $ft['description'],
                    'keywords' => $ft['keywords'],
                    'parent_id' => 5,
                    'fetch_pages' => 'b:0;',
                    'main_tpl' => '',
                    'image' => $image,
                    'tpl' => '',
                    'position' => $cnt,
                    'order_by' => 'publish_date',
                    'sort_order' => 'desc',
                    'page_tpl' => 'product',
                    'field_group' => 3,
                    'settings' => 'a:2:{s:26:"category_apply_for_subcats";b:0;s:17:"apply_for_subcats";b:0;}',
                    'created' => time(),
                    'updated' => time(),
                    );
             */       
                     $hr = $this->db->where('name', $newtitle)->get('category')->result();
                     $pid =$hr[0]->id;
                     echo '<pre>';
                     var_dump($hr);
                     echo '</pre>';
                     //PDF файлы
                             foreach ($page->page->properties->group as $groupprop){
                                         //Описание
            if ($oneO["name"] == 'descr') {
            $descr = trim($oneO->value); 
            }; 
            var_dump($descr);  
                  /*              
          foreach ($groupprop->property as $oneO){ 
                        //1 документация
            if ($oneO["name"] == 'doc_file_gallery') {
                $doc = json_decode($oneO->value);
                foreach ($doc as $onedoc) {
                    $names = trim($onedoc->altName);
                    $docfileg = str_replace('images', 'uploads', trim((string )$onedoc->src));
                    $onedoc = array();
                    $onedoc[] = $docfileg;
                    $onedoc[] = $names;
                    $onedoc = implode('||', $onedoc); //PDF файл
                    $docfile[] = $onedoc;
                };
                $docfile = implode('##', $docfile); //PDF файл
            };
            //2 документация
            if ($oneO["name"] == 'shared_file_gallery') {
                $docs = json_decode($oneO->value);
                foreach ($docs as $onedocs) {
                    $namess = trim($onedocs->altName);
                    $docfilegs = str_replace('images', 'uploads', trim((string )$onedocs->src));
                    $onedocs = array();
                    $onedocs[] = $docfilegs;
                    $onedocs[] = $namess;
                    $onedocs = implode('||', $onedocs); //PDF файл
                    
                    $docfiles[] = $onedocs;
                };
                $docfiles = implode('##', $docfiles); //PDF файл
            };
            };
            */
            
            };
/*
                    $hrpdf = $this->db->where(array('item_id' => $pid, 'field_name' => 'field_docks','item_type'=>'category'))->
                        get('content_fields_data')->result();
                    if ($hrpdf == false) {
                        $dppdf = array(
                            'item_id' => $pid,
                            'item_type' => 'category',
                            'field_name' => 'field_docks',
                            'data' => $docfile);
                        $this->db->insert('content_fields_data', $dppdf);
                    } else {
                        $dppdf = array(
                            'item_id' => $pid,
                            'item_type' => 'category',
                            'field_name' => 'field_docks',
                            'data' => $docfile);
                        $where = "id = " . $hrpdf[0]->id . ' AND field_name = "field_docks" AND item_type="category"';
                        $this->db->update('content_fields_data', $dppdf, $where);
                    };
                    
                    //Общие документы (для оборудования)
                    $hrpdf2 = $this->db->where(array('item_id' => $pid, 'field_name' => 'field_docfull','item_type'=>'category'))->
                        get('content_fields_data')->result();
                    if ($hrpdf2 == false) {
                        $dppdf2 = array(
                            'item_id' => $pid,
                            'item_type' => 'category',
                            'field_name' => 'field_docfull',
                            'data' => $docfiles);
                        $this->db->insert('content_fields_data', $dppdf2);
                    } else {
                        $dppdf2 = array(
                            'item_id' => $pid,
                            'item_type' => 'category',
                            'field_name' => 'field_docfull',
                            'data' => $docfiles);
                        $where = "id = " . $hrpdf2[0]->id . ' AND field_name = "field_docfull" AND item_type="category"';
                        $this->db->update('content_fields_data', $dppdf2, $where);
                    };
                    
/*
                $this->db->insert('category', $xr);
                $pid = $this->db->insert_id();


                $xa = array(
                    'type' => 'category',
                    'parent_url' => 'catalog',
                    'url' => $cpu,
                    'entity_id' => $pid);

                $this->db->insert('route', $xa);

                $rid = $this->db->insert_id();

                $data = array('route_id' => $rid);
                $this->db->where('id', $pid);
                $this->db->update('category', $data);


                $cnt++;

*/
                          var_dump($pid); 
$descr=str_replace('/images/','/uploads/',$descr);
                    $where = "id = " . $pid;
$xr = array(
                    'short_desc' => $descr,
                    'updated' => time(),
                    );
                    $this->db->update('category', $xr, $where);  

            }

        }


    }

    function get_cat($link)
    {

        $html = file_get_html($link);

        $headers["title"] = $html->find("title", 0)->plaintext;
        $headers["keywords"] = $html->find("meta[name=keywords]", 0)->getAttribute('content');
        $headers["description"] = $html->find("meta[name=description]", 0)->
            getAttribute('content');


        $xx = $html->find('.text-block', 2);

        if ($xx != null) {

            $x = str_replace('/images/', '/uploads/', $xx->innertext());
        } else {
            $x = '';
        }


        $headers["text"] = $x;

        return $headers;
    }


    public function changeStatus($commentId, $status, $key)
    {
        /** Проверим входные данные */
        ($commentId and in_array($status, [0, 1, 2]) and $key == $this->key) or $this->
            core->error_404();

        /** Обновим статус */
        $this->db->where('id', intval($commentId))->set('status', intval($status))->
            update('comments');

        $comment = $this->db->where('id', $commentId)->get('comments')->row();
        if ($comment->module == 'core') {
            /** Используем помощник get_page($id) который аргументом принимает ID страницы.
             *  Помощник включен по умолчанию. Больше о функция помощника
             *  читайте здесь http://ellislab.com/codeigniter/user-guide/general/helpers.html */
            $comment->source = get_page($comment->item_id);
        }

        /** Сообщаем пользователю что статус обновлён успешно */
        \CMSFactory\assetManager::create()->setData('comment', $comment)->render('successful');
    }

    /**
     * Метод обработчик
     * @param type $commentId <p>ID коментария который был только что создан.</p>
     */
    public static function handler(array $param)
    {
        $instance = new Sample_Module();
        $instance->composeAndSendEmail($param);
    }

    private function composeAndSendEmail($arg)
    {
        $comment = $this->db->where('id', $arg['commentId'])->get('comments')->row();
        if ($comment->module == 'core') {
            /** Используем помощник get_page($id) который аргументом принимает ID страницы.
             *  Помощник включен по умолчанию. Больше о функция помощника
             *  читайте здесь http://ellislab.com/codeigniter/user-guide/general/helpers.html */
            $comment->source = get_page($comment->item_id);
        }

        /** Теперь переменная содержит HTML тело нашего письма */
        $message = \CMSFactory\assetManager::create()->setData(['comment' => $comment,
            'key' => $this->key])->fetchTemplate('emailPattern');

        /** Настроявием отправку Email http://ellislab.com/codeigniter/user-guide/libraries/email.html */
        $this->load->library('email');
        $this->email->initialize(['mailtype' => 'html']);
        $this->email->from('robot@sitename.com', 'Comments Robot');
        $this->email->to($this->mailTo);
        $this->email->subject('New Comment received');
        $this->email->message($message);
        $this->email->send();
        //        echo $this->email->print_debugger();
    }

    private function initSettings()
    {
        $request = $this->db->get('mod_sample_settings');
        if ($request) {
            $DBSettings = $request->result_array();
            foreach ($DBSettings as $record) {
                $this->$record['name'] = $record['value'];
            }
        }
    }

    /**
     * Метод относиться  к стандартным методам ImageCMS.
     * Будет вызван при установке модуля пользователем
     */
    public function _install()
    {
        /** Подключаем класс Database Forge содержащий функции,
         *  которые помогут вам управлять базой данных.
         *  http://ellislab.com/codeigniter/user-guide/database/forge.html */
        $this->load->dbforge();

        /** Создаем массив полей и их атрибутов для БД */
        $fields = ['id' => ['type' => 'INT', 'constraint' => 11, 'auto_increment' => true, ],
            'name' => ['type' => 'VARCHAR', 'constraint' => 50, ], 'value' => ['type' =>
            'VARCHAR', 'constraint' => 100, ], ];

        /** Указываем на поле, которое будет с ключом Primary */
        $this->dbforge->add_key('id', true);
        /** Добавим поля в таблицу */
        $this->dbforge->add_field($fields);
        /** Запускаем запрос к базе данных на создание таблицы */
        $this->dbforge->create_table('mod_sample_settings', true);

        /** Заполним поля таблицы временными данными */
        $data = [['name' => 'mailTo', 'value' => 'admin@site.com', ], ['name' =>
            'useEmailNotification', 'value' => 'TRUE', ], ['name' => 'key', 'value' =>
            'UUUsssTTTeee', ], ];
        /** ...и добавим их в Базу Данных */
        $this->db->insert_batch('mod_sample_settings', $data);

        /** Обновим метаданные модуля, включим автозагрузку модуля и доступ по URL */
        $this->db->where('name', 'sample_module')->update('components', ['autoload' =>
            '1', 'enabled' => '1']);
    }

    /**
     * Метод относиться  к стандартным методам ImageCMS.
     * Будет вызван при удалении модуля пользователем
     */
    public function _deinstall()
    {
        $this->load->dbforge();
        $this->dbforge->drop_table('mod_sample_settings');
    }


    public function cats()
    {
        
        include ('simple_html_dom.php');
        $html = file_get_html('http://www.putzmeister.ru/service/spares/betononasosy/');
        //$html = file_get_html('http://www.putzmeister.ru/service/spares/rastvoronasosy/');
        $arnews = array();
        $p = 0;
        foreach ($html->find('.new-list .item') as $element) {
            $p++;
            if ($p < 100000) { 
                        $href = trim($element->href);
                $href = substr($href, 0, -1);
                
        
        $note_tech_characteristics='';
        $type_equipment_singular='';
        $preopisanie='';
        $descr='';
        $message_for_customer='';
        $header_chapter='';
        $anons_chapter='';
        $gallery = array();
        $photoanons = array();
        $docfile = array();
        $docname = array();
        $docnames = array();
        $docfiles = array();
        $related_articlesfull = array();
        $primenfull = array();
        $sp_tvаfull = array();
        $xmlstr = 'http://www.putzmeister.ru' . $href . '.xml';
        
        $page = new SimpleXMLElement($xmlstr, null, true);       
        $name = trim((string)$page["header"]);
        $id = trim((string )$page['pageId']); //Id товара в старой системе для привязки
        $title = trim((string )$page["title"]); //Заголовок браузера
        $keywords = trim((string )$page->meta->keywords); //Ключевые слова
        $description = trim((string )$page->meta->description); //Мета описание
        $h1 = trim((string )$page["title"]); //Имя
        $url = trim((string )$page->page["alt-name"]); //УРЛ
        $nums = count($page->parents->page);

        foreach ($page->parents->page as $oneparents) {

            $i++;
            if ($nums == $i) {
                $urlcat = trim((string )$oneparents["alt-name"]); //Url категории
                //var_dump($urlcat);
                $namecat = trim((string )$oneparents->name); //Имя категории
                //var_dump($namecat);
            };
        };
        
        foreach ($page->page->properties->group as $groupprop){
          foreach ($groupprop->property as $oneO){ 
                    if ($oneO["name"] == 'photo_image_gallery') {
                $gal = json_decode($oneO->value);
                $k=0;
                foreach ($gal as $oneimggal) {
                    $k++;
                    if ($k==1){
                    $onephotog = str_replace('images', 'uploads', trim((string )$oneimggal->src));
                    $gallery[] = $onephotog;
                    };
                }
                ;
                $gallery = implode(',', $gallery); //Галерея изображений
            };
            if ($oneO["name"] == 'image_slider_image_gallery') {
                $photoa = json_decode($oneO->value);
                foreach ($photoa as $photoa) {
                    $onephotoa = str_replace('images', 'uploads', trim((string )$photoa->src));
                    $photoanons[] = $onephotoa;
                }
                ;
                $photoanons = implode(',', $photoanons); //Главное изображение
            };
            //1 документация
            if ($oneO["name"] == 'doc_file_gallery') {
                $doc = json_decode($oneO->value);
                foreach ($doc as $onedoc) {
                    $names = trim($onedoc->altName);
                    $docfileg = str_replace('images', 'uploads', trim((string )$onedoc->src));
                    $onedoc = array();
                    $onedoc[] = $docfileg;
                    $onedoc[] = $names;
                    $onedoc = implode('||', $onedoc); //PDF файл
                    $docfile[] = $onedoc;
                };
                $docfile = implode('##', $docfile); //PDF файл
            };
            //2 документация
            if ($oneO["name"] == 'shared_file_gallery') {
                $docs = json_decode($oneO->value);
                foreach ($docs as $onedocs) {
                    $namess = trim($onedocs->altName);
                    $docfilegs = str_replace('images', 'uploads', trim((string )$onedocs->src));
                    $onedocs = array();
                    $onedocs[] = $docfilegs;
                    $onedocs[] = $namess;
                    $onedocs = implode('||', $onedocs); //PDF файл
                    
                    $docfiles[] = $onedocs;
                };
                $docfiles = implode('##', $docfiles); //PDF файл
            };
            //Примечание к техническим характеристикам 
            if ($oneO["name"] == 'note_tech_characteristics') {
            $note_tech_characteristics = trim($oneO->value); 
            };
                        //Тип оборудования в единственном числе 
            if ($oneO["name"] == 'type_equipment_singular') {
            $type_equipment_singular = trim($oneO->value); 
            };    
                      //Описание в начале
            if ($oneO["name"] == 'preopisanie') {
            $preopisanie = trim($oneO->value); 
            };
            //Описание
            if ($oneO["name"] == 'descr') {
            $descr = trim($oneO->value); 
            };
            //Сообщение для покупателя
            if ($oneO["name"] == 'message_for_customer') {
            $message_for_customer = trim($oneO->value); 
            };
                                         //Заголовок раздела
            if ($oneO["name"] == 'header_chapter') {
            $header_chapter = trim($oneO->value); 
            };  
                                        //Подпись к заголовку
            if ($oneO["name"] == 'anons_chapter') {
            $anons_chapter = trim($oneO->value); //Текст превью
            };    
            
            
            
            
 
        }; 
        }; 
            
            
        $cats = $this->db->where('url', 'spares_'.$urlcat)->get('route')->result();
        $idcats = (string)$cats[0]->entity_id; //ID категории
        $urlcats = (string )$cats[0]->parent_url . '/' . (string)$cats[0]->url; //URL категории
            if ($descr==null){
                $descr='';
            } 
           
        //Проверяем - есть ли данная категория
        $hr = $this->db->where('title', $title)->get('category')->result();
                       /* $xr = array(
                    'name' => $y->innertext(),
                    'short_desc' => $ft['text'],
                    'title' => $ft['title'],
                    'description' => $ft['description'],
                    'keywords' => $ft['keywords'],
                    'parent_id' => 5,
                    'fetch_pages' => 'b:0;',
                    'main_tpl' => '',
                    'image' => $image,
                    'tpl' => '',
                    'position' => $cnt,
                    'order_by' => 'publish_date',
                    'sort_order' => 'desc',
                    'page_tpl' => 'product',
                    'field_group' => 3,
                    'settings' => 'a:2:{s:26:"category_apply_for_subcats";b:0;s:17:"apply_for_subcats";b:0;}',
                    'created' => time(),
                    'updated' => time(),
                    );
        */
        
        
               /* //Формируем массив основных полей страницы
                $category = array(
                'parent_id'=>$idcats,
                'name'=>$name,
                'title'=>$title,
                'short_desc'=>$descr,
                'image'=>$gallery,
                'keywords'=>$keywords,
                'description'=>$description,
                'fetch_pages'=>'b:0;',
                'main_tpl'=>'',
                'tpl'=>'category_spares',
                'page_tpl'=>'',
                'per_page'=>'15',
                'order_by'=>'publish_date',
                'sort_order'=>'desc',
                'comments_default'=>'0',
                'field_group'=>'3',
                'category_field_group'=>'5',
                'settings'=>'a:2:{s:26:"category_apply_for_subcats";b:0;s:17:"apply_for_subcats";b:0;}',
                'created'=>time(),
                'updated'=>time(),
                );  
                */
                //var_dump($category); 
                
                if ($hr == false) {
                   /* 
                    //Если страницы не существет - создаем ее
                    $this->db->insert('category', $category );
                    //Получаем ID только что созданной страницы
                    $pid = $this->db->insert_id();
                    //Формируем массив с категорией и урлом для страницы
                    $rt = array(
                        'entity_id' => $pid,
                        'type' => 'category',
                        'parent_url' => $urlcats,
                        'url' => $url);
                    $this->db->insert('route', $rt);
                    //Получаем ID только что созданного url для страницы
                    $pidURL = $this->db->insert_id();
                    //Обновляем привязку к урлу страницы
                    $where = "id = " . $pid;
                    $rt = array('route_id' => $pidURL, );
                    $this->db->update('category', $rt, $where);
                    //Проверяем на наличие поля галерея
                    $hrgal = $this->db->where(array('item_id' => $pid, 'field_name' =>
                            'field_gallery','item_type'=>'category'))->get('content_fields_data')->result();
                    if ($hrgal == false) {
                        $dpgal = array(
                            'item_id' => $pid,
                            'item_type' => 'category',
                            'field_name' => 'field_gallery',
                            'data' => $photoanons);
                        $this->db->insert('content_fields_data', $dpgal);
                    } else {
                        $dpgal = array(
                            'item_id' => $pid,
                            'item_type' => 'category',
                            'field_name' => 'field_gallery',
                            'data' => $photoanons);
                        $where = "id = " . $hrgal[0]->id . ' AND field_name = "field_gallery" AND item_type="category"';
                        $this->db->update('content_fields_data', $dpgal, $where);
                    };
                    
                    //PDF файлы
                    $hrpdf = $this->db->where(array('item_id' => $pid, 'field_name' => 'field_docks','item_type'=>'category'))->
                        get('content_fields_data')->result();
                    if ($hrpdf == false) {
                        $dppdf = array(
                            'item_id' => $pid,
                            'item_type' => 'category',
                            'field_name' => 'field_docks',
                            'data' => $docfile);
                        $this->db->insert('content_fields_data', $dppdf);
                    } else {
                        $dppdf = array(
                            'item_id' => $pid,
                            'item_type' => 'category',
                            'field_name' => 'field_docks',
                            'data' => $docfile);
                        $where = "id = " . $hrpdf[0]->id . ' AND field_name = "field_docks" AND item_type="category"';
                        $this->db->update('content_fields_data', $dppdf, $where);
                    };
                    
                    //Общие документы (для оборудования)
                    $hrpdf2 = $this->db->where(array('item_id' => $pid, 'field_name' => 'field_docfull','item_type'=>'category'))->
                        get('content_fields_data')->result();
                    if ($hrpdf2 == false) {
                        $dppdf2 = array(
                            'item_id' => $pid,
                            'item_type' => 'category',
                            'field_name' => 'field_docfull',
                            'data' => $docfiles);
                        $this->db->insert('content_fields_data', $dppdf2);
                    } else {
                        $dppdf2 = array(
                            'item_id' => $pid,
                            'item_type' => 'category',
                            'field_name' => 'field_docfull',
                            'data' => $docfiles);
                        $where = "id = " . $hrpdf2[0]->id . ' AND field_name = "field_docfull" AND item_type="category"';
                        $this->db->update('content_fields_data', $dppdf2, $where);
                    };
                    
                    
                    //Примечание к техническим характеристикам
                    $hrifr = $this->db->where(array('item_id' => $pid, 'field_name' => 'field_prims','item_type'=>'category'))->
                        get('content_fields_data')->result();
                    if ($hrifr == false) {
                        $dpifr = array(
                            'item_id' => $pid,
                            'item_type' => 'category',
                            'field_name' => 'field_prims',
                            'data' => $note_tech_characteristics);
                        $this->db->insert('content_fields_data', $dpifr);
                    } else {
                        $dpifr = array(
                            'item_id' => $pid,
                            'item_type' => 'category',
                            'field_name' => 'field_prims',
                            'data' => $note_tech_characteristics);
                        $where = "id = " . $hrifr[0]->id . ' AND field_name = "field_prims" AND item_type="category"';
                        $this->db->update('content_fields_data', $dpifr, $where);
                    };
                    
                    //Описание в начале
                    $hrprevtext = $this->db->where(array('item_id' => $pid, 'field_name' => 'field_prevtext','item_type'=>'category'))->
                        get('content_fields_data')->result();
                    if ($hrprevtext == false) {
                        $dpprevtext = array(
                            'item_id' => $pid,
                            'item_type' => 'category',
                            'field_name' => 'field_prevtext',
                            'data' => $preopisanie);
                        $this->db->insert('content_fields_data', $dpprevtext);
                    } else {
                        $dpprevtext = array(
                            'item_id' => $pid,
                            'item_type' => 'category',
                            'field_name' => 'field_prevtext',
                            'data' => $preopisanie);
                        $where = "id = " . $hrifr[0]->id . ' AND field_name = "field_prevtext" AND item_type="category"';
                        $this->db->update('content_fields_data', $dpprevtext, $where);
                    };
                    
                    //Сообщение для покупателя
                    $hrmessage = $this->db->where(array('item_id' => $pid, 'field_name' => 'field_message','item_type'=>'category'))->
                        get('content_fields_data')->result();
                    if ($hrmessage == false) {
                        $dpmessage = array(
                            'item_id' => $pid,
                            'item_type' => 'category',
                            'field_name' => 'field_message',
                            'data' => $message_for_customer);
                        $this->db->insert('content_fields_data', $dpmessage);
                    } else {
                        $dpmessage = array(
                            'item_id' => $pid,
                            'item_type' => 'category',
                            'field_name' => 'field_message',
                            'data' => $message_for_customer);
                        $where = "id = " . $hrifr[0]->id . ' AND field_name = "field_message" AND item_type="category"';
                        $this->db->update('content_fields_data', $dpmessage, $where);
                    };
                                      //Тип оборудования в единственном числе
                    $hrtypeo = $this->db->where(array('item_id' => $pid, 'field_name' => 'field_typeo','item_type'=>'category'))->
                        get('content_fields_data')->result();
                    if ($hrtypeo == false) {
                        $dptypeo = array(
                            'item_id' => $pid,
                            'item_type' => 'category',
                            'field_name' => 'field_typeo',
                            'data' => $type_equipment_singular);
                        $this->db->insert('content_fields_data', $dptypeo);
                    } else {
                        $dptypeo = array(
                            'item_id' => $pid,
                            'item_type' => 'category',
                            'field_name' => 'field_typeo',
                            'data' => $type_equipment_singular);
                        $where = "id = " . $hrifr[0]->id . ' AND field_name = "field_typeo" AND item_type="category"';
                        $this->db->update('content_fields_data', $dptypeo, $where);
                    };
                                                          //Заголовок
                    $hrz1 = $this->db->where(array('item_id' => $pid, 'field_name' => 'field_z1','item_type'=>'category'))->
                        get('content_fields_data')->result();
                    if ($hrz1 == false) {
                        $dptz1 = array(
                            'item_id' => $pid,
                            'item_type' => 'category',
                            'field_name' => 'field_z1',
                            'data' => $header_chapter);
                        $this->db->insert('content_fields_data', $dptz1);
                    } else {
                        $dptz1 = array(
                            'item_id' => $pid,
                            'item_type' => 'category',
                            'field_name' => 'field_z1',
                            'data' => $header_chapter);
                        $where = "id = " . $hrifr[0]->id . ' AND field_name = "field_z1" AND item_type="category"';
                        $this->db->update('content_fields_data', $dptz1, $where);
                    };
                                                                              //Полдпись к заголовку
                    $hrzp1 = $this->db->where(array('item_id' => $pid, 'field_name' => 'field_zp1','item_type'=>'category'))->
                        get('content_fields_data')->result();
                    if ($hrzp1 == false) {
                        $dpzp1 = array(
                            'item_id' => $pid,
                            'item_type' => 'category',
                            'field_name' => 'field_zp1',
                            'data' => $anons_chapter);
                        $this->db->insert('content_fields_data', $dpzp1);
                    } else {
                        $dpzp1 = array(
                            'item_id' => $pid,
                            'item_type' => 'category',
                            'field_name' => 'field_zp1',
                            'data' => $anons_chapter);
                        $where = "id = " . $hrifr[0]->id . ' AND field_name = "field_zp1" AND item_type="category"';
                        $this->db->update('content_fields_data', $dpzp1, $where);
                    };
                    
                    
                    };
                    */

        
        
      }   else {
                          $pid = $hr[0]->id;
                          var_dump($pid); 
$descr=str_replace('/images/','/uploads/',$descr);
                    $where = "id = " . $pid;
$xr = array(
                    'short_desc' => $descr,
                    'updated' => time(),
                    );
                    $this->db->update('category', $xr, $where);  
        
        
      }
       } 
       } 
       }  

 

    public function pages()
    {
        include ('simple_html_dom.php');
        $html = file_get_html('http://www.putzmeister.ru/catalog/raspredelitelnye-strely-putzmeister/');
        //$html = file_get_html('http://www.putzmeister.ru/catalog/shlamoviye-nasosy/');
        $arnews = array();
        $k = 0;
                var_dump(count($html->find('.row_ps_new .iinew>.item')));
        echo '<br>';
       foreach ($html->find('.catalog-products .catalog-products-item-title>.catalog-products-item-title-link') as $element) {

        //foreach ($html->find('.row_ps_new .iinew>.item') as $element) {
            $k++;
            if ($k<10000) {
                $newtitle='';
                $art='';
                $dptitle='';
                $textanons='';
                $description_full='';
                $tech_item='';
                $description_full='';
                $tech_item='';
                $mode_features='';
                $youtube_container='';
                $properties='';
                $price='';
                $cur='';
                $href = trim($element->href);
                $href = substr($href, 0, -1);
                $gallery = array();
                $photoanons = array();
                $docfile = array();
                $docname = array();
                $related_articlesfull = array();
                $primenfull = array();
                $sp_tvаfull = array();
                $xmlstr = 'http://www.putzmeister.ru' . $href . '.xml';
                $page = new SimpleXMLElement($xmlstr, null, true);
                $id = trim((string )$page['pageId']); //Id товара в старой системе для привязки
                $title = trim((string )$page["title"]); //Заголовок браузера
                $keywords = trim((string )$page->meta->keywords); //Ключевые слова
                $description = trim((string )$page->meta->description); //Мета описание
                $h1 = trim((string )$page["title"]); //Имя
                $url = trim((string )$page->page["alt-name"]); //УРЛ
                $nums = count($page->parents->page);
                $new = 0;
                $hit = 0;
                $sale = 0;
                $variants = 0;
                $variants_small = 0;
                $i = 0;
                $newtitle=trim((string)$page["header"]);
                echo '<pre>';
                var_dump($newtitle);
                echo '</pre>';
                foreach ($page->parents->page as $oneparents) {
                    $i++;
                    if ($nums == $i) {
                        $urlcat = trim((string )$oneparents["alt-name"]); //Url категории
                        $namecat = trim((string )$oneparents->name); //Имя категории
                    }
                    ;
                }
                ;
                //Получение общих атрибутов
                        foreach ($page->page->properties->group as $groupprop){
          foreach ($groupprop->property as $oneO){ 
                    if ($oneO["name"] == 'photo_image_gallery') {
                        $gal = json_decode($oneO->value);
                        foreach ($gal as $oneimggal) {
                            $onephotog = str_replace('images', 'uploads', trim((string )$oneimggal->src));
                            $gallery[] = $onephotog;
                        }
                        ;
                        $gallery = implode(',', $gallery); //Галерея изображений
                    }
                    ;
                    if ($oneO["name"] == 'photo_anons_image_gallery') {
                        $photoa = json_decode($oneO->value);
                        $u=0;
                        foreach ($photoa as $photoa) {
                            $u++;
                            if ($u==1){
                            $onephotoa = str_replace('images', 'uploads', trim((string )$photoa->src));
                            $photoanons[] = $onephotoa;
                            };
                        }
                        ;
                        $photoanons = implode(',', $photoanons); //Главное изображение
                    }
                    ;
                    if ($oneO["name"] == 'doc_file_gallery') {
                        $doc = json_decode($oneO->value);
                        foreach ($doc as $onedoc) {
                            $docname=trim($onedoc->altName);
                            $docfileg = str_replace('images', 'uploads', trim((string )$onedoc->src));
                            $onedocs = array();
                            $onedocs[] = $docfileg;
                            $onedocs[] = $docname;
                            $onedocs = implode('||', $onedocs); //PDF файл
                            $docfile[] = $onedocs;
                        }
                        ;
                        $docfile = implode('##', $docfile); //PDF файл
                    }
                    ;
                    //Хит
                    if ($oneO["name"] == 'hit') {
                        $hit = 1;
                    }
                    ;
                    //Новинка
                    if ($oneO["name"] == 'new') {
                        $new = 1;
                    }
                    ;
                    //Распродажа
                    if ($oneO["name"] == 'sale') {
                        $sale = 1;
                    }
                    ;
                    //Расширенный вид
                    if ($oneO["name"] == 'variants_view_item') {
                        $variants = 1;
                    }
                    ;
                    //Расширенный вид (маленький)
                    if ($oneO["name"] == 'variants_small_view_item') {
                        $variants_small = 1;
                    }
                    ;
                    if ($oneO["name"] == 'art') {
                        $art = trim((string )$oneO->value); //Артикул
                    }
                    ;
                    if ($oneO["name"] == 'additional_header') {
                        $dptitle = trim((string )$oneO->value); //Дополнительный заголовок
                    }
                    if ($oneO["name"] == 'text_anons') {
                        $textanons = trim($oneO->value); //Текст превью
                    }
                    
                    if ($oneO["name"] == 'description') {
                        $description_full = trim($oneO->value); //Описание
                    }
                    if ($oneO["name"] == 'tech-item') {
                        $tech_item = trim($oneO->value); //Технические характеристики
                    }
                    if ($oneO["name"] == 'mode_features') {
                        $mode_features = trim($oneO->value); //Особенности модели
                    }
                    if ($oneO["name"] == 'youtube_container') {
                        $youtube_container = trim($oneO->value); //Ссылки на youtube
                    }
                    if ($oneO["name"] == 'related_articles') {
                        foreach ($oneO->value->page as $related_articlesone) {
                            $related_articlesfull[] = array(trim((string )$related_articlesone["alt-name"]) =>
                                    trim((string )$related_articlesone->name)); //Связанные статьи Ключ/url - Значение/имя
                        }
                        ;
                    }
                    if ($oneO["name"] == 'primen') {
                        foreach ($oneO->value->page as $primen) {
                            $primenfull[] = array(trim((string )$primen["alt-name"]) => trim((string )$primen->
                                    name)); //Связанные статьи Ключ/url - Значение/имя
                        }
                        ;
                    }
                    if ($oneO["name"] == 'sv') {
                        $properties = trim((string )$oneO->value); //Свойства
                    }
                    if ($oneO["name"] == 'primen') {
                        foreach ($oneO->value->page as $sp_tv) {
                            $page_o='';
                            $idpage_o='';
                           
                           $page_o = $this->db->where('title', trim((string)$sp_tv->name))->get('content')->result();
                           $idpage_o = (string)$page_o[0]->id; //ID категории
                           $sp_tvаfull[] = $idpage_o;
                           
                            //$sp_tvаfull[] = array(trim((string )$sp_tv["alt-name"]) => trim((string)$sp_tv->name)); //Сопутствующие товары Ключ/url - Значение/имя
                        }
                        ;
                        echo '<pre>';
                        var_dump($sp_tvаfull);
                        echo '</pre>';
                    }
                    //В наличии
                    if ($oneO["name"] == 'v_nalichii') {
                        $v_nalichii = 1;
                    }
                    ;
                    if ($oneO['name'] == 'price') {
                        $price = $oneO->value;

                    }
                    ;
                    if ($oneO["name"] == 'currency') {
                        $cur = $oneO->value->item['name'];
                    }
                    ;
                }
                }
                //Проверяем на пустоту описания так как при значении null страница не обновится и не создастся
                if ($textanons == null) {
                    $textanons = '';
                }
                ;
                if ($description_full == null) {
                    $description_full = '<p>&nbsp;&nbsp;</p>';
                }
                ;
                //Получение полей категории
                $cats = $this->db->where('url', $urlcat)->get('route')->result();
                $idcats = (string )$cats[0]->entity_id; //ID категории
                $urlcats = (string )$cats[0]->parent_url . '/' . (string )$cats[0]->url; //URL категории
                //Проверяем - есть ли данная страница
                $hr = $this->db->where('title', $newtitle)->get('content')->result();
                //Формируем массив основных полей страницы
                $page = array(
                    'title' => $newtitle,
                    'meta_title' => $title,
                    'description' => $description,
                    'keywords' => $keywords,
                    'prev_text' => $textanons,
                    'full_text' => $description_full,
                    'category' => $idcats,
                    'full_tpl' => '',
                    'main_tpl' => '',
                    'position' => 0,
                    'comments_status' => 0,
                    'comments_count' => 0,
                    'post_status' => 'publish',
                    'author' => 'Administrator',
                    'publish_date' => time(),
                    'created' => time(),
                    'updated' => time(),
                    'showed' => 0,
                    'lang' => 3,
                    'lang_alias' => 0,
                    );
                if ($hr == false) {
                    /*
                    //Если страницы не существет - создаем ее
                    $this->db->insert('content', $page);
                    //Получаем ID только что созданной страницы
                    $pid = $this->db->insert_id();
                    //Формируем массив с категорией и урлом для страницы
                    $rt = array(
                        'entity_id' => $pid,
                        'type' => 'page',
                        'parent_url' => $urlcats,
                        'url' => $url);
                    $this->db->insert('route', $rt);
                    //Получаем ID только что созданного url для страницы
                    $pidURL = $this->db->insert_id();
                    //Обновляем привязку к урлу страницы
                    $where = "id = " . $pid;
                    $rt = array('route_id' => $pidURL, );
                    $this->db->update('content', $rt, $where);
                    //Создание доп полей

                    //Проверяем на наличие поля галерея
                    $hrgal = $this->db->where(array('item_id' => $pid, 'field_name' =>
                            'field_gallery','item_type'=>'page'))->get('content_fields_data')->result();
                    if ($hrgal == false) {
                        $dpgal = array(
                            'item_id' => $pid,
                            'item_type' => 'page',
                            'field_name' => 'field_gallery',
                            'data' => $gallery);
                        $this->db->insert('content_fields_data', $dpgal);
                    } else {
                        $dpgal = array(
                            'item_id' => $pid,
                            'item_type' => 'page',
                            'field_name' => 'field_gallery',
                            'data' => $gallery);
                        $where = "id = " . $hrgal[0]->id . ' AND field_name = "field_gallery" AND item_type="page"';
                        $this->db->update('content_fields_data', $dpgal, $where);
                    };
                    //Фото - анонс
                    $hranons = $this->db->where(array('item_id' => $pid, 'field_name' =>
                            'field_image','item_type'=>'page'))->get('content_fields_data')->result();
                    if ($hranons == false) {
                        $dpanons = array(
                            'item_id' => $pid,
                            'item_type' => 'page',
                            'field_name' => 'field_image',
                            'data' => $photoanons);
                        $this->db->insert('content_fields_data', $dpanons);
                    } else {
                        $dpanons = array(
                            'item_id' => $pid,
                            'item_type' => 'page',
                            'field_name' => 'field_image',
                            'data' => $photoanons);
                        $where = "id = " . $hrgal[0]->id . ' AND field_name = "field_image" AND item_type="page"';
                        $this->db->update('content_fields_data', $dpanons, $where);
                    }
                    ;
                    //PDF файлы
                    $hrpdf = $this->db->where(array('item_id' => $pid, 'field_name' => 'field_docks','item_type'=>'page'))->
                        get('content_fields_data')->result();
                    if ($hrpdf == false) {
                        $dppdf = array(
                            'item_id' => $pid,
                            'item_type' => 'page',
                            'field_name' => 'field_docks',
                            'data' => $docfile);
                        $this->db->insert('content_fields_data', $dppdf);
                    } else {
                        $dppdf = array(
                            'item_id' => $pid,
                            'item_type' => 'page',
                            'field_name' => 'field_docks',
                            'data' => $docfile);
                        $where = "id = " . $hrpdf[0]->id . ' AND field_name = "field_docks" AND item_type="page"';
                        $this->db->update('content_fields_data', $dppdf, $where);
                    }
                    ;
                    //Артикул
                    $hrart = $this->db->where(array('item_id' => $pid, 'field_name' => 'field_sku','item_type'=>'page'))->
                        get('content_fields_data')->result();
                    if ($hrart == false) {
                        $dpart = array(
                            'item_id' => $pid,
                            'item_type' => 'page',
                            'field_name' => 'field_sku',
                            'data' => $art);
                        $this->db->insert('content_fields_data', $dpart);
                    } else {
                        $dpart = array(
                            'item_id' => $pid,
                            'item_type' => 'page',
                            'field_name' => 'field_sku',
                            'data' => $art);
                        $where = "id = " . $hrart[0]->id . ' AND field_name = "field_sku" AND item_type="page"';
                        $this->db->update('content_fields_data', $dpart, $where);
                    }
                    ;
                    //Свойства
                    $hrsv = $this->db->where(array('item_id' => $pid, 'field_name' => 'field_sv','item_type'=>'page'))->
                        get('content_fields_data')->result();
                    if ($hrsv == false) {
                        $dpsv = array(
                            'item_id' => $pid,
                            'item_type' => 'page',
                            'field_name' => 'field_sv',
                            'data' => $properties);
                        $this->db->insert('content_fields_data', $dpsv);
                    } else {
                        $dpsv = array(
                            'item_id' => $pid,
                            'item_type' => 'page',
                            'field_name' => 'field_sv',
                            'data' => $properties);
                        $where = "id = " . $hrsv[0]->id . ' AND field_name = "field_sv" AND item_type="page"';
                        $this->db->update('content_fields_data', $dpsv, $where);
                    }
                    ;
                    //Хит
                    $hrhit = $this->db->where(array('item_id' => $pid, 'field_name' => 'field_hit','item_type'=>'page'))->
                        get('content_fields_data')->result();
                    if ($hrhit == false) {
                        $dphit = array(
                            'item_id' => $pid,
                            'item_type' => 'page',
                            'field_name' => 'field_hit',
                            'data' => $hit);
                        $this->db->insert('content_fields_data', $dphit);
                    } else {
                        $dphit = array(
                            'item_id' => $pid,
                            'item_type' => 'page',
                            'field_name' => 'field_hit',
                            'data' => $hit);
                        $where = "id = " . $hrhit[0]->id . ' AND field_name = "field_hit" AND item_type="page"';
                        $this->db->update('content_fields_data', $dphit, $where);
                    }
                    ;
                    //Новинка
                    $hrnew = $this->db->where(array('item_id' => $pid, 'field_name' => 'field_new','item_type'=>'page'))->
                        get('content_fields_data')->result();
                    if ($hrnew == false) {
                        $dpnew = array(
                            'item_id' => $pid,
                            'item_type' => 'page',
                            'field_name' => 'field_new',
                            'data' => $new);
                        $this->db->insert('content_fields_data', $dpnew);
                    } else {
                        $dpnew = array(
                            'item_id' => $pid,
                            'item_type' => 'page',
                            'field_name' => 'field_new',
                            'data' => $new);
                        $where = "id = " . $hrnew[0]->id . ' AND field_name = "field_new" AND item_type="page"';
                        $this->db->update('content_fields_data', $dpnew, $where);
                    }
                    ;
                    //Распродажа
                    $hrsale = $this->db->where(array('item_id' => $pid, 'field_name' => 'field_sale','item_type'=>'page'))->
                        get('content_fields_data')->result();
                    if ($hrsale == false) {
                        $dpsale = array(
                            'item_id' => $pid,
                            'item_type' => 'page',
                            'field_name' => 'field_sale',
                            'data' => $sale);
                        $this->db->insert('content_fields_data', $dpsale);
                    } else {
                        $dpsale = array(
                            'item_id' => $pid,
                            'item_type' => 'page',
                            'field_name' => 'field_sale',
                            'data' => $sale);
                        $where = "id = " . $hrsale[0]->id . ' AND field_name = "field_sale" AND item_type="page"';
                        $this->db->update('content_fields_data', $dpsale, $where);
                    }
                    ;
                    //Расширенный вид
                    $hrrs = $this->db->where(array('item_id' => $pid, 'field_name' => 'field_rs','item_type'=>'page'))->
                        get('content_fields_data')->result();
                    if ($hrrs == false) {
                        $dprs = array(
                            'item_id' => $pid,
                            'item_type' => 'page',
                            'field_name' => 'field_rs',
                            'data' => $variants);
                        $this->db->insert('content_fields_data', $dprs);
                    } else {
                        $dprs = array(
                            'item_id' => $pid,
                            'item_type' => 'page',
                            'field_name' => 'field_rs',
                            'data' => $variants);
                        $where = "id = " . $hrrs[0]->id . ' AND field_name = "field_rs" AND item_type="page"';
                        $this->db->update('content_fields_data', $dprs, $where);
                    }
                    ;
                    //Расширенный вид (маленький)
                    $hrrssmall = $this->db->where(array('item_id' => $pid, 'field_name' =>
                            'field_rssmall','item_type'=>'page'))->get('content_fields_data')->result();
                    if ($hrrssmall == false) {
                        $dprssmall = array(
                            'item_id' => $pid,
                            'item_type' => 'page',
                            'field_name' => 'field_rssmall',
                            'data' => $variants_small);
                        $this->db->insert('content_fields_data', $dprssmall);
                    } else {
                        $dprssmall = array(
                            'item_id' => $pid,
                            'item_type' => 'page',
                            'field_name' => 'field_rssmall',
                            'data' => $variants_small);
                        $where = "id = " . $hrrssmall[0]->id . ' AND field_name = "field_rssmall" AND item_type="page"';
                        $this->db->update('content_fields_data', $dprssmall, $where);
                    }
                    ;
                    //Дополнительный заголовок
                    $hrdptitle = $this->db->where(array('item_id' => $pid, 'field_name' =>
                            'field_name','item_type'=>'page'))->get('content_fields_data')->result();
                    if ($hrdptitle == false) {
                        $dpdptitle = array(
                            'item_id' => $pid,
                            'item_type' => 'page',
                            'field_name' => 'field_name',
                            'data' => $dptitle);
                        $this->db->insert('content_fields_data', $dpdptitle);
                    } else {
                        $dpdptitle = array(
                            'item_id' => $pid,
                            'item_type' => 'page',
                            'field_name' => 'field_name',
                            'data' => $dptitle);
                        $where = "id = " . $hrdptitle[0]->id . ' AND field_name = "field_name" AND item_type="page"';
                        $this->db->update('content_fields_data', $dpdptitle, $where);
                    }
                    ;
                    //Технические характеристики
                    $hrtech = $this->db->where(array('item_id' => $pid, 'field_name' => 'field_tech','item_type'=>'page'))->
                        get('content_fields_data')->result();
                    if ($hrtech == false) {
                        $dptech = array(
                            'item_id' => $pid,
                            'item_type' => 'page',
                            'field_name' => 'field_tech',
                            'data' => $tech_item);
                        $this->db->insert('content_fields_data', $dptech);
                    } else {
                        $dptech = array(
                            'item_id' => $pid,
                            'item_type' => 'page',
                            'field_name' => 'field_tech',
                            'data' => $tech_item);
                        $where = "id = " . $hrtech[0]->id . ' AND field_name = "field_tech" AND item_type="page"';
                        $this->db->update('content_fields_data', $dptech, $where);
                    }
                    ;
                    //Особенности модели
                    $hrfeatures = $this->db->where(array('item_id' => $pid, 'field_name' =>
                            'field_features','item_type'=>'page'))->get('content_fields_data')->result();
                    if ($hrfeatures == false) {
                        $dpfeatures = array(
                            'item_id' => $pid,
                            'item_type' => 'page',
                            'field_name' => 'field_features',
                            'data' => $mode_features);
                        $this->db->insert('content_fields_data', $dpfeatures);
                    } else {
                        $dpfeatures = array(
                            'item_id' => $pid,
                            'item_type' => 'page',
                            'field_name' => 'field_features',
                            'data' => $mode_features);
                        $where = "id = " . $hrfeatures[0]->id . ' AND field_name = "field_features" AND item_type="page"';
                        $this->db->update('content_fields_data', $dpfeatures, $where);
                    }
                    ;
                    //Ссылки на youtube
                    $hryou = $this->db->where(array('item_id' => $pid, 'field_name' => 'field_you','item_type'=>'page'))->
                        get('content_fields_data')->result();
                    $youtube_container = str_replace(' ', ',', $youtube_container);
                    $PCREpattern = '/\r\n|\r|\n/u';
                    $youtube_container = preg_replace($PCREpattern, ',', $youtube_container);
                    if ($hryou == false) {
                        $dpyou = array(
                            'item_id' => $pid,
                            'item_type' => 'page',
                            'field_name' => 'field_you',
                            'data' => $youtube_container);
                        $this->db->insert('content_fields_data', $dpyou);
                    } else {
                        $dpyou = array(
                            'item_id' => $pid,
                            'item_type' => 'page',
                            'field_name' => 'field_you',
                            'data' => $youtube_container);
                        $where = "id = " . $hryou[0]->id . ' AND field_name = "field_you" AND item_type="page"';
                        $this->db->update('content_fields_data', $dpyou, $where);
                    }
                    ;
                    //Ссылки на youtube
                    $hrv = $this->db->where(array('item_id' => $pid, 'field_name' => 'field_v','item_type'=>'page'))->
                        get('content_fields_data')->result();
                    if ($hrv == false) {
                        $dpvs = array(
                            'item_id' => $pid,
                            'item_type' => 'page',
                            'field_name' => 'field_v',
                            'data' => $v_nalichii);
                        $this->db->insert('content_fields_data', $dpvs);
                    } else {
                        $dpvs = array(
                            'item_id' => $pid,
                            'item_type' => 'page',
                            'field_name' => 'field_v',
                            'data' => $v_nalichii);
                        $where = "id = " . $hrv[0]->id . ' AND field_name = "field_v" AND item_type="page"';
                        $this->db->update('content_fields_data', $dpvs, $where);
                    }
                    ;
                    if ($cur == 'Евро') {
                        $priceR = '';
                        $priceE = $price;
                    } else {
                        $priceR = $price;
                        $priceE = '';
                    }
                    ;
                    //Заполнение цены RUR
                    $hrrur = $this->db->where(array('item_id' => $pid, 'field_name' => 'field_price','item_type'=>'page'))->
                        get('content_fields_data')->result();
                    if ($hrrur == false) {
                        $dprur = array(
                            'item_id' => $pid,
                            'item_type' => 'page',
                            'field_name' => 'field_price',
                            'data' => $priceR);
                        $this->db->insert('content_fields_data', $dprur);
                    } else {
                        $dprur = array(
                            'item_id' => $pid,
                            'item_type' => 'page',
                            'field_name' => 'field_price',
                            'data' => $priceR);
                        $where = "id = " . $hrrur[0]->id . ' AND field_name = "field_price" AND item_type="page"';
                        $this->db->update('content_fields_data', $dprur, $where);
                    }
                    ;
                    //Заполнение цены EUR
                    $hreur = $this->db->where(array('item_id' => $pid, 'field_name' =>
                            'field_price_EUR','item_type'=>'page'))->get('content_fields_data')->result();
                    if ($hreur == false) {
                        $dpeur = array(
                            'item_id' => $pid,
                            'item_type' => 'page',
                            'field_name' => 'field_price_EUR',
                            'data' => $priceE);
                        $this->db->insert('content_fields_data', $dpeur);
                    } else {
                        $dpeur = array(
                            'item_id' => $pid,
                            'item_type' => 'page',
                            'field_name' => 'field_price_EUR',
                            'data' => $priceE);
                        $where = "id = " . $hreur[0]->id . ' AND field_name = "field_price_EUR" AND item_type="page"';
                        $this->db->update('content_fields_data', $dpeur, $where);
                    }
                    ;

*/
                } else {
                    
               
                    //Если страница существует - получаем ее ID
                    $pid = $hr[0]->id;
                    /*var_dump($pid);
                    $where = "id = " . $pid;
                    //Обновляем страницу
                    $this->db->update('content', $page, $where);
                    
                    $where = "id = " . $pid;
                    //Обновляем страницу
                    $this->db->update('content', $page, $where);
                    
                    $where = "entity_id = " . $pid;
                    $rt = array(
                        'entity_id' => $pid,
                        'type' => 'page',
                        'parent_url' => $urlcats,
                        'url' => $url);
                    $this->db->update('route', $rt, $where);

                    //Проверяем на наличие поля галерея
                    $hrgal = $this->db->where(array('item_id' => $pid, 'field_name' =>
                            'field_gallery','item_type'=>'page'))->get('content_fields_data')->result();
                    if ($hrgal == false) {
                        $dpgal = array(
                            'item_id' => $pid,
                            'item_type' => 'page',
                            'field_name' => 'field_gallery',
                            'data' => $gallery);
                        $this->db->insert('content_fields_data', $dpgal);
                    } else {
                        $dpgal = array(
                            'item_id' => $pid,
                            'item_type' => 'page',
                            'field_name' => 'field_gallery',
                            'data' => $gallery);
                        $where = "id = " . $hrgal[0]->id . ' AND field_name = "field_gallery" AND item_type="page"';
                        $this->db->update('content_fields_data', $dpgal, $where);
                    }
                    ;
                    
                    //Фото - анонс
                    $hranons = $this->db->where(array('item_id' => $pid, 'field_name' =>
                            'field_image','item_type'=>'page'))->get('content_fields_data')->result();
                    if ($hranons == false) {
                        $dpanons = array(
                            'item_id' => $pid,
                            'item_type' => 'page',
                            'field_name' => 'field_image',
                            'data' => $photoanons);
                        $this->db->insert('content_fields_data', $dpanons);
                    } else {
                        $dpanons = array(
                            'item_id' => $pid,
                            'item_type' => 'page',
                            'field_name' => 'field_image',
                            'data' => $photoanons);
                        $where = "id = " . $hranons[0]->id . ' AND field_name = "field_image" AND item_type="page"';
                        $this->db->update('content_fields_data', $dpanons, $where);
                    }
                    ;
                    
                    //PDF файлы
                    $hrpdf = $this->db->where(array('item_id' => $pid, 'field_name' => 'field_docks','item_type'=>'page'))->
                        get('content_fields_data')->result();
                    if ($hrpdf == false) {
                        $dppdf = array(
                            'item_id' => $pid,
                            'item_type' => 'page',
                            'field_name' => 'field_docks',
                            'data' => $docfile);
                        $this->db->insert('content_fields_data', $dppdf);
                    } else {
                        $dppdf = array(
                            'item_id' => $pid,
                            'item_type' => 'page',
                            'field_name' => 'field_docks',
                            'data' => $docfile);
                        $where = "id = " . $hrpdf[0]->id . ' AND field_name = "field_docks" AND item_type="page"';
                        $this->db->update('content_fields_data', $dppdf, $where);
                    }
                    ;
                    //Артикул
                    $hrart = $this->db->where(array('item_id' => $pid, 'field_name' => 'field_sku','item_type'=>'page'))->
                        get('content_fields_data')->result();
                    if ($hrart == false) {
                        $dpart = array(
                            'item_id' => $pid,
                            'item_type' => 'page',
                            'field_name' => 'field_sku',
                            'data' => $art);
                        $this->db->insert('content_fields_data', $dpart);
                    } else {
                        $dpart = array(
                            'item_id' => $pid,
                            'item_type' => 'page',
                            'field_name' => 'field_sku',
                            'data' => $art);
                        $where = "id = " . $hrart[0]->id . ' AND field_name = "field_sku" AND item_type="page"';
                        $this->db->update('content_fields_data', $dpart, $where);
                    }
                    ;
                    //Свойства
                    $hrsv = $this->db->where(array('item_id' => $pid, 'field_name' => 'field_sv','item_type'=>'page'))->
                        get('content_fields_data')->result();
                    if ($hrsv == false) {
                        $dpsv = array(
                            'item_id' => $pid,
                            'item_type' => 'page',
                            'field_name' => 'field_sv',
                            'data' => $properties);
                        $this->db->insert('content_fields_data', $dpsv);
                    } else {
                        $dpsv = array(
                            'item_id' => $pid,
                            'item_type' => 'page',
                            'field_name' => 'field_sv',
                            'data' => $properties);
                        $where = "id = " . $hrsv[0]->id . ' AND field_name = "field_sv" AND item_type="page"';
                        $this->db->update('content_fields_data', $dpsv, $where);
                    }
                    ;
                    //Хит
                    $hrhit = $this->db->where(array('item_id' => $pid, 'field_name' => 'field_hit','item_type'=>'page'))->
                        get('content_fields_data')->result();
                    if ($hrhit == false) {
                        $dphit = array(
                            'item_id' => $pid,
                            'item_type' => 'page',
                            'field_name' => 'field_hit',
                            'data' => $hit);
                        $this->db->insert('content_fields_data', $dphit);
                    } else {
                        $dphit = array(
                            'item_id' => $pid,
                            'item_type' => 'page',
                            'field_name' => 'field_hit',
                            'data' => $hit);
                        $where = "id = " . $hrhit[0]->id . ' AND field_name = "field_hit" AND item_type="page"';
                        $this->db->update('content_fields_data', $dphit, $where);
                    }
                    ;
                    //Новинка
                    $hrnew = $this->db->where(array('item_id' => $pid, 'field_name' => 'field_new','item_type'=>'page'))->
                        get('content_fields_data')->result();
                    if ($hrnew == false) {
                        $dpnew = array(
                            'item_id' => $pid,
                            'item_type' => 'page',
                            'field_name' => 'field_new',
                            'data' => $new);
                        $this->db->insert('content_fields_data', $dpnew);
                    } else {
                        $dpnew = array(
                            'item_id' => $pid,
                            'item_type' => 'page',
                            'field_name' => 'field_new',
                            'data' => $new);
                        $where = "id = " . $hrnew[0]->id . ' AND field_name = "field_new" AND item_type="page"';
                        $this->db->update('content_fields_data', $dphit, $where);
                    }
                    ;
                    //Распродажа
                    $hrsale = $this->db->where(array('item_id' => $pid, 'field_name' => 'field_sale','item_type'=>'page'))->
                        get('content_fields_data')->result();
                    if ($hrsale == false) {
                        $dpsale = array(
                            'item_id' => $pid,
                            'item_type' => 'page',
                            'field_name' => 'field_sale',
                            'data' => $sale);
                        $this->db->insert('content_fields_data', $dpsale);
                    } else {
                        $dpsale = array(
                            'item_id' => $pid,
                            'item_type' => 'page',
                            'field_name' => 'field_sale',
                            'data' => $sale);
                        $where = "id = " . $hrsale[0]->id . ' AND field_name = "field_sale" AND item_type="page"';
                        $this->db->update('content_fields_data', $dpsale, $where);
                    }
                    ;
                    //Расширенный вид
                    $hrrs = $this->db->where(array('item_id' => $pid, 'field_name' => 'field_rs','item_type'=>'page'))->
                        get('content_fields_data')->result();
                    if ($hrrs == false) {
                        $dprs = array(
                            'item_id' => $pid,
                            'item_type' => 'page',
                            'field_name' => 'field_rs',
                            'data' => $variants);
                        $this->db->insert('content_fields_data', $dprs);
                    } else {
                        $dprs = array(
                            'item_id' => $pid,
                            'item_type' => 'page',
                            'field_name' => 'field_rs',
                            'data' => $variants);
                        $where = "id = " . $hrrs[0]->id . ' AND field_name = "field_rs" AND item_type="page"';
                        $this->db->update('content_fields_data', $dprs, $where);
                    }
                    ;
                    //Расширенный вид (маленький)
                    $hrrssmall = $this->db->where(array('item_id' => $pid, 'field_name' =>
                            'field_rssmall','item_type'=>'page'))->get('content_fields_data')->result();
                    if ($hrrssmall == false) {
                        $dprssmall = array(
                            'item_id' => $pid,
                            'item_type' => 'page',
                            'field_name' => 'field_rssmall',
                            'data' => $variants_small);
                        $this->db->insert('content_fields_data', $dprssmall);
                    } else {
                        $dprssmall = array(
                            'item_id' => $pid,
                            'item_type' => 'page',
                            'field_name' => 'field_rssmall',
                            'data' => $variants_small);
                        $where = "id = " . $hrrssmall[0]->id . ' AND field_name = "field_rssmall" AND item_type="page"';
                        $this->db->update('content_fields_data', $dprssmall, $where);
                    }
                    ;
                    //Дополнительный заголовок
                    $hrdptitle = $this->db->where(array('item_id' => $pid, 'field_name' =>
                            'field_name','item_type'=>'page'))->get('content_fields_data')->result();
                    if ($hrdptitle == false) {
                        $dpdptitle = array(
                            'item_id' => $pid,
                            'item_type' => 'page',
                            'field_name' => 'field_name',
                            'data' => $dptitle);
                        $this->db->insert('content_fields_data', $dpdptitle);
                    } else {
                        $dpdptitle = array(
                            'item_id' => $pid,
                            'item_type' => 'page',
                            'field_name' => 'field_name',
                            'data' => $dptitle);
                        $where = "id = " . $hrdptitle[0]->id . ' AND field_name = "field_name" AND item_type="page"';
                        $this->db->update('content_fields_data', $dpdptitle, $where);
                    }
                    ;
                    //Технические характеристики
                    $hrtech = $this->db->where(array('item_id' => $pid, 'field_name' => 'field_tech','item_type'=>'page'))->
                        get('content_fields_data')->result();
                    if ($hrtech == false) {
                        $dptech = array(
                            'item_id' => $pid,
                            'item_type' => 'page',
                            'field_name' => 'field_tech',
                            'data' => $tech_item);
                        $this->db->insert('content_fields_data', $dptech);
                    } else {
                        $dptech = array(
                            'item_id' => $pid,
                            'item_type' => 'page',
                            'field_name' => 'field_tech',
                            'data' => $tech_item);
                        $where = "id = " . $hrtech[0]->id . ' AND field_name = "field_tech" AND item_type="page"';
                        $this->db->update('content_fields_data', $dptech, $where);
                    }
                    ;
                    //Особенности модели
                    $hrfeatures = $this->db->where(array('item_id' => $pid, 'field_name' =>
                            'field_features','item_type'=>'page'))->get('content_fields_data')->result();
                    if ($hrfeatures == false) {
                        $dpfeatures = array(
                            'item_id' => $pid,
                            'item_type' => 'page',
                            'field_name' => 'field_features',
                            'data' => $mode_features);
                        $this->db->insert('content_fields_data', $dpfeatures);
                    } else {
                        $dpfeatures = array(
                            'item_id' => $pid,
                            'item_type' => 'page',
                            'field_name' => 'field_features',
                            'data' => $mode_features);
                        $where = "id = " . $hrfeatures[0]->id . ' AND field_name = "field_features" AND item_type="page"';
                        $this->db->update('content_fields_data', $dpfeatures, $where);
                    }
                    ;
                    //Ссылки на youtube
                    $hryou = $this->db->where(array('item_id' => $pid, 'field_name' => 'field_you','item_type'=>'page'))->
                        get('content_fields_data')->result();
                    $youtube_container = str_replace(' ', ',', $youtube_container);
                    $PCREpattern = '/\r\n|\r|\n/u';
                    $youtube_container = preg_replace($PCREpattern, ',', $youtube_container);
                    if ($hryou == false) {
                        $dpyou = array(
                            'item_id' => $pid,
                            'item_type' => 'page',
                            'field_name' => 'field_you',
                            'data' => $youtube_container);
                        $this->db->insert('content_fields_data', $dpyou);
                    } else {
                        $dpyou = array(
                            'item_id' => $pid,
                            'item_type' => 'page',
                            'field_name' => 'field_you',
                            'data' => $youtube_container);
                        $where = "id = " . $hryou[0]->id . ' AND field_name = "field_you" AND item_type="page"';
                        $this->db->update('content_fields_data', $dpyou, $where);
                    }
                    ;
                    //Ссылки на youtube
                    $hrv = $this->db->where(array('item_id' => $pid, 'field_name' => 'field_v','item_type'=>'page'))->
                        get('content_fields_data')->result();
                    if ($hrv == false) {
                        $dpvs = array(
                            'item_id' => $pid,
                            'item_type' => 'page',
                            'field_name' => 'field_v',
                            'data' => $v_nalichii);
                        $this->db->insert('content_fields_data', $dpvs);
                    } else {
                        $dpvs = array(
                            'item_id' => $pid,
                            'item_type' => 'page',
                            'field_name' => 'field_v',
                            'data' => $v_nalichii);
                        $where = "id = " . $hrv[0]->id . ' AND field_name = "field_v" AND item_type="page"';
                        $this->db->update('content_fields_data', $dpvs, $where);
                    }
                    ;
                    if ($cur == 'Евро') {
                        $priceR = '';
                        $priceE = $price;
                    } else {
                        $priceR = $price;
                        $priceE = '';
                    }
                    ;
                    //Заполнение цены RUR
                    $hrrur = $this->db->where(array('item_id' => $pid, 'field_name' => 'field_price','item_type'=>'page'))->
                        get('content_fields_data')->result();
                    if ($hrrur == false) {
                        $dprur = array(
                            'item_id' => $pid,
                            'item_type' => 'page',
                            'field_name' => 'field_price',
                            'data' => $priceR);
                        $this->db->insert('content_fields_data', $dprur);
                    } else {
                        $dprur = array(
                            'item_id' => $pid,
                            'item_type' => 'page',
                            'field_name' => 'field_price',
                            'data' => $priceR);
                        $where = "id = " . $hrrur[0]->id . ' AND field_name = "field_price" AND item_type="page"';
                        $this->db->update('content_fields_data', $dprur, $where);
                    }
                    ;
                    //Заполнение цены EUR
                    $hreur = $this->db->where(array('item_id' => $pid, 'field_name' =>
                            'field_price_EUR','item_type'=>'page'))->get('content_fields_data')->result();
                    if ($hreur == false) {
                        $dpeur = array(
                            'item_id' => $pid,
                            'item_type' => 'page',
                            'field_name' => 'field_price_EUR',
                            'data' => $priceE);
                        $this->db->insert('content_fields_data', $dpeur);
                    } else {
                        $dpeur = array(
                            'item_id' => $pid,
                            'item_type' => 'page',
                            'field_name' => 'field_price_EUR',
                            'data' => $priceE);
                        $where = "id = " . $hreur[0]->id . ' AND field_name = "field_price_EUR" AND item_type="page"';
                        $this->db->update('content_fields_data', $dpeur, $where);
                    }
                    ;*/
                    //Сопутствующие товары
                    var_dump($pid);
                    foreach ($sp_tvаfull as $onet){
                    $hrTVs = $this->db->where(array('item_id' => $pid, 'field_name' =>
                            'field_relative_tovs','item_type'=>'page','data'=>$onet))->get('content_fields_data')->result();
                    if ($hrTVs == false) {
                        $dpTVs = array(
                            'item_id' => $pid,
                            'item_type' => 'page',
                            'field_name' => 'field_relative_tovs',
                            'data' => $onet);
                        $this->db->insert('content_fields_data', $dpTVs);
                    } else {
                        $dpTVs = array(
                            'item_id' => $pid,
                            'item_type' => 'page',
                            'field_name' => 'field_relative_tovs',
                            'data' => $onet);
                        $where = "id = " . $hreur[0]->id . ' AND field_name = "field_relative_tovs" AND item_type="page"';
                        $this->db->update('content_fields_data', $dpTVs, $where);
                    }
                    ;
                    
                };
                };
                
            }
            ;
            
        }
        ;
    }

    public function allp()
    {
        include ('simple_html_dom.php');
        $html = file_get_html('http://www.putzmeister.ru/service/spares/betononasosy/');
        //$html = file_get_html('http://www.putzmeister.ru/service/spares/rastvoronasosy/');
        $arnews = array();
        $i = 0;
        foreach ($html->find('.row_ps_new .iinew>.item') as $element) {
            $i++;
            if ($i < 10) {
                $href = trim($element->href);
                $href = substr($href, 0, -1);
                echo '<pre>';
                var_dump('http://www.putzmeister.ru' . $href . '.xml');
                echo '</pre>';
            }
            ;
        }

    }

}
/* End of file sample_module.php */

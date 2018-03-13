<?php

(defined('BASEPATH')) or exit('No direct script access allowed');

/**
 * Image CMS
 * Module Frame
 */
class Module_frame extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $lang = new MY_Lang();
        $lang->load('module_frame');
    }

    public function index()
    {

    }

    public function autoload()
    {

    }

    public function _install()
    {
        /** We recomend to use http://ellislab.com/codeigniter/user-guide/database/forge.html */
        /**
         * $this->load->dbforge();

         * $fields = array(
         * 'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => TRUE,),
         * 'name' => array('type' => 'VARCHAR', 'constraint' => 50,),
         * 'value' => array('type' => 'VARCHAR', 'constraint' => 100,)
         * );

         * $this->dbforge->add_key('id', TRUE);
         * $this->dbforge->add_field($fields);
         * $this->dbforge->create_table('mod_empty', TRUE);
         */
        /**
         * $this->db->where('name', 'module_frame')
         * ->update('components', array('autoload' => '1', 'enabled' => '1'));
         */
    }


    public function _deinstall()
    {
        /**
         * $this->load->dbforge();
         * $this->dbforge->drop_table('mod_empty');
         *
         */
    }
    function get_cat($link)
    {

        $html = file_get_html($link);

        $headers["title"] = $html->find("title", 0)->plaintext;

        if (!is_null($html->find("meta[name=keywords]", 0))) {

            $headers["keywords"] = $html->find("meta[name=keywords]", 0)->getAttribute('content');

        }

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
    function dumpx()
    {

        include ('shd.php');
        $html = file_get_html('http://www.putzmeister.ru/scopes/pumps/dobyvayushchaya-promyshlennost/');
        $arnews = array();
        $cnt = 7;
        $aa = 0;
        foreach ($html->find('.rt-side li a') as $element) {

            $aa++;


            $temp = $element->innertext();

            $link = $element->href;


            echo $link . '<hr>';
            $this->pages($link);

        }


    }

    function pages($link)
    {


        $html = file_get_html('http://www.putzmeister.ru' . $link);
        foreach ($html->find('.one-news .list-item  li a') as $element) {

            $temp = $element->innertext();


            $link = $element->href;
            $tar = explode('/', $link);

            $url = $tar[6];


            $ft = $this->get_news_page2($link);
            
            
            
            
            $temp1 = str_get_html($temp);
            
            $tit=$temp1->find('.name',0)->innertext();
            
            

            $xr = array(
                'title' => $tit,
                'prev_text' => $ft['text'],
                'full_text' => '<p>&nbsp;</p>',
                'meta_title' => $ft['title'],
                'description' => $ft['description'],
                'keywords' => $ft['keywords'],
                'publish_date' => time(),
                'created' => time(),
                'updated' => time(),
                'category' => '167',
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


            echo $url . '<br>';
         
        }

    }

    function get_news_page2($link)
    {

        $html = file_get_html($link);

        $headers["title"] = $html->find("title", 0)->plaintext;
        if (!is_null($html->find("meta[name=keywords]", 0))) {

            $headers["keywords"] = $html->find("meta[name=keywords]", 0)->getAttribute('content');

        }

        $headers["description"] = $html->find("meta[name=description]", 0)->
            getAttribute('content');


        $xt = $html->find('h1', 0)->innertext();
        $temp1 = str_get_html($xt);


        $xx = $html->find('.text-block div', 1)->innertext();

        $x = str_replace('/images/', '/uploads/', $xx);

        $headers["text"] = $x;

        return $headers;
    }


    function dump()
    {

        include ('shd.php');
        $html = file_get_html('http://www.putzmeister.ru/scopes/pumps/dobyvayushchaya-promyshlennost/');
        $arnews = array();
        $cnt = 7;
        $aa = 0;
        foreach ($html->find('.rt-side li a') as $element) {

            $aa++;


            $temp = $element->innertext();

            $link = $element->href;
            $za = explode('/', $link);
            $cpu = $za[count($za) - 2];


            $ft = $this->get_cat('http://www.putzmeister.ru' . $element->href);


            $xr = array(
                'name' => $temp,
                'short_desc' => '',
                'title' => $ft['title'],
                'description' => $ft['description'],
                'keywords' => $ft['keywords'],
                'parent_id' => 44,
                'fetch_pages' => 'b:0;',
                'main_tpl' => '',
                'image' => $image,
                'tpl' => 'category_info',
                'position' => $cnt,
                'order_by' => 'publish_date',
                'sort_order' => 'desc',
                'page_tpl' => '',
                'field_group' => 0,
                'settings' => 'a:2:{s:26:"category_apply_for_subcats";b:0;s:17:"apply_for_subcats";b:0;}',
                'created' => time(),
                'updated' => time(),
                );
            $this->db->insert('category', $xr);
            $pid = $this->db->insert_id();


            $xa = array(
                'type' => 'category',
                'parent_url' => 'scopes/pumps',
                'url' => $cpu,
                'entity_id' => $pid);

            $this->db->insert('route', $xa);

            $rid = $this->db->insert_id();

            $data = array('route_id' => $rid);
            $this->db->where('id', $pid);
            $this->db->update('category', $data);


            $cnt++;


        }


    }


}

/* End of file sample_module.php */

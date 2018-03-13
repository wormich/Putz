<?php

use CMSFactory\Events;
use core\src\CoreFactory;
use core\src\Kernel;
use core\src\RouteSubscriber;

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 *
 * Image CMS
 *
 * core.php
 * @property Cms_base $cms_base
 * @property Lib_category $lib_category
 * @property Cfcm $cfcm
 * @property Lib_seo lib_seo
 */
class Core extends MY_Controller
{

    /**
     * @var array
     */
    public $cat_content;

    /**
     * @var int
     */
    public $page_content;

    /**
     * @var array
     */
    public $core_data = ['data_type' => null];

    /**
     * @var array
     */
    public $settings = [];

    /**
     * @var array
     */
    public $def_lang = []; // Modules array

    /**
     * @var array
     */
    public $langs = [];

    public function __construct()
    {

        parent::__construct();
        Modules::$registry['core'] = $this;
        $lang = new MY_Lang();
        $lang->load('core');
        $this->settings = $this->cms_base->get_settings();
        $this->langs = CoreFactory::getModel()->getLanguages();
        $this->def_lang = [CoreFactory::getModel()->getDefaultLanguage()];

        $this->lib_category->setLocaleId(MY_Controller::getCurrentLanguage('id'));

    }

    public function index()
    {
        (new Kernel($this, CI::$APP))->run();
    }

    /**
     * Used in other modules
     * todo: move(and simplify) or remove
     * @param $n
     * @return array
     */
    public function grab_variables($n)
    {

        $args = [];

        foreach ($this->uri->uri_to_assoc($n) as $k => $v) {
            if (isset($k)) {
                array_push($args, $k);
            }
            if (isset($v)) {
                array_push($args, $v);
            }
        }

        $count = count($args);
        for ($i = 0, $cnt = $count; $i < $cnt; $i++) {
            if ($args[$i] === false) {
                unset($args[$i]);
            }
        }

        return $args;
    }

    /**
     * Display error template end exit
     * @param string $text
     * @param bool $back
     */
    public function error($text, $back = true)
    {

        $this->template->add_array(['content' => $this->template->read('error', ['error_text' =>
            $text, 'back_button' => $back]), ]);

        $this->template->show();
        exit;
    }

    /**
     * Page not found
     * Show 404 error
     */
    public function error_404()
    {

        header('HTTP/1.1 404 Not Found');
        $this->set_meta_tags(lang('Page not found', 'core'));
        $this->template->assign('error_text', lang('Page not found.', 'core'));
        $this->template->show('404');
        exit;
    }

    /**
     * Set meta tags for pages
     * @param string $title
     * @param string $keywords
     * @param string $description
     * @param string $page_number
     * @param int $showsitename
     * @param string $category
     */
    public function set_meta_tags($title = '', $keywords = '', $description = '', $page_number =
        '', $showsitename = 0, $category = '')
    {

        if ($this->core_data['data_type'] == 'main') {
            $this->template->add_array(['site_title' => empty($this->settings['site_title']) ?
                $title : $this->settings['site_title'], 'site_description' => empty($this->
                settings['site_description']) ? $description : $this->settings['site_description'],
                'site_keywords' => empty($this->settings['site_keywords']) ? $keywords : $this->
                settings['site_keywords'], ]);
        } else {
            if (($page_number > 1) && ($page_number != '')) {
                $title = lang('Page', 'core') . ' №' . $page_number . ' - ' . $title;
            }

            if ($description != '') {
                if ($page_number > 1 && $page_number != '') {
                    $description = "$page_number - $description {$this->settings['delimiter']} {$this->settings['site_short_title']}";
                } else {
                    //$description = "$description {$this->settings['delimiter']} {$this->settings['site_short_title']}";
                    $description = "$description";
                }
            }

            if ($this->settings['add_site_name_to_cat']) {
                if ($category != '') {
                    $title .= ' - ' . $category;
                }
            }

            if ($this->core_data['data_type'] == 'page' and $this->page_content['category'] !=
                0 and $this->settings['add_site_name_to_cat']) {
                $title .= ' ' . $this->settings['delimiter'] . ' ' . $this->cat_content['name'];
            }

            if (is_array($title)) {
                $n_title = '';
                foreach ($title as $k => $v) {
                    $n_title .= $v;

                    if ($k < count($title) - 1) {
                        $n_title .= ' ' . $this->settings['delimiter'] . ' ';
                    }
                }
                $title = $n_title;
            }

            if ($this->settings['add_site_name'] == 1 && $showsitename != 1) {
                $title .= ' ' . $this->settings['delimiter'] . ' ' . $this->settings['site_short_title'];
            }

            if ($this->settings['create_description'] == 'empty') {
                $description = '';
            }
            if ($this->settings['create_keywords'] == 'empty') {
                $keywords = '';
            }


            /**/
            if ($this->core_data['data_type'] == 'page' and $this->page_content['category'] !=
                0 && $this->page_content['category'] != 3) {


                $cat = $this->page_content['full_url'];
                $suka = explode('/', $cat);
                $url = $suka[0];


                $url2 = $suka[2];


                $this->db->where('url', $url);


                $this->db->where('type', 'category');


                $q = $this->db->get('route');


                $row = $q->row_array();


                $id = $row['entity_id'];
                switch ($id) {
                    case 1:


                        $title = $this->page_content['title'] . ' ' . ' – новости компании Putzmeister';


                        if ($description == '') {

                            if (isset($this->page_content['prev_text']) && strip_tags($this->page_content['prev_text']) !=
                                '') {

                                preg_match('|^(.*?)</p>|i', $this->page_content['prev_text'], $matched);

                                $description = preg_replace('/[^\p{L}0-9 ]/iu', '', strip_tags($matched[1]));
                            } else {
                                preg_match('|^(.*?)</p>|i', $this->page_content['full_text'], $matched);

                                $description = preg_replace('/[^\p{L}0-9 ]/iu', '', strip_tags($matched[1]));
                            }


                        }

                        break;
                    case 42:
                        $title = $this->page_content['title'] . ' ' .
                            ' –  Статьи официального сайта компании Putzmeister';

if (isset($this->page_content['prev_text']) && strip_tags($this->page_content['prev_text']) !=
                            '') {

                            preg_match('|^(.*?)</p>|i', $this->page_content['prev_text'], $matched);

                            $description = preg_replace('/[^\p{L}0-9 ]/iu', '', strip_tags($matched[1]));
                        } else {
                            preg_match('|^(.*?)</p>|i', $this->page_content['full_text'], $matched);

                            $description = preg_replace('/[^\p{L}0-9 ]/iu', '', strip_tags($matched[1]));
                        }
                        break;
                    case 43:
                    
                    
                        $title = strip_tags($this->page_content['title']) . ' ' .
                            ' –  Статьи официального сайта компании Putzmeister';
                        if (isset($this->page_content['prev_text']) && strip_tags($this->page_content['prev_text']) !=
                            '') {

                            preg_match('|^(.*?)</p>|i', $this->page_content['prev_text'], $matched);

                            $description = preg_replace('/[^\p{L}0-9 ]/iu', '', strip_tags($matched[1]));
                        } else {
                            preg_match('|^(.*?)</p>|i', $this->page_content['full_text'], $matched);

                            $description = preg_replace('/[^\p{L}0-9 ]/iu', '', strip_tags($matched[1]));
                        }

                        break;
                    case 3:


                        //Запчасти. Шаблоны мета тегов

                        /*
                        
                        Descriptions – *Название товара* (*артикул*) для *Название оборудования* на официальном сайте Putzmeister. Обслуживание по всем регионам России. 
                        Keywords – *название оборудования* *название товара* (*артикул*) продажа цена купить путцмейстер
                        H1 - *Название товара* для *Название оборудования*
                        */
                        $prr = $this->page_content['field_price'];

                        if ($this->page_content['field_price_EUR'] > 0) {


                            if (!isset($prr) || $prr == 0 || $prr == '') {
                                $cur_cb = file_get_contents("https://www.cbr-xml-daily.ru/daily_utf8.xml");

                                preg_match_all("#<ValCurs Date=\"(.*)\" name=\"Foreign Currency Market\">#sU", $cur_cb,
                                    $_cur_date);
                                preg_match_all("#<Valute ID=\"R01235\">.*<CharCode>(.*)</CharCode>.*<Value>(.*)</Value>.*</Valute>#sU",
                                    $cur_cb, $_usd);
                                preg_match_all("#<Valute ID=\"R01239\">.*<CharCode>(.*)</CharCode>.*<Value>(.*)</Value>.*</Valute>#sU",
                                    $cur_cb, $_eur);

                                $cur_date = $_cur_date[1][0];

                                $eur = $_eur[2][0];
                                $result = round($this->page_content['field_price_EUR'] * $eur, 0);

                                $x = (string )$result;

                                $result = str_replace(',', '.', $x);
                                $prr = $result;

                            }
                        }

                        if ($prr != '' & $prr > 0) {


                            $prad = ' - купить по цене ' . $prr . ' рублей';
                        }


                        $this->db->where('url', $url2);


                        $this->db->where('type', 'category');

                        $this->db->join('category', 'category.id = route.entity_id', 'left');
                        $q = $this->db->get('route');


                        $rox = $q->row_array();
                        $cat = '';
                        if (is_array($rox)) {

                            $cat = mb_strtolower($rox['name'], "UTF-8");
                            $cat = 'для' . explode('для', $cat)[1];

                        }

                        if ($this->page_content['field_sku'] != '') {

                            $cf = ', (' . $this->page_content['field_sku'] . ') ';

                        }
                        $title = $this->page_content['title'] . ' ' . $cat . $cf . $prad .
                            ' – Putzmeister';


                        $description = $this->page_content['title'] . ' ' . $cat .
                            ' на официальном сайте Putzmeister. Обслуживание по всем регионам России.';
                        $keywords = mb_strtolower($this->page_content['title'] . ' ' . $cat, "UTF-8");
                        break;


                }


            }


            $page_number = $page_number ? : (int)$this->pagination->cur_page;
            $this->template->add_array(['site_title' => $title, 'site_description' =>
                htmlspecialchars($description), 'site_keywords' => htmlspecialchars($keywords),
                'page_number' => $page_number, ]);
        }
    }

    /**
     *
     * @param string $description
     * @param null|string $text
     * @return string
     */
    public function _makeDescription($description, $text = null)
    {

        if ($this->settings['create_description'] == 'auto' && !$description) {
            $description = $this->lib_seo->get_description($text);
        }

        return $description;
    }

    /**
     *
     * @param string $keywords
     * @param string $text
     * @return string
     */
    public function _makeKeywords($keywords, $text)
    {

        if ($this->settings['create_keywords'] == 'auto' && !$keywords) {
            $keywords = $this->lib_seo->get_keywords($text, true);

            $keywords = implode(', ', array_keys($keywords));
        }

        return $keywords;
    }

    public function robots()
    {

        $robotsSettings = $this->db->select('robots_settings,robots_settings_status,robots_status')->
            get('settings');
        if ($robotsSettings) {
            $robotsSettings = $robotsSettings->row();
        }

        header('Content-type: text/plain');
        if ($robotsSettings->robots_status == '1') {
            if ($robotsSettings->robots_settings_status == '1') {
                if (trim($robotsSettings->robots_settings)) {
                    echo $robotsSettings->robots_settings;
                    exit;
                } else {
                    header('Content-type: text/plain');
                    echo "User-agent: * \r\nDisallow: /";
                    echo "\r\nHost: " . $this->input->server('HTTP_HOST');
                    echo "\r\nSitemap: " . site_url('sitemap.xml');
                    exit;
                }
            } else {

                header('Content-type: text/plain');
                echo "User-agent: * \r\nDisallow: ";
                echo "\r\nHost: " . $this->input->server('HTTP_HOST');
                echo "\r\nSitemap: " . site_url('sitemap.xml');
                exit;
            }
        } else {
            header('Content-type: text/plain');
            echo "User-agent: * \r\nDisallow: /";
            echo "\r\nHost: " . $this->input->server('HTTP_HOST');
            echo "\r\nSitemap: " . site_url('sitemap.xml');
            exit;
        }
    }

    /**
     *
     * @param int $LastModified_unix
     * @return void
     */
    public function setLastModified($LastModified_unix)
    {

        if ($LastModified_unix < time() - 60 * 60 * 24 * 4 or $LastModified_unix > time
            ()) {
            if (in_array(date('D', time()), ['Mon', 'Tue', 'Wen'])) {
                $LastModified_unix = strtotime('last sunday', time());
            } else {
                $LastModified_unix = strtotime('last thursday', time());
            }
        }

        $LastModified = date('D, d M Y H:i:s \G\M\T', $LastModified_unix);
        $IfModifiedSince = false;

        if ($this->input->server('HTTP_IF_MODIFIED_SINCE')) {
            $IfModifiedSince = strtotime(substr($this->input->server('HTTP_IF_MODIFIED_SINCE'),
                5));
        }
        if ($IfModifiedSince && $IfModifiedSince >= $LastModified_unix) {
            header($this->input->server('SERVER_PROTOCOL') . ' 304 Not Modified');
            return;
        }
        header('Last-Modified: ' . $LastModified);
    }

    public static function adminAutoload()
    {
        $subscriber = new RouteSubscriber();

        foreach ($subscriber->getHandlers() as $eventName => $callback) {

            Events::create()->on($eventName)->setListener([$subscriber, $callback]);

        }

        $events = ['ShopAdminCategories:create', 'ShopAdminCategories:edit',
            'ShopAdminCategories:delete', 'ShopAdminCategories:fastCreate',
            'ShopAdminCategories:ajaxChangeShowInSite', 'ShopAdminProducts:create',
            'ShopAdminProducts:edit', 'ShopAdminProducts:delete',
            'ShopAdminProducts:fastProdCreate', 'ShopAdminProducts:ajaxChangeActive',
            'ShopAdminProducts:ajaxChangeStatus', 'ShopAdminProperties:fastCreate',
            'ShopAdminProperties:create', 'ShopAdminProperties::delete',
            'ShopAdminProperties:edit', ];

        foreach ($events as $event) {

            Events::create()->on($event)->setListener(function ()
            {

                MY_Controller::dropCache(); }
            );

        }

    }

}

/* End of file core.php */

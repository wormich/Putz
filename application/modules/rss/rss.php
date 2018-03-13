<?php

use CMSFactory\assetManager;
use CMSFactory\ModuleSettings;

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Image CMS
 *
 * RSS Module
 * @property Lib_category lib_category
 */
class Rss extends MY_Controller
{

    private $settings = [];

    private $rss_header = '<?xml version="1.0" encoding="UTF-8"?>';

    private $cache_key = 'rss';

    public function __construct() {

        parent::__construct();
        $lang = new MY_Lang();
        $lang->load('rss');
    }

    /**
     *
     */
    public function index() {

        if (($content = $this->cache->fetch($this->cache_key)) === FALSE) {
            $this->load->library('lib_category');

            $this->settings = ModuleSettings::ofModule('rss')->get();

            if ($this->settings['pages_count'] == 0) {
                $this->settings['pages_count'] = 10;
            }

            $pages = $this->get_pages();

            $cnt = count($pages);
            if ($cnt > 0) {
                for ($i = 0; $i < $cnt; $i++) {
                    $pages[$i]['prev_text'] = htmlspecialchars_decode($pages[$i]['prev_text']);

                    if ($pages[$i]['category'] > 0) {
                        $category = $this->lib_category->get_category($pages[$i]['category']);
                        $pages[$i]['title'] = $category['name'] . ' / ' . $pages[$i]['title'];
                        $pages[$i]['publish_date'] = gmdate('D, d M Y H:i:s', $pages[$i]['publish_date']) . ' GMT';
                    }
                }
            }

            $tpl_data = [
                         'header'      => $this->rss_header,
                         'title'       => $this->settings['title'],
                         'description' => $this->settings['description'],
                         'pub_date'    => gmdate('D, d M Y H:i:s', time()) . ' GMT',
                         'items'       => $pages,
                        ];

            $content = assetManager::create()
                ->setData($tpl_data)
                ->fetchTemplate('feed_theme');

            $this->cache->store($this->cache_key, $content, $this->settings['cache_ttl'] * 60);
        }

        echo $content;
    }

    /**
     * Load pages
     */
    private function get_pages() {

        $this->db->select('IF(route.parent_url <> \'\', concat(route.parent_url, \'/\', route.url), route.url) as full_url, content.id, title, prev_text, publish_date, category, author', FALSE);
        $this->db->where('post_status', 'publish');
        $this->db->join('route', 'route.id=content.route_id');
        $this->db->where('prev_text !=', 'null');
        $this->db->where('publish_date <=', time());

        if (count($this->settings['categories']) > 0) {
            $this->db->where_in('category', $this->settings['categories']);
        }

        $this->db->order_by('publish_date', 'desc');
        $query = $this->db->get('content', $this->settings['pages_count']);

        return $query->result_array();
    }

    public function _install() {

        if ($this->dx_auth->is_admin() == FALSE) {
            return;
        }

        // Enable module url access
        $this->db->where('name', 'rss');
        $this->db->update('components', ['enabled' => '1']);
    }

}

/* End of file sample_module.php */
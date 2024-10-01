<?php
namespace App\View\Helper;
use Cake\View\Helper\HtmlHelper;
use Cake\View\Helper\UrlHelper;
use Cake\View\View;
use Cake\View\Helper;

use Cake\Routing\Router;

class UrloverrideHelper extends UrlHelper{

    public function build(array|string|null $url = null, array $options = []): string
    {
        $defaults = [
            'fullBase' => false,
            'escape' => true,
            'tagarray'=>null,
        ];
        $options += $defaults;
        //left this here in case we need it, POC passing tagarray to our URL builder
        $tar=$options['tagarray'];

        //$url[0] is the tagstring
        if ((is_array($url) && isset($url['_ext']) && $url['_ext']==='rss')
            && (!isset($url[0]) || empty($url[0]))){
            $url=[
              '_name'=>'index',
              '_ext'=>'rss',
            ];
        }

        /* now resume default */
        $urlstring = Router::url($url, $options['fullBase']);
        if ($options['escape']) {
            return (string)h($urlstring);
        }

        return $urlstring;
    }
}
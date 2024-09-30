<?php
namespace App\View\Helper;
use Cake\View\Helper;
use Cake\View\Helper\UrlHelper;
use Cake\View\View;

use Cake\Routing\Router;

class RssHelper extends Helper{
    public function initialize(array $config): void {
       // debug($config);
    }
    public function link($params,$tagarray){
      //debug($params);
      $tagstr=\is_array($tagarray)?\implode('-',$tagarray):'';
      $self_url=Router::url(['controller'=>'conferences','action'=>'index',$tagstr,'_ext'=>'rss'],true);
      
      if (!str_contains($params['_matchedRoute'],'conferences/')){
        $self_url=str_replace('conferences/','',$self_url);
      } 
      return $self_url;
    }
}
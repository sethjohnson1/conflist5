<?php
/* /app/views/helpers/ical.php */
namespace App\View\Helper;
use Cake\View\Helper;
use Cake\View\View;

class GcalHelper extends Helper{
    public function initialize(array $config): void {
       // debug($config);
    }
    public function gcal_url($id, $start_date, $end_date, $title, $city, $country, $url) {
      $start_string = $start_date->format('Ymd');
      $end_string = $end_date->modify('+1 day')->format('Ymd');
      $location = $city."; ".$country;
      $Gcal_url = "http://www.google.com/calendar/event?action=TEMPLATE&".
        "text=".urlencode($title)."&".
        "dates=".$start_string."/".$end_string.
        "&details=".$url.
        "&location=".urlencode($location);
      return $Gcal_url;
    }
    public function gcal($conference) {
      return $this->gcal_url($conference['id'], 
         $conference['start_date'], 
         $conference['end_date'],
         $conference['title'],
         $conference['city'],
         $conference['country'],
         $conference['homepage']
         );

    }
}
?>

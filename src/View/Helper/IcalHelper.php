<?php
namespace App\View\Helper;
use Cake\View\Helper;
use Cake\View\View;

class IcalHelper extends Helper{
  public function initialize(array $config): void    {
       // debug($config);
  }

  public function vcal_begin() {
    return "BEGIN:VCALENDAR\n".
      "VERSION:2.0\n";
  }

  public function vcal_end() {
    return "END:VCALENDAR";
  }

  public function vcal_event($id, $start_date, $end_date, $title, $city, $country, $homepage) {
    $start_string = $start_date->format('Ymd');
    $end_string = $end_date->modify('+1 day')->format('Ymd');
    $location = $city."; ".$country;
    $vcal = "BEGIN:VEVENT\n".
      "DTSTART:".$start_string."\n".
      "DTEND:".$end_string."\n".
      "LOCATION:".$location."\n".
      "SUMMARY:".$title."\n".
      "URL:".$homepage."\n".
      "END:VEVENT\n";
    return $vcal;  
  }

  public function vcal($conferences) {
    // takes an array of conferences and outputs a vcalendar
    $vcal = $this->vcal_begin();
    foreach ($conferences as $conference) {
      $vcal .= $this->vcal_event($conference['id'], 
               $conference['start_date'], 
               $conference['end_date'],
               $conference['title'],
               $conference['city'],
               $conference['country'],
               $conference['homepage']
               );
    }
    $vcal .= $this->vcal_end();
    return $vcal;
  }
}

?>

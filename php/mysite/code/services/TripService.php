<?php

     	#doc
	#	classname:	TwitterTask
        #	scope:          PUBLIC
        #
	#/This task checks twitter ever hour for the latest updates

class TripService implements WebServiceable {

    public function __construct() {
        $this->GAPIKey = "AIzaSyB_MpeZnqXa-4ltbki0N0iCY70sVYxKLpM";

    }
    
    public function publicWebMethods() {
        return array(
            'query'      => 'GET',
            'test' => 'GET'
        );
    }

    public function myMethod($param) {
        return array(
            'SomeParam'         => 'Goes here',
            'Boolean'           => true,
            'Return'            => $param,
        );
    }

    public function test(){
        $window=5;
        $today = date('Y-m-d 00:00:00');
        $prevdate = date('Y-m-d 00:00:00', mktime(0, 0, 0, date("m")  , date("d")-$window, date("Y")));
        $query = new SQLQuery();
        // $result = $query->setFrom('trip')->setSelect('*')->addWhere("purpose = 'Commute'")->addWhere("start BETWEEN '".$prevdate."' AND '".$today."'")->execute();
        $result = $query->setFrom('user')->setSelect('*')->addWhere("email = 'l@emelle.me'")->execute();
        $tripdata = array();
        foreach($result as $row) {
            var_dump($row);
            //array_push($trips, $row);
        }
        return array(
            'trips' => array('test'=>2,'test2'));
    }
       



    public function query(){
        //Search
        $controller = Director::get_current_page();
        $latestQuery = $controller->getRequest()->requestVar('latestQuery');
        $a = array();
        $start = $controller->getRequest()->requestVar('start');
        $start = (@!empty($start)) ? $start : 1 ;
        
        $sql = "https://www.googleapis.com/customsearch/v1?key=".$this->GAPIKey."&cx=008412048315283472498:hpaolvuy8y4&q=".$latestQuery.'&start='.$start.'&alt=json';
        $r = new RestfulService($sql,$expiry = 300);
        $resp = $r->request();
        $results = null;
        $status = $resp->getStatusCode();
        if ($status != 200){
            $b = array('title' =>'Site Maintanence',
            'link' => '',
            'snippet' => 'Site Maintanence');
            array_push($a,$b);
            var_dump($resp->getBody());
            return $a;
        }else{
            $results = json_decode($resp->getBody());
            foreach ($results->items as $r) {

                $b = array('title' =>$r->title,
                'link' => $r->link,
                'snippet' => $r->snippet);
                array_push($a,$b);
            }
            return $a;
        }
        
    }

}
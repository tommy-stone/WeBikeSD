<?php

     	#doc
	#	classname:	TwitterTask
        #	scope:          PUBLIC
        #
	#/This task checks twitter ever hour for the latest updates

class IndegoService implements WebServiceable {

    public function __construct() {
        $this->FBURL = "https://cyclephilly.firebaseio.com";
        $this->FBSecret = "bi7GsULLfYOxmv47jt3gh2rgnN5XvjlnpLVTu8wy";

    }
    
    public function publicWebMethods() {
        return array(
            'sync'      => 'GET',
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

    public function sync(){
        $fire = new Firebase($this->FBURL,$this->FBSecret);
        $phlapi = "https://api.phila.gov/bike-share-stations/v1";
        $rr = new RestfulService($phlapi,$expiry2 = 60);
        $resp2 = $rr->request();
        $indego = json_decode($resp2->getBody());
        $fire->set("_indego_raw",$indego);
        // var_dump($indego);exit;
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
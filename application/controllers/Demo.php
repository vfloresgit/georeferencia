<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Demo extends CI_Controller {

    function __construct()
    {   
    parent::__construct();
    $this->load->model("Mdireccion");
    }

	public function index()
	{
		$this->load->view('welcome_message');
	}

	public function texturl(){
         


		set_time_limit(0);


        //$url = "http://192.168.0.60/routing/";
		$url = "http://192.168.0.60/routing/index.php/routing/soloorden/";

        $resultado=$this->Mdireccion->listarCordenadas();

        // foreach ($resultado->result() as $lista){

        //   echo $lista->id."<br>";
           
        //  }

        //  exit;

	
         foreach ($resultado->result() as $lista){

           $dato[]=array('id'=>$lista->id,'lat'=>$lista->lat,'lon'=>$lista->long);           
         
         }


		  // $ini = array('id'=>'ini','lat'=>'-7.145127','lon'=>'-78.524212');  
        
         //$ini = array('id'=>'ini','lat'=>'-77.068468','lon'=>'-12.037849');    
         $ini = array('id'=>'ini','lat'=>'78.524212','lon'=>'-7.145127');
	    $json=$dato;
	    print_r($json);exit;


		$arr = array("init"=>json_encode($ini),"json"=>json_encode($json));

       
/*      
		echo "<pre>";
		print_r($arr);
		echo "</pre>";*/

		$res = $this->curl_base($url,null,$arr,null,null,null,null,null);
         
		$re = json_decode($res,TRUE);

			// $id = array_column($re, 'id');
			// $lat = array_column($re, 'lat');
			// $lon = array_column($re, 'id');
			// $id_node = array_column($re, 'id');
 
          //  echo "<table border='1'>";
		        //    echo "<tr>";
				      //      echo "<td>id</td>";
				      //      echo "<td>lat</td>";
				      //      echo "<td>lon</td>";
				      //      echo "<td>id_node</td>";
				      //      echo "<td>seq</td>";
		        //    echo "</tr>";
          // foreach ($id as $valor) {
		        //    echo "<tr>";
				      //      echo "<td>".$valor."</td>";
				      //      echo "<td></td>";
				      //      echo "<td></td>";
				      //      echo "<td></td>";
				      //      echo "<td></td>";
		        //    echo "</tr>";
          // }
          // echo "</table>";

	
		echo "<pre>";
		print_r($re);
		echo "</pre>";


	}

	public function curl_base($url,$cookie_jar,$arr,$referer,$useragent,$httpheader,$proxy,$port)
	{

		$a = curl_init($url);
		curl_setopt($a, CURLOPT_POSTFIELDS, $arr);
		curl_setopt($a, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($a, CURLOPT_BINARYTRANSFER,1);
		curl_setopt($a, CURLOPT_FRESH_CONNECT, TRUE);
		curl_setopt($a, CURLOPT_CONNECTTIMEOUT ,2); 
		$b = curl_exec($a);
		curl_close($a);
		return $b;
		
	}



}


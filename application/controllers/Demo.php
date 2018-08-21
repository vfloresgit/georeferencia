<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Demo extends CI_Controller {

    function __construct(){

       parent::__construct();
       $this->load->model("Mdireccion");

    }

	public function index(){

		$this->load->view('welcome_message');

	}

	public function texturl(){
         
        //TIEMPO DE EJECUCION DEL METODO
		set_time_limit(0);


        //$url = "http://192.168.0.60/routing/";
		$url = "http://192.168.0.60/routing/index.php/routing/soloorden/";

        $resultado=$this->Mdireccion->listarCordenadas();

        // foreach ($resultado->result() as $lista){

        //   echo $lista->id."<br>";
           
        //  }

        //  exit;
        //print_r($resultado);

        //echo "gfsdhgf";

        $dato = array();

        // echo sizeof($resultado);
	
         foreach ($resultado as $lista){

         	if(isset($lista['id'])){
         		array_push($dato, array('id'=>$lista['id'],'lat'=>$lista['lat'],'lon'=>$lista['lon']));
         		//echo "OK";
         	}

         }
         //print_r($dato);
         // $ini = array('id'=>'ini','lat'=>'-77.068468','lon'=>'-12.037849');   //PARA DIRECCIONES.XLS 
         $ini = array('id'=>'ini','lat'=>'-78.524212','lon'=>'-7.145127');  
	     $json=$dato;

		// echo "<pre>";
	 //    print_r($ini);
  //       echo "</pre>";
/*
         echo "<pre>";
	     print_r($json);
         echo "</pre>";
	    
	   */

		$arr = array("init"=>json_encode($ini),"json"=>json_encode($json));

       
      
		 // echo "<pre>";
		 // print_r($arr);
		 // echo "</pre>";

		$res = $this->curl_base($url,null,$arr,null,null,null,null,null);
		

	
		echo "<pre>";
		print_r($res);
		echo "</pre>";

	}

	public function curl_base($url,$cookie_jar,$arr,$referer,$useragent,$httpheader,$proxy,$port)
	{

		$a = curl_init($url);
		// curl_setopt($a, CURLOPT_VERBOSE, true);
		curl_setopt($a, CURLOPT_POSTFIELDS, $arr);
		curl_setopt($a, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($a, CURLOPT_BINARYTRANSFER,1);
		curl_setopt($a, CURLOPT_FRESH_CONNECT, TRUE);
		curl_setopt($a, CURLOPT_CONNECTTIMEOUT ,2); 
		$b = curl_exec($a);
		// $info = curl_getinfo($a);
		
		curl_close($a);

		return $b;
		
	}



}


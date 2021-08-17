<?php
//All the logics in the mvc is written here. All the mvc architecture will be 
//controlled by this App.php
class App{
private $_url=null;
private $_controller=null;

function __construct()
{
    $this->_getURL();
    if(empty($this->_url[0])){
        $this->_loadDefaultController();
        return false;
    }
    $this->_loadController();
}

private function _getURL(){
    $url = isset($_GET['url'])? $_GET['url'] : null;
    #browser link eke base eken pasuw athi tika $url ekt set kara genima

    $url= rtrim($url,'/'); // remove the backslash at the r-right hand side in the url

    $url=  filter_var($url,FILTER_SANITIZE_URL); //
    //sanitize the url. remove special charaters and etc. ex:- % & signs
    
    $this->_url= explode('/',$url); // divide url into parts by '/' and assign them into an array
    print_r($this->_url);
    //print_r($this->$url); //printing the url as an array
}

//when u enter a url without a controller this default controller should execute
//ex:- RAD/MVC-Tech  instead of RAD/MVC-Tech/Controller
private function _loadDefaultController(){
    require 'controllers/index.php';

    $this->_controller=new Index();
    $this->_controller->index();
}

private function _loadController(){
    $file='controllers/'.$this->_url[0].'.php';// https:MVCTech/ Eken passe indn count wei.
    if(file_exists($file)){
        require $file;
        $this->_controller=new $this->_url[0];
        $this->_controller->index();
        return true;
    }
    else{
       echo "Sorry page not found";
       return false;
    }

}
}

?>
<?php

/*
version 160710
 - проверка наличия файла шаблона и вывод уведомления об его отсутствии
*/

class TPL{
    //public $tpl_dir;//директория с шаблонами
    //public $tpl_filename;
    //public $cont;
    //public $arr_tpl;
    //public $gType;//savetags - сохранять теги, для которых не задано значение
    //public $tagFormat;//по умолчанию {tag_xxx}


function __construct($tpl_dir="", $arr_tpl=""){
    //$this->tagFormat = "{tag_xxx}";
    $this->tagFormat = "{#xxx#}";//xxx - tag name
    $this->gType = "";

    if($arr_tpl!=""){
      $this->arr_tpl=$arr_tpl;
    }else{
      //$this->arr_tpl[] = "";
    }
    $this->tpl_dir = $tpl_dir;
  
}

/*
 * load_template_from_file - загружает шаблон из файла
 */
function load_template_from_file($tpl_filename){
    $this->tpl_filename = $tpl_filename;
    //echo "Загружаем шаблон:".$this->tpl_filename."<br>";
     //открываем файл шаблона
  if(file_exists($this->tpl_dir.$this->tpl_filename)){
      $this->cont = file_get_contents($this->tpl_dir.$this->tpl_filename);
      //echo $this->cont;
      /* 
      $fp = fopen(ROOT_DIR.'/tpl/'.$this->tpl_filename,"r") or die (" file is missing");
       while(!feof($fp))  
       {  
           $this->cont.= fread($fp,1024);  
       }  
       fclose($fp);
       */
  }else{
      //die("Файл <b>".$this->tpl_filename."</b> шаблона отсутствует");
      echo("Файл <b>".$this->tpl_filename."</b> шаблона отсутствует<br>");
  }
}

function getHelpers(){
    preg_match_all("/\{tag_func#(.+?)\}/is", $this->cont, $arr_helpers);
    print_r($arr_helpers);
    return $arr_helpers;
}

/*
 * load_template_from_string - загружает шаблон из переменной
 */
function load_template_from_string($cont){
    $this->cont=$cont;
}

function add_param($param_name, $param_value){
  $this->arr_tpl[$param_name] = $param_value;
  //echo "param_name:".$param_name."<br>";
  //echo "param_value:".$param_value."<br>";
}

function get_param($param_name){
//echo "<b>".__METHOD__."</b><br>";
//print_r($this->arr_tpl);
  //echo "param_name:".$param_name."<br>";
  //echo "param_value:".$this->arr_tpl[$param_name]."<br>";
  return $this->arr_tpl[$param_name];
}


function generate(){
//, $tag_format="{tag_xxx}"
//echo "gtype:".$gtype."<br>";
$tpl_html = $this->cont;

if(is_array($this->arr_tpl)){
    foreach($this->arr_tpl as $k=>$v){
      //echo $k."=>".$v."<br>";
        $tag_format = str_replace('xxx', $k, $this->tagFormat);
        $tpl_html = str_replace($tag_format, $v, $tpl_html);
        //$this->cont = str_replace("{tag_".$k."}", $v, $this->cont);
        //$this->cont = str_replace("{".$k."}", $v, $this->cont);
    }//foreach
}

if($this->gType != "savetags"){
//удаляет тэги, которые не были предопределены
//$this->cont = preg_replace("#\{tag_(.+?)\}#ies", "", $this->cont);
$tpl_html = preg_replace("#\{tag_(.+?)\}#is", "", $tpl_html);//php7 The /e modifier is no longer supported, use preg_replace_callback instead
}

return $tpl_html;

}





}
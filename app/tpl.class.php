<?php

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

function load_template_from_file($tpl_filename){
  $this->tpl_filename = $tpl_filename;
  if(file_exists($this->tpl_dir.$this->tpl_filename)){
      $this->cont = file_get_contents($this->tpl_dir.$this->tpl_filename);
  }else{
      echo("Файл <b>".$this->tpl_filename."</b> шаблона отсутствует<br>");
  }
}

function getHelpers(){
    preg_match_all("/\{tag_func#(.+?)\}/is", $this->cont, $arr_helpers);
    print_r($arr_helpers);
    return $arr_helpers;
}

function load_template_from_string($cont){
    $this->cont=$cont;
}

function add_param($param_name, $param_value){
    $this->arr_tpl[$param_name] = $param_value;
}

function get_param($param_name){
    return $this->arr_tpl[$param_name];
}


function generate(){
    $tpl_html = $this->cont;

    if(isset($this->arr_tpl) && is_array($this->arr_tpl)){
        foreach($this->arr_tpl as $k=>$v){
            $tag_format = str_replace('xxx', $k, $this->tagFormat);
            $tpl_html = str_replace($tag_format, $v, $tpl_html);
        }
    }

    if($this->gType != "savetags"){
      $tpl_html = preg_replace("#\{tag_(.+?)\}#is", "", $tpl_html);
    }

    return $tpl_html;

}


}
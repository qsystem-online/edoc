<?php
    if (!function_exists('dateFormat')){
        function dateFormat($strDate,$inputFormat,$outputFormat = 'Y-m-d H:i:s'){
            $date = DateTime::createFromFormat($inputFormat, $strDate);
            if($date){
                return $date->format($outputFormat);
            }else{
                return date($outputFormat,0);
            }
        }
    }
    if (!function_exists('dBDateFormat')){
        function dBDateFormat($strDate,$inputFormat){
            $date = DateTime::createFromFormat($inputFormat, $strDate);
            if($date){
                return $date->format('Y-m-d');
            }else{
                return date('Y-m-d',0);
            }
        }
    }
    if (!function_exists('dBDateTimeFormat')){
        function dBDateTimeFormat($strDate,$inputFormat){
            $date = DateTime::createFromFormat($inputFormat, $strDate);
            if($date){
                return $date->format('Y-m-d H:i:s');
            }else{
                return date('Y-m-d H:i:s',0);
            }
        }
    }

    
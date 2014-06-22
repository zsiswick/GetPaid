<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    
    function buildDayDropdown($name='',$value='')
    {
        $days='';
        while ( $days <= '31'){
            $day[]=$days;$days++;
        }
        return form_dropdown($name, $day, $value);
    }
    
    function buildYearDropdown($name='',$value='')
    {        
        $years = range(date("Y")-8, date("Y")+8);
        foreach($years as $year)
        {
            $year_list[$year] = $year;
        }    
        
        return form_dropdown($name, $year_list, $value);
    } 
    
    function buildMonthDropdown($name='',$value='')
    {
        $month=array(
            '01'=>'January',
            '02'=>'February',
            '03'=>'March',
            '04'=>'April',
            '05'=>'May',
            '06'=>'June',
            '07'=>'July',
            '08'=>'August',
            '09'=>'September',
            '10'=>'October',
            '11'=>'November',
            '12'=>'December');
        return form_dropdown($name, $month, $value);
    }

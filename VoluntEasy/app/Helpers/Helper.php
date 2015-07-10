<?php namespace App\Helpers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class Helper
{

	/**
	 * Author
	 * John Veldboom
	 * Sounrce
	 * http://johnveldboom.com/posts/42/display-the-difference-between-two-dates-in-php
	 *
	 * Display the difference between two dates
	 * (30 years, 9 months, 25 days, 21 hours, 33 minutes, 3 seconds)
	 *
	 * @param  string $start starting date
	 * @param  string $end=false ending date
	 * @return string formatted date difference
	 */
	function dateDiff($start,$end=false)
	{
	   $return = array();
	   
	   try {
	      $start = new \DateTime($start);
	      $end = new \DateTime($end);
	      $form = $start->diff($end);
	   } catch (Exception $e){
	      return $e->getMessage();
	   }
	   
	   $display = array('y'=>'year',
	               'm'=>'month',
	               'd'=>'day',
	               'h'=>'hour',
	               'i'=>'minute'
	               //,'s'=>'second'
	               );
	   foreach($display as $key => $value){
	      if($form->$key > 0){
	         $return[] = $form->$key.' '.($form->$key > 1 ? $value.'s' : $value);
	      }
	   }
	   
	   return implode($return, ', ');
	}

}




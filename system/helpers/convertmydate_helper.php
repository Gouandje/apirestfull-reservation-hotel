<?php

	defined('BASEPATH') OR exit('No direct script access allowed');


	if ( ! function_exists('DateConverter')){
	
	 
	//Convertisseur de date au format voulu
	    function DateConverter($date){	
			$day = substr($date,0,2);
			$month = substr($date,3,2);
			$year = substr($date,6,4);
			try{
                $newdate = new DateTime($year."-".$month."-".$day);
                return $newdate ;
            }
            catch (Exception $e){
                return $e->getMessage();
            }

	    }
    }





    if ( ! function_exists('Duration')){


        //Calculer le nombre de jour entre 2 dates
        function Duration($datestart, $dateend){

            try{
                $interval = date_diff($datestart, $dateend);
                $diff = $interval->format('%R%a');
                $explod_diff = explode('+', $diff);
                $duree = $explod_diff[1];

                return $duree ;
            }
            catch (Exception $e){
                return $e->getMessage();
            }
        }
    }





    if ( ! function_exists('DateList')){

        //Lister les dates dans une période indiquée
        function DateList($start, $end){

            try{
                $TabDeb = explode("/", $start);
                $dayDeb = $TabDeb[0];
                $monthDeb = $TabDeb[1];
                $yearDeb = $TabDeb[2];

                $TabEnd = explode("/", $end);
                $dayEnd = $TabEnd[0];
                $monthEnd = $TabEnd[1];
                $yearEnd = $TabEnd[2];

                if(checkdate($monthDeb, $dayDeb, $yearDeb) && checkdate($monthEnd, $dayEnd, $yearEnd)) {
                    $day = Duration(DateConverter($start), DateConverter($end));
                    $timeStampDeb = mktime("00", "00", "00", $monthDeb, $dayDeb, $yearDeb);

                    for ($i = 0; $i <= $day; $i++) {
                        $tps = $timeStampDeb + ($i * 24 * 3600);
                        $range[$i] = date('d/m/Y', $tps);
                    }

                    return $range;
                }
                else{
                    return null;
                }
            }
            catch (Exception $e){
                return $e->getMessage();
            }
        }
    }



    if ( ! function_exists('DateRange')){

        //Lister les dates dans une période indiquée
        function DateRange($start, $interval){

            try{
                $TabDeb = explode("/", $start);
                $dayDeb = $TabDeb[0];
                $monthDeb = $TabDeb[1];
                $yearDeb = $TabDeb[2];

                if(checkdate($monthDeb, $dayDeb, $yearDeb)) {
                    //$day = Duration(DateConverter($start), DateConverter($end));
                    $timeStampDeb = mktime("00", "00", "00", $monthDeb, $dayDeb, $yearDeb);

                    for ($i = 0; $i <= $interval; $i++) {
                        $tps = $timeStampDeb + ($i * 24 * 3600);
                        $range[$i] = date('d/m/Y', $tps);
                    }

                    return $range;
                }
                else{
                    return null;
                }
            }
            catch (Exception $e){
                return $e->getMessage();
            }
        }
    }
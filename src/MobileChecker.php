<?php

namespace Kbarut\Telecommunication;

class MobileChecker
{
   	/**
	* Determines if the $input string is a valid german operator backed mobile phone number
	* entered with or without any of the two country area code possible: '0049', '+49'
	*
	* @param string $input 
	* @return bool
	*/	
	public function validate(string $input): bool
    	{		
		if ($this->emptyInput($input) === true)
			return false;
		
		$cleaned = $this->clean($input);

		if ($this->emptyInput($cleaned) === true)
			return false;

		$chars_count = $this->getLength($cleaned);

		if (($chars_count < 10) or ($chars_count > 15))
			return false;
		
		$call_type = $this->getCallType($cleaned);
		
		$res = match ($call_type) {
			'national' => $this->checkNational($cleaned),
			'+49' => $this->checkInternationalShort($cleaned),
			'0049' => $this->checkInternationalLong($cleaned),
		};
		
		return $res;			
    	}
	
	/**
	* returns true if the string is empty, false otherwise
	*
	* @param string $input
	* @return bool
	*/	
	public function emptyInput(string $input): bool
    	{
	   return (strlen($input) === 0);
   	}	

	/**
	* Removes all non digit characters from the $input string
	* If the first character of $input is "+", we keep it because it could be part of the
	* valid country code "+49"
	*	
	* (see proper use of this method in conjunction with other methods in class)
	*
	* @param string $input
	* @return string
	*/
	public function clean(string $input): string
    	{
		$first =  substr(preg_replace('/\s+/','',$input),0,1);
 
		if ($first === '+') {

			$rest = substr(preg_replace('/\s+/','',$input),1);

			$cleaned = $first . preg_replace("/[^0-9]/",'',$rest);

		} else {

			$cleaned = preg_replace("/[^0-9]/",'',$input);
		}	

		return $cleaned;
       }
	
	/**
	* Returns the $cleaned_input string characters count (>0)
	*
	* (see proper use of this method in conjunction with other methods in class)
	*
	* @param string $cleaned_input
	* @return int 
	*/
    	public function getLength(string $cleaned_input): int
        {
	    return strlen($cleaned_input);
	}
	
	/**
	* Returns '0049' if '0049' are the first four characters of $cleaned_input 
	* Returns '+49' if '+49' are the first three characters of $cleaned_input
	* Returns 'national' in all other cases
	*
	* (see proper use of this method in conjunction with other methods in class)
	*
	* @param string $cleaned_input
	* @return string  
	*/
	public function getCallType(string $cleaned_input): string
        {
		$call_type = 'national';
		
		$firstFour = substr($cleaned_input,0,4);
		$firstThree = substr($cleaned_input,0,3);
	
		if ($firstFour === '0049')
			$call_type = '0049';
		
		if ($firstThree === '+49')
			$call_type = '+49';
		
		return $call_type;
        }
	
	/**
	* Returns true if number is a valid commercial german mobile phone number entered without the country code,
	* returns false otherwise.
	*
	* (see proper use of this method in conjunction with other methods in class)
	*
	* @param string $cleaned_input
	* @return bool 
	*/
	
	public function checkNational(string $cleaned_input): bool
        {
		$res = false;
		
		$user_ndc = null;
		$min = null;
		$max = null;
				
		$data = [];
		
		$data = require('DE_mobile_infos_no_country_code.php');
		
		foreach( $data as $arr) {
			
			foreach( $arr as $key => $value) {
				
				if ($key === 'NDC') {
					$ndc2 = '0' . $value;	
					$ndc_length = strlen($ndc2);
				}

				$user_ndc = substr($cleaned_input,0,$ndc_length);
					
				if ($key === 'min_digits_count')
					$min = $value;
					
				if ($key === 'max_digits_count')
					$max = $value;
		
				if ( (strlen($user_ndc) != 0) and (strlen($min) != 0) and (strlen($max) != 0) ) {
					
					if ( ($ndc2 === $user_ndc) and  (strlen($cleaned_input) >= $min) and (strlen($cleaned_input) <= $max) ) {
						
						$res = true;

						break;
					
					} else {
						
						$user_ndc = null;
						$min = null;
						$max = null;
					}			
				}	
			   }
			   if ($res === true)
			      return $res;					
		    }
		
		    return $res;
	    }
		
	    /**
	    * Returns true if number is a valid commercial german mobile phone number entered with '+49' as the country code,
	    * returns false otherwise.
	    *
	    * (see proper use of this method in conjunction with other methods in class)
	    *
	    * @param string $cleaned_input
	    * @return bool
	    */
    
	    public function checkInternationalShort(string $cleaned_input): bool 
            {
		$res = false;
		
		$user_ndc = null;
		$min = null;
		$max = null;
				
		$data = [];
		
		$data = require('DE_mobile_infos_country_code2.php');
		
		foreach( $data as $arr) {
			
			foreach( $arr as $key => $value) {
				
				if ($key === 'NDC') {
					$ndc2 = $value;
					$ndc_length = strlen($ndc2);
				}

				$user_ndc = substr($cleaned_input,0,$ndc_length);
					
				if ($key === 'min_digits_count')
				    $min = $value;
					
				if ($key === 'max_digits_count')
				    $max = $value;
		
				if ( (strlen($user_ndc) != 0) and (strlen($min) != 0) and (strlen($max) != 0) ) {
					
					if ( ($ndc2 === $user_ndc) and  (strlen($cleaned_input) >= $min) and (strlen($cleaned_input) <= $max) ) {
						
						$res = true;

						break;
						
					} else {
						
						$user_ndc = null;
						$min = null;
						$max = null;
					}											
				}	
			}
			if ($res === true)
				return $res;		
		 }
		return $res;
             }
	
	      /**
	      * Returns true if number is a valid commercial german mobile phone number entered with '0049' as the country code,
	      * returns false otherwise.
	      *
	      * (see proper use of this method in conjunction with other methods in class)
	      *
	      * @param string $cleaned_input
	      * @return bool 
	      */
    
	      public function checkInternationalLong(string $cleaned_input): bool 
    	      {
		
		$res = false;
		
		$user_ndc = null;
		$min = null;
		$max = null;
				
		$data = [];
		
		$data = require('DE_mobile_infos_country_code1.php');
		
		foreach( $data as $arr) {
			
			foreach( $arr as $key => $value) {
				
				if ($key === 'NDC') {
				    $ndc2 = $value;
				    $ndc_length = strlen($ndc2);
				}

				$user_ndc = substr($cleaned_input,0,$ndc_length);
					
				if ($key === 'min_digits_count')
				    $min = $value;
					
				if ($key === 'max_digits_count')
				    $max = $value;
		
				if ( (strlen($user_ndc) != 0) and (strlen($min) != 0) and (strlen($max) != 0) ) {
					
					if ( ($ndc2 === $user_ndc) and  (strlen($cleaned_input) >= $min) and (strlen($cleaned_input) <= $max) ) {
						
						$res = true;

						break;
					
					} else {
						
						$user_ndc = null;
						$min = null;
						$max = null;
					}										
				}	
			   }
			   if ($res === true)
			      return $res;					
		    }	
		    return $res;
               }
    		
}

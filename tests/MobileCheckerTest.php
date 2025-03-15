<?php

namespace Kbarut\Telecommunication\Tests;

use Kbarut\Telecommunication\MobileChecker;

it('empty input', function () {
	
	$mobileChecker = Mockery::mock(MobileChecker::class);
	
	$res = $mobileChecker->validate('');
	
	expect($res)->toBeFalse();
    
});

it('wrong characters count', function () {
	
    	$mobileChecker = Mockery::mock(MobileChecker::class);
	
	$res = $mobileChecker->validate('015019123');
	            	
	expect($res)->toBeFalse();
 
});

it('wrong characters types', function () {

   	$mobileChecker = Mockery::mock(MobileChecker::class);
	
	$res = $mobileChecker->validate('0150191234A');
	
	expect($res)->toBeFalse();

});

it('assignable no country code german mobile num', function () {

    	$mobileChecker = Mockery::mock(MobileChecker::class);
	
	$res = $mobileChecker->validate('01501912345');
	
	expect($res)->toBeTrue();

});

it('assignable german mobile num with country code "0049"', function () {

    	$mobileChecker = Mockery::mock(MobileChecker::class);
	
	$res = $mobileChecker->validate('00491501912345');
	
	expect($res)->toBeTrue();
	
});

it('assignable german mobile num with country code "+49"', function () {

    	$mobileChecker = Mockery::mock(MobileChecker::class);
	
	$res = $mobileChecker->validate('+491501912345');
	
	expect($res)->toBeTrue();
});

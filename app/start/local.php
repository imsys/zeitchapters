<?php

//use Illuminate\Exception;

App::error(function(Exception $exception, $code) {
	Log::error($exception);
	return null;
});
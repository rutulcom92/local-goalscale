@extends('errors::minimal')

@section('title', pageTitle('Server Error'))
@section('code', '500')
@section('message', __('Server Error'))
@section('error-description', "Sorry, something went wrong on our end. Please try again after some time")

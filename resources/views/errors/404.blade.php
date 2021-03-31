@extends('errors::minimal')

@section('title', pageTitle('Not Found'))
@section('code', '404')
@section('message', __('Not Found'))
@section('error-description', "The page you requested was not found")

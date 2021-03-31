@extends('errors::minimal')

@section('title', pageTitle('Forbidden'))
@section('code', '403')
@section('message', __($exception->getMessage() ?: 'Forbidden'))
@section('error-description', "You don't have permission to access this area")

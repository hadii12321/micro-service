@extends('errors.layout')

@section('title', __('Method Not Allowed'))
@section('code', '405')
@section('message', __('konfigurasi server menolak akses ke sumber daya (URI) karena pembatasan metode'))

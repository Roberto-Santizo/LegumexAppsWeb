@extends('layouts.mantenimiento')

@section('titulo')
Documentos Checklists Preoperacionales
@endsection

@section('contenido')

<x-alertas />

<livewire:documento-checklist-controller-index />
@endsection
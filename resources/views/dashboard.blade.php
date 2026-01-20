@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h1>Dashboard</h1>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Forms</h5>
                        <p class="card-text">{{ \App\Models\Form::count() }} forms created.</p>
                        <a href="{{ route('forms.index') }}" class="btn btn-primary">View Forms</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
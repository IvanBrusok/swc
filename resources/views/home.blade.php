@extends('layouts.app')

@section('content')
    <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0">
        <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 min-vh-100">
            <span class="fs-5 d-none d-sm-inline">Все события</span>
            <ul class="nav nav-pills flex-column mb-0 align-items-center align-items-sm-start" id="allEvents">

            </ul>
            <span class="fs-5 d-none d-sm-inline">Мои события</span>
            <ul class="nav nav-pills flex-column mb-0 align-items-center align-items-sm-start" id="myEvents">

            </ul>
        </div>
    </div>
    <main class="py-4 col-md-8">
        <div class="container">
            <div class="row justify-content-center">
                <div class="content">

                </div>
            </div>
        </div>
    </main>
@endsection

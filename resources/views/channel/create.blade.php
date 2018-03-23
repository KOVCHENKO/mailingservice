@extends('layouts.app')

@section('content')
    <div class="form-group row">
        <label for="name" class="col-sm-2 col-form-label text-md-right"></label>

        <div class="col-md-6">
            <h4> Создать канал </h4>
        </div>
    </div>


        <form method="POST" role="form" action="{{ url('/channel/create') }}">
            @csrf

            <div class="form-group row">
                <label for="name" class="col-sm-2 col-form-label text-md-right">Название</label>

                <div class="col-md-6">
                    <input id="name" class="form-control" name="name" value="">
                </div>
            </div>

            <div class="form-group row">
                <label for="type" class="col-sm-2 col-form-label text-md-right">Тип</label>

                <div class="col-md-6">
                    <input id="type" class="form-control" name="type" value="">
                </div>
            </div>

            <div class="form-group row mb-0">
                <div class="col-md-8 offset-md-4">
                    <button type="submit" class="btn btn-primary">Создать</button>
                </div>
            </div>
        </form>

    @if ($errors->any())
        <div class="help-block">
            @foreach($errors->all() as $error)
                <p style="color: grey">{{ $error }}</p>
            @endforeach
        </div>
    @endif

@endsection

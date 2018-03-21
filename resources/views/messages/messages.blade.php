@extends('layouts.app')

@section('content')
    {{--<div class="container">--}}
        <form method="POST" role="form" action="{{ url('/message/create') }}">
            @csrf

            <div class="form-group row">
                <label for="type" class="col-sm-2 col-form-label text-md-right">Тип</label>

                <div class="col-md-6">
                    <input id="type" class="form-control" name="type" value="register">
                </div>
            </div>

            <div class="form-group row">
                <label for="channel" class="col-sm-2 col-form-label text-md-right">Канал</label>

                <div class="form-group row">
                        @foreach($channels as $channel)
                    <div class="col-md-4">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="provider_type[]" value="{{ $channel->type }}"> {{ $channel->name }}
                                </label>
                            </div>
                    </div>
                        @endforeach
                </div>
            </div>

            <div class="form-group row">
                <label for="contact" class="col-sm-2 col-form-label text-md-right">Контакт</label>

                <div class="col-md-6">
                    <input id="contact" class="form-control" name="contact" value="">
                </div>
            </div>

            <div class="form-group row">
                <label for="data" class="col-sm-2 col-form-label text-md-right">Данные</label>

                <div class="col-md-6">
                    <input id="data" class="form-control" name="data" value="">
                </div>
            </div>

            <div class="form-group row mb-0">
                <div class="col-md-8 offset-md-4">
                    <button type="submit" class="btn btn-primary">Разослать</button>
                </div>
            </div>
        </form>


    {{--</div>--}}
@endsection

@extends('layouts.app')

@section('content')
        <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label text-md-right"></label>

            <div class="col-md-6">
                <h4> Создать сообщение </h4>
            </div>
        </div>

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
                                        <input type="checkbox" name="channel_type[]" value="{{ $channel->type }}"> {{ $channel->name }}
                                    </label>
                                </div>
                        </div>
                    @endforeach
                </div>


                <div><a href="{{ url('/channel/show_create_view/') }}">Создать канал</a></div>
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

    @if ($errors->any())
        <div class="help-block">
            @foreach($errors->all() as $error)
                <p style="color: grey">{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <hr>

    <h4> Сообщения </h4>
    <table class="table">
        <thead>
        <tr>
            <th>Тип</th>
            <th>Контакт</th>
            <th>Данные</th>
            <th>Создано</th>
            <th>Запросить подтверждение</th>
        </tr>
        </thead>
        <tbody>
        @foreach($messages as $message)
            <tr>
                <td> {{ $message -> type }}</td>
                <td> {{ $message -> contact }}</td>
                <td> {{ $message -> data }}</td>
                <td> {{ $message -> created_at }}</td>
                <td> <a href="{{ url('/message/get_status/'.$message -> id)  }}">Запрос</a></td>

                {{--<td>--}}
                    {{--<select class="form-control">--}}
                        {{--@foreach($admin -> admin_IPs as $singleIP)--}}
                            {{--<option>{{ $singleIP }}</option>--}}
                        {{--@endforeach--}}
                    {{--</select>--}}
                {{--</td>--}}

            </tr>

        @endforeach
        </tbody>
    </table>



@endsection

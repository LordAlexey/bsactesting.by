@extends('layouts.app')
@section('content')

    <div class="low-time alert alert-info text-center">
        Внимание! Осталось меньше 2-х минут. По окончании тест отправится автоматически
    </div>

    <div class="container">
        <div class="timer">
            Осталось <span>{{$time}}</span>
        </div>
        <form class="test-form" action="{{route('show_test',$test->id)}}" method="post">
            {{csrf_field()}}
            <div class="row">
                <div class="col-md-12">
                    <h2>Тест по теме "{{$test->name}}"</h2>
                    <div class="alert alert-warning">
                        <ul>
                            <li>На время выполнения теста дается {{$test->time}} минут</li>
                            @if($test->mark_system=='simple')<li>Тест включает {{$test->quest_number}} случайных вопросов</li>@else
                                <li>Тест включает {{$questions->count()}} случайных вопросов различной сложности</li>
                            @endif
                        </ul>
                    </div>
                </div>
                <input type="hidden" name="stdans" value="{{base64_encode($stdans_id)}}">
                <input type="hidden" name="test" value="{{$test->id}}">
                @foreach($questions as $question)

                    <div class="form-group col-md-12">
                        <pre class="question-pre">{{$question->text}}@foreach($question->images()->get() as $image)
                                <br><img src="/{{$image->path}}" alt="" width="200">
                            @endforeach</pre>
                        @foreach($question->answers->shuffle() as $answer)

                                <input type="checkbox" id="a{{$answer->id}}" name="{{md5($question->id)}}[]" class="check" value="{{$answer->id}}">
                                <label for="a{{$answer->id}}" class="alert alert-danger test-answer">
                                    <p>
                                    {{$answer->text}}
                                    </p>
                                    @foreach($answer->images()->get() as $image)
                                        <img src="/{{$image->path}}" alt="" width="200">
                                    @endforeach

                                </label>

                        @endforeach
                    </div>
                @endforeach
                <div class="form-group">
                    <div class="col-md-6">
                        <input type="submit" class="btn btn-success complete-test" value="Отправить на проверку">
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
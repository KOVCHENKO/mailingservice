<?php

namespace App\Http\Controllers\Auxiliary;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CalisthenicsController extends Controller
{
    public function levelsOfIdentation()
    {
        // Используйте только один уровень вложения
    }

    public function dontUseElseKeyword()
    {
        // Не используйте ключевое слово else

        // В блоке if описывается ошибочный сценарий, а дальше всё идет обычным блоком

        // Возможно использование NullObject, State, Strategy
    }

    public function wrappingPrimitiveWithObjects()
    {
        // Необходимо оборачивать примитивные типы в объекты:
        // integer $money - Money $money
    }

    public function firstClassCollection()
    {
        // Класс, которые содержит коллекцию объектов
        // не должен содержать других классов или примитивов
    }

    public function oneArrowPerLine()
    {
        // Если это не query builder, не используйте вызов одного метода через другой
    }

    public function dontAbbreviate()
    {
        // Не надо использовать аббревиатуры в названиях метода или класса
    }

    public function keepAllEntitiesSmall()
    {
        // Small classes
        // Small packages
    }

    public function makeOnlyTwoFieldsInClass()
    {
        // Класс должен содержать только два поля
    }

    public function tellDontAsk()
    {
        // Не запрашиваем что-то у класса, а говорим ему что от него требуется сделать
    }
}

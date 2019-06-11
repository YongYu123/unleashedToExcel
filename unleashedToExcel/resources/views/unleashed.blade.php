@extends('layouts.app')

@section('content')
    <div class="container">
        <form method="POST" action="/unleashed/excel">
            <select name="customerName" class="custom-select mb-5">
                <option selected>Customer select here</option>
                @foreach ($customers as $customer)
                    <option value="{{$customer->CustomerName}}">{{$customer->CustomerName}}</option>
                @endforeach
            </select>
            <button class="btn btn-success" type="submit">Get Excel</button>
        </form>
    </div>
@endsection

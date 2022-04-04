@extends('layouts.main')

@section('title', 'Invoices')

@section('content')
    <table class='table'>
        <tr>
            <th>ID</th>
            <th>Customer</th>
            <th>Date</th>
            <th colspan='2'>Total</th>
        </tr>

        @foreach($invoices as $invoice)
            <tr>
                <td>{{ $invoice->id }}</td>
                <td>
                    {{ $invoice->customer->first_name }} {{ $invoice->customer->last_name }}
                </td>
                <td>{{ $invoice->invoice_date }}</td>
                <td>{{ $invoice->total }}</td>
                <td>
                    {{--@if (Auth::user()->can('view-invoice', $invoice))--}}
                    @can('view', $invoice)
                        <a href='{{ route('invoice.show', ['id'=>$invoice->id]) }}'>
                            Details
                        </a>
                    @endcan
                </td>
            </tr>
        @endforeach
    </table>
@endsection

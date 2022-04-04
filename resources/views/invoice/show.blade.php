@extends('layouts.main')

@section('title')
    Invoice #{{ $invoice->id }}
@endsection

@section('content')
    <p>Total: ${{ $invoice->total }}</p>

    <table>
        <tr>
            <th>Track</th>
            <th>Album</th>
            <th>Artist</th>
            <th>Price</th>
        </tr>

        @foreach($invoice->invoiceItems as $invoiceItem)
            <tr>
                <td>{{ $invoiceItem->track->name }}</td>
                <td>{{ $invoiceItem->track->album->title }}</td>
                <td>{{ $invoiceItem->track->album->artist->name }}</td>
                <td>{{ $invoiceItem->track->unit_price }}</td>
            </tr>
        @endforeach
    </table>
@endsection

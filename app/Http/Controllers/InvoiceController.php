<?php

namespace App\Http\Controllers;

use App\Models\InvoiceItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Invoice;

class InvoiceController extends Controller
{
    public function index()
    {
        //viewAny a method in InvoicePolicy
        $this->authorize('viewAny', Invoice::class);
        //Or
//        if (Auth::user()->cannot('viewAny', Invoice::class)) {
//            abort(403);
//        }
        // SELECT invoices.id AS id,
        //        invoices.invoice_date,
        //        customers.first_name,
        //        customers.last_name,
        //        invoices.total
        // FROM invoices
        // INNER JOIN customers
        //      ON customers.id = invoices.customer_id

        /*
        $invoices = DB::table('invoices')
            ->join('customers', 'invoices.customer_id', '=', 'customers.id')
            ->get([
                'invoices.id AS id',
                'invoices.invoice_date',
                'customers.first_name',
                'customers.last_name',
                'invoices.total']);
        */

        //Eager loading
        $invoices = Invoice::with(['customer'])
            ->select('invoices.*') //so the id being select are from invoices table
            ->join('customers', 'invoices.customer_id', '=', 'customers.id')
            //->where('customers.email', '=', Auth::user()->email)
            ->get();

        return view('invoice.index', [
            'invoices' => $invoices,
        ]);
    }

    public function show($id)
    {
        /*
        $invoice = DB::table('invoices')
            ->where('id', '=', $id)
            ->first();
        */
        //Lazy Loading
//        $invoice = Invoice::find($id);

        //Eager Loading
        $invoice = Invoice::with([
            'invoiceItems.track',
            'invoiceItems.track.album',
            'invoiceItems.track.album.artist',])
            ->find($id);

        /* $invoiceItems = DB::table('invoice_items')
             ->where('invoice_id', '=', $id)
             ->join('tracks', 'tracks.id', '=', 'invoice_items.track_id')
             ->join('albums', 'tracks.album_id', '=', 'albums.id')
             ->join('artists', 'albums.artist_id', '=', 'artists.id')
             ->orderBy('track')
             ->get([
                 'invoice_items.unit_price',
                 'tracks.name AS track',
                 'albums.title AS album',
                 'artists.name AS artist'
             ]);*/

//        $invoiceItems = $invoice->invoiceItems;


        //The following 3 if does the same thing
        //if (!Gate::allows('view-invoice', $invoice)) {
        //if (Gate::denies('view-invoice', $invoice)) {
        if (Auth::user()->cannot('view', $invoice)) {
            abort(403);     //Unauthorized
        }

        //if fail, auto abort(403)
        $this->authorize('view-invoice', $invoice);

        return view('invoice.show', [
            'invoice' => $invoice,
//            'invoiceItems' => $invoice->invoiceItems,
        ]);
    }
}

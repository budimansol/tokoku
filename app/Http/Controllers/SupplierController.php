<?php

namespace App\Http\Controllers;
use App\Models\Supplier;

use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('supplier.index');
    }

    public function data ()
    {
        $supplier = Supplier::orderby('id_supplier', 'desc')->get();

        return datatables()
        ->of($supplier)
        ->addIndexColumn()
        ->addColumn('aksi', function($supplier) {
                return '
                <div class="btn-group">
                    <button onclick="editForm (`'. route('supplier.update', $supplier->id_supplier) .'`) " class="btn btn-info btn-flat"><i class="fa fa-pencil"></i></button>
                    <button onclick="deleteData (`'. route('supplier.destroy', $supplier->id_supplier) .'`)" class="btn btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                </div>
                ';
        })
        ->rawColumns(['aksi'])
        ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $supplier = new Supplier();
        $supplier->nama = $request->nama;
        $supplier->alamat = $request->alamat;
        $supplier->telepon = $request->telepon;
        $supplier->save();

        return response()->json('Data Berhasil Disimpan', 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id_supplier)
    {
        $supplier = Supplier::find($id_supplier);

        return response()->json($supplier);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id_supplier)
    {
        $supplier = Supplier::find($id_supplier);
        $supplier->nama = $request->nama;
        $supplier->alamat = $request->alamat;
        $supplier->telepon = $request->telepon;
        $supplier->update();

        return response()->json('Data Berhasil Disimpan', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id_supplier)
    {
        $supplier = Supplier::find($id_supplier);
        $supplier->delete();

        return response(null, 204);
    }
}

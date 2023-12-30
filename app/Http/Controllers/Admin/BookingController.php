<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bookings = Booking::latest()->paginate(10);

        return view('admin.booking.index', compact('bookings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $bookings = Booking::latest()->get();
        return view('admin.booking.create', compact('bookings'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'check_in' => 'required|date',
            'check_out' => 'required|date',
            'total_amount' => 'required|integer',
            'capacity' => 'required|integer'
        ]);

        $booking = Booking::create([
            'user_id'     => auth()->user()->id,
            'check_in'     => $request->input('check_in'),
            'check_out'    => $request->input('check_out'),
            'total_amount'    => $request->input('total_amount')
        ]);

        if ($booking) {
            //redirect dengan pesan sukses
            return redirect()->route('admin.booking.index')->with(['success' => 'Pemesanan Berhasil!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('admin.booking.index')->with(['error' => 'Pemesanan Gagal!']);
        }
    }
}

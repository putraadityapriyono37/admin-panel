<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Microsite;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    /** @var list<string> */
    private const STATUSES = ['baru', 'diproses', 'siap', 'selesai', 'dibatalkan'];

    public function index(Microsite $microsite, Request $request)
    {
        $query = Order::with('items')
            ->orderByRaw("CASE status WHEN 'baru' THEN 1 WHEN 'diproses' THEN 2 WHEN 'siap' THEN 3 WHEN 'selesai' THEN 4 WHEN 'dibatalkan' THEN 5 ELSE 6 END")
            ->orderByDesc('created_at');

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->input('date'));
        }

        $orders = $query->paginate(20)->withQueryString();

        return view('admin.orders.index', [
            'currentMicrosite' => $microsite,
            'orders' => $orders,
            'statuses' => self::STATUSES,
            'filterStatus' => $request->input('status'),
            'filterDate' => $request->input('date'),
        ]);
    }

    public function show(Microsite $microsite, Order $order)
    {
        Gate::authorize('view', $order);

        $order->load('items');

        return view('admin.orders.show', [
            'currentMicrosite' => $microsite,
            'order' => $order,
            'statuses' => self::STATUSES,
        ]);
    }

    public function updateStatus(Request $request, Microsite $microsite, Order $order)
    {
        Gate::authorize('update', $order);

        $data = $request->validate([
            'status' => ['required', Rule::in(self::STATUSES)],
        ]);

        $order->update(['status' => $data['status']]);

        return back()->with('status', 'Status pesanan diperbarui.');
    }
}

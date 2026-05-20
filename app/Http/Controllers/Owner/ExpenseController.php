<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    private function tenantId(): int
    {
        return Auth::user()->tenant_id;
    }

    public function index(Request $request)
    {
        $query = Expense::where('tenant_id', $this->tenantId());

        if ($request->filled('month')) {
            $query->whereMonth('expense_date', $request->month);
        }
        if ($request->filled('year')) {
            $query->whereYear('expense_date', $request->year);
        }
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $expenses = $query->latest('expense_date')->paginate(20);
        $totalExpenses = $query->sum('amount');

        return view('owner.expenses.index', compact('expenses', 'totalExpenses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'category' => 'required|string|max:100',
            'expense_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        Expense::create([
            'tenant_id' => $this->tenantId(),
            'user_id' => Auth::id(),
            ...$request->only('title', 'amount', 'category', 'expense_date', 'notes'),
        ]);

        return back()->with('success', 'Pengeluaran berhasil dicatat!');
    }

    public function destroy(Expense $expense)
    {
        abort_if((int) $expense->tenant_id !== $this->tenantId(), 403);
        $expense->delete();
        return back()->with('success', 'Pengeluaran berhasil dihapus!');
    }
}

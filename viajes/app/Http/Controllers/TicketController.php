<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    //lista de tcikcets de los usuarios

    public function index()
    {
        $tickets = Ticket::where('user_id', Auth::id())
        ->orderBy('created_at', 'desc')
        ->get();

        return view('tickets.index', compact('tickets'));

    }
    //crear ticket
    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:baja,media,alta',
        ]);

        Ticket::create([
            'user_id' => Auth::id(),
            'subject' => $request->input('subject'),
            'description' => $request->input('description'),
            'priority' => $request->input('priority'),
            'status' => 'abierto',
        ]);

        return redirect()->back()->with('success', 'Ticket creado exitosamente.');
    }

    //detalles del ticket

    public function show($id)
    {
        $ticket = Ticket::where('id', $id)
        ->where('user_id', Auth::id())
        ->firstOrFail($id);

        return view('tickets.show', compact('ticket'));
    }

    // ADMIN: Ver todos los tickets funciona bien
    public function adminIndex()
    {
        $tickets = Ticket::with(['user', 'admin'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.tickets.index', compact('tickets'));
    }

    // ADMIN: Responder ticket
    public function adminUpdate(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:abierto,en_proceso,resuelto,cerrado',
            'admin_response' => 'nullable|string|max:2000'
        ]);

        $ticket = Ticket::findOrFail($id);
        
        $ticket->update([
            'status' => $request->status,
            'admin_response' => $request->admin_response,
            'admin_id' => Auth::id(),
            'resolved_at' => $request->status === 'resuelto' ? now() : null
        ]);

        return redirect()->back()->with('success', 'Ticket actualizado correctamente.');
    }
}

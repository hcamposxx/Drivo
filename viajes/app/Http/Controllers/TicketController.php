<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    // Ver todos los tickets de los usuarios
    public function index()
    {
        $tickets = Ticket::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('tickets.index', compact('tickets'));
    }

    // Crear nuevo ticket
    public function store(Request $request)
    {
        // Validación
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'description' => 'required|string|max:2000',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120' // Máximo 5MB
        ], [
            'image.required' => 'Debes subir una imagen del problema',
            'image.image' => 'El archivo debe ser una imagen',
            'image.mimes' => 'La imagen debe ser JPG, PNG, GIF o WEBP',
            'image.max' => 'La imagen no debe pesar más de 5MB'
        ]);

        $imagePath = null;
        
        // Guardar la imagen del accidente
        if ($request->hasFile('image')) {
            try {
                $image = $request->file('image');
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('tickets', $imageName, 'public');
            } catch (\Exception $e) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['image' => 'Error al subir la imagen: ' . $e->getMessage()]);
            }
        }

        // Crear el ticket
        Ticket::create([
            'user_id' => Auth::id(),
            'subject' => $validated['subject'],
            'description' => $validated['description'],
            'image' => $imagePath,
            'priority' => null,
            'status' => 'abierto'
        ]);

        return redirect()->back()->with('success', '¡Ticket enviado correctamente! Te responderemos pronto.');
    }

    // Ver un ticket específico
    public function show($id)
    {
        $ticket = Ticket::where('user_id', Auth::id())
            ->findOrFail($id);

        return view('tickets.show', compact('ticket'));
    }

    // ADMIN: Ver todos los tickets
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
            'priority' => 'required|in:baja,media,alta',
            'status' => 'required|in:abierto,en_proceso,resuelto,cerrado',
            'admin_response' => 'nullable|string|max:2000'
        ]);

        $ticket = Ticket::findOrFail($id);
        
        $ticket->update([
            'priority' => $request->priority,
            'status' => $request->status,
            'admin_response' => $request->admin_response,
            'admin_id' => Auth::id(),
            'resolved_at' => $request->status === 'resuelto' ? now() : null
        ]);

        return redirect()->back()->with('success', 'Ticket actualizado correctamente.');
    }
}
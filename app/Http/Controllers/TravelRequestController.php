<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\TravelRequest;
use App\Notifications\TravelRequestStatusUpdated;



class TravelRequestController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'nome_solicitante' => 'required|string',
            'destino' => 'required|string',
            'data_ida' => 'required|date',
            'data_volta' => 'required|date',
        ]);

        $travelRequest = TravelRequest::create([
            'nome_solicitante' => $request->nome_solicitante,
            'destino' => $request->destino,
            'data_ida' => $request->data_ida,
            'data_volta' => $request->data_volta,
            'status' => 'solicitado',
            'user_id' => auth()->user()->id, // Associar o usuário logado ao pedido
        ]);

        return response()->json($travelRequest, 201);
    }


    public function updateStatus(Request $request, $id)
    {
        $travelRequest = TravelRequest::findOrFail($id);

        if ($travelRequest->user->id === auth()->user()->id) {
            return response()->json(['error' => 'Você não pode alterar o status deste pedido.'], 403);
        }

        $request->validate([
            'status' => 'required|in:aprovado,cancelado',
        ]);

        $travelRequest->status = $request->status;
        $travelRequest->save();

        // Enviar notificação de aprovação ou cancelamento
        if ($travelRequest->user) {
            $travelRequest->user->notify(new TravelRequestStatusUpdated($travelRequest));
        } else {
            return response()->json(['error' => 'Usuário associado não encontrado.'], 404);
        }
        return response()->json($travelRequest);
    }

    public function show($id)
    {
        $travelRequest = TravelRequest::findOrFail($id);

        return response()->json($travelRequest);
    }

    public function index(Request $request)
    {
        $query = TravelRequest::query();

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $travelRequests = $query->get();

        return response()->json($travelRequests);
    }

    public function cancel($id)
    {
        $travelRequest = TravelRequest::findOrFail($id);

        if ($travelRequest->status !== 'aprovado') {
            return response()->json(['error' => 'Este pedido não pode ser cancelado, pois não foi aprovado.'], 400);
        }

        $travelRequest->status = 'cancelado';
        $travelRequest->save();

        return response()->json($travelRequest);
    }

    public function filter(Request $request)
    {

        $query = TravelRequest::query();

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->has('destino')) {
            $query->where('destino', 'like', '%' . $request->destino . '%');
        }
        
        if ($request->has('data_inicial') && $request->has('data_final')) {
            $query->whereBetween('data_ida', [$request->data_inicial, $request->data_final]);
        }
    
        $results = $query->get();
    
        if ($results->isEmpty()) {
            return response()->json(["message" => "Nenhum pedido de viagem encontrado"], 200);
        }
    
        return response()->json($results);
    }
}

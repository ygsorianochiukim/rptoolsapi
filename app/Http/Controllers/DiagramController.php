<?php

namespace App\Http\Controllers;

use App\Models\Diagrams;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DiagramController extends Controller
{
    public function displayDiagrams(){
        $diagramsList = Diagrams::orderByDesc('id')->get();
        return response()->json($diagramsList);
    }
    public function displayDiagramsbyID($id){
        $diagramsList = Diagrams::where('id', $id)->first();
        return response()->json($diagramsList);
    }

    public function storeDiagrams(Request $request){
        $diagramsFields = $request->validate([
            'name' => 'string|required', 
            'description' => 'string|required', 
            'json_data' => 'string|required', 
            'line_category' => 'string|nullable', 
            'node_data' => 'string|nullable', 
            'dependency' => 'string|nullable', 
            'dependency_value' => 'string|nullable', 
            'sheet_url' => 'string|nullable', 
            's_bpartner_i_employee_id' => 'integer|required', 
            'created_by' => 'integer|required', 
        ]);
        $diagramsFields['is_shareable'] = false;
        $diagramsFields['is_active'] = true;
        $diagramsFields['created_date'] = Carbon::now();

        $diagrams = Diagrams::create($diagramsFields);
        return response()->json([
            'message' => 'Diagrams Store Successfuly', 
            'data' => $diagrams
        ],201);
    }
    public function updateDiagrams(Request $request, $id)
    {
        $diagram = Diagrams::find($id);

        if (!$diagram) {
            return response()->json(['message' => 'Diagram not found'], 404);
        }

        $diagramsFields = $request->validate([
            'name' => 'string|required', 
            'description' => 'string|required', 
            'json_data' => 'string|required', 
            'line_category' => 'string|nullable', 
            'node_data' => 'string|nullable', 
            'sheet_url' => 'string|nullable', 
            'dependency' => 'string|nullable', 
            'dependency_value' => 'string|nullable', 
        ]);
        $diagramsFields['is_active'] = true;
        $diagramsFields['created_date'] = Carbon::now();

        $diagram->update($diagramsFields);

        return response()->json([
            'message' => 'Diagram updated successfully',
            'data' => $diagram
        ]);
    }

    public function updateShareable(Request $request, $id)
    {
        $diagram = Diagrams::find($id);

        if (!$diagram) {
            return response()->json(['message' => 'Diagram not found'], 404);
        }

        $diagramsFields = $request->validate([
            'is_shareable' => 'boolean|required', 
        ]);
        $diagram->update($diagramsFields);

        return response()->json([
            'message' => 'Diagram updated successfully',
            'data' => $diagram
        ]);
    }
    public function displayUserDiagrams($userId)
    {
        $owned = Diagrams::where('created_by', $userId)
            ->where('is_active', true)
            ->get();

        $shared = Diagrams::join('shareables', 'diagrams_information.id', '=', 'shareables.diagram_id')
            ->where('shareables.user_id', $userId)
            ->where('diagrams_information.is_shareable', true)
            ->where('diagrams_information.is_active', true)
            ->select('diagrams_information.*')
            ->get();
        $results = $owned->merge($shared)->unique('id')->values();

        return response()->json([
            'owned' => $owned->values(),
            'shared' => $shared->values()
        ]);
    }
}

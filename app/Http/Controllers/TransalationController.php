<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\QuizSubmission;
use App\Models\Translation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TransalationController extends Controller
{

    public function store(Request $request) {

        $key = $request->input('key');
        $value = $request->input('value');
        $lang = $request->input('locale');

        $translation = Translation::where('key', $key)->where('locale', $lang)->first();
        if ($translation) {
            $translation->value = $value;
            $translation->save();
        } else {
            $translation = new Translation();
            $translation->key = $key;
            $translation->value = $value;
            $translation->locale = $lang;
            $translation->save();
        }
        // return redirect()->back();
        return response()->json(['success' => true, 'message' => 'Translation saved successfully']);
    }

    public function index() {
        $translations = Translation::all();
        return view('pages.admin.translations.index', compact('translations'));
    }

    public function list(Request $request) {
        $columns = ['id', 'locale', 'key', 'value'];

        $totalData = Translation::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $translations = Translation::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $translations = Translation::where(function ($query) use ($columns, $search) {
                foreach ($columns as $column) {
                    $query->orWhere($column, 'LIKE', "%{$search}%");
                }
            })
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = Translation::where(function ($query) use ($columns, $search) {
                foreach ($columns as $column) {
                    $query->orWhere($column, 'LIKE', "%{$search}%");
                }
            })->count();
        }

        $data = [];
        if (!empty($translations)) {
            foreach ($translations as $translation) {
                $nestedData['id'] = $translation->id;
                $nestedData['locale'] = config('app.languages')[$translation->locale] ?? '-';
                $nestedData['key'] = $translation->key;
                $nestedData['value'] = $translation->value;
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        );

        return response()->json($json_data);
    }

    public function destroy(Request $request, $id) {
        Translation::findOrFail($id)->delete();
        return response()->json(['success' => true, 'message' => 'Translation deleted successfully']);
    }
        


}   
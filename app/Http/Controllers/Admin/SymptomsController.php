<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\SymptomRepository;
use Illuminate\Http\Request;
use App\Symptom;

class SymptomsController extends Controller
{

  public function index()
  {
    $symptoms = Symptom::whereNull('symptom_id')->get();
    return view('admin.symptoms.index',[
      'symptoms' => $symptoms
    ]);
  }

  public function create()
  {
    return view('admin.symptoms.create');
  }

  public function edit($id)
  {
    $symptom = Symptom::find($id);
    return view('admin.symptoms.edit', [
      'symptom' => $symptom
    ]);
  }

  public function store(Request $request)
  {
    Symptom::create($request->only('content'));
    \Session::flash('success', 'Create Successfully');
    return redirect('/admin/symptoms');
  }

  public function update(Request $request, $id)
  {
    $symptom = Symptom::find($id);
    $symptom->update($request->only('content'));
    $symptom->symptoms()->delete();

    $values = $request->get('values');
    foreach($request->get('symptoms') as $index => $content)
    {
      if(empty($content))
      {
        continue;
      }
      $symptom->symptoms()->create(['content' => $content, 'sort' => $values[$index]]);
    }
    \Session::flash('success', 'Update Successfully');
    return redirect("/admin/symptoms/{$symptom->id}/edit");
  }

  public function destroy($id)
  {
    Symptom::destroy($id);
    \Session::flash('success', 'Destroy Successfully');
    return redirect('/admin/symptoms');
  }
}
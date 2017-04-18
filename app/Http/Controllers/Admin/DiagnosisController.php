<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\SymptomRepository;
use Illuminate\Http\Request;
use App\Diagnose;

class DiagnosisController extends Controller
{

  public function index()
  {
    $diagnosis = Diagnose::orderBy('updated_at', 'DESC')->get();
    return view('admin.diagnosis.index',[
      'diagnosis' => $diagnosis
    ]);
  }

  public function create()
  {
    return view('admin.diagnosis.create');
  }

  public function store(Request $request)
  {
    $this->validate($request, [
      'symptoms' => 'required',
      'result' => 'required'
    ]);

    Diagnose::create($request->only('symptoms', 'result'));
    \Session::flash('success', 'Create Successfully');
    return redirect('/admin/diagnosis');
  }

  public function destroy($id)
  {
    Diagnose::destroy($id);
    \Session::flash('success', 'Destroy Successfully');
    return redirect('/admin/diagnosis');
  }
}
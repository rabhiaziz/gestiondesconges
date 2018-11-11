<?php

namespace App\Modules\Employer\Controllers;

use App\Modules\Employer\Models\Employer;
use App\Modules\Vacation\Models\Vacation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class EmployerController extends Controller
{

    public function index($id)
    {
        $emp = Employer::with('role')->where('id',$id)->first();
        if(!$emp ){
            return redirect()->back();
        }

        $data = [
            'employer' => $emp,
            'vacations' => Vacation::where('employer_id',$id)->paginate(5),
            'allVacations' => Vacation::with('employer')->where('status',1)->where('employer_id','<>',$id)->paginate(5)
        ];
        return view("Employer::index",$data);
    }

    public function handleAddNewVacation($id,Request $request)
    {
        $this->validate($request, [
            'start_date' => 'required',
            'end_date' => 'required',
        ], [
            'start_date.required' => 'La date de début est obligatoire!',
            'end_date.required' => 'La date de fin est obligatoire!',
        ]);

        Vacation::create([
            'start_date' => Carbon::parse($request->start_date)->format('Y-m-d'),
            'end_date' => Carbon::parse($request->end_date)->format('Y-m-d'),
            'status' => 1, // 1 pending application, 2 approved, 3 refused
            'comment' => $request->comment,
            'employer_id' => $id,
        ]);

        $data = [
            'id'=>$id,
            'employer' => Employer::with('role')->where('id',$id)->first(),
            'vacations'=>Vacation::where('employer_id',$id)->paginate(5)
        ];
        return redirect()->back()->with($data);
    }

    public function showEmployerList($id)
    {
        $emp = Employer::with('role')->where('id',$id)->first();
        if(!$emp || $emp->role->id != 1 ){
            return redirect()->back();
        }

        $data = [
            'employer' => $emp,
            'employers' => Employer::with(['role','Vacations'])->where('id','<>',$id)->paginate(5)
        ];
        return view("Employer::employers",$data);
    }

    public function handleUpdateVacation($id,Request $request)
    {
        $emp = Employer::with('role')->where('id',$id)->first();
        $vacation = Vacation::find($id);
        $vacation->update(['status' => $request->approve]);
        $data = [
            'employer' => $emp,
            'vacations'=>Vacation::where('employer_id',$id)->paginate(5)
        ];
        return redirect()->back()->with($data);
    }
}

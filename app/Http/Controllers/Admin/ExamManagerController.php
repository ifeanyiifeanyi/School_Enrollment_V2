<?php

namespace App\Http\Controllers\Admin;

use App\Models\Department;
use App\Models\ExamManager;
use App\Models\ExamSubject;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ExamManagerController extends Controller
{
    public function index()
    {
        $subjects = ExamSubject::latest()->get();
        $departments = Department::doesntHave('exam_managers')->get();
        return view('admin.subjects.index', compact('departments', 'subjects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'department_id' => 'required|exists:departments,id',
            'exam_subject.*' => 'required',
            'venue' => 'required',
            'date_time' => 'required',
        ], [
            'exam_subject.*.required' => 'Please enter exam subject',
        ]);

        $examSubjects = $request->input('exam_subject');
        $examSubjectsJson = json_encode($examSubjects);

        $exam = new ExamManager;
        $exam->department_id = $request->input('department_id');
        $exam->exam_subject = $examSubjectsJson;
        $exam->venue = $request->input('venue');
        $exam->date_time = $request->input('date_time');
        $exam->save();


        $notification = [
            'message' => 'Department Exam Subject Created!',
            'alert-type' => 'success'
        ];

        return redirect()->back()->with($notification);
    }

    public function examDetails()
    {
        $exams = ExamManager::latest()->simplePaginate('20');
        return view('admin.subjects.details', compact('exams'));
    }

    public function examInformation($id){
        $exam = ExamManager::find($id);
        return view('admin.subjects.information', compact('exam'));
    }

    public function edit($id){
        $examSubject = ExamSubject::latest()->get();
        $exam = ExamManager::find($id);
        $departments = Department::all();
        return view('admin.subjects.edit', compact('exam', 'departments', 'examSubject'));
    }

    public function update(Request $request, $id){
        $request->validate([
            'department_id' => 'required|exists:departments,id',
            'exam_subject.*' => 'required|string',
            'venue' => 'required|string',
            'date_time' => 'required',
        ], [
            'exam_subject.*.required' => 'Please enter exam subject',
        ]);

        $examSubjects = $request->input('exam_subject');
        $examSubjectsJson = json_encode($examSubjects);

        $exam = ExamManager::find($id);
        $exam->department_id = $request->input('department_id');
        $exam->exam_subject = $examSubjectsJson;
        $exam->venue = $request->input('venue');
        $exam->date_time = $request->input('date_time');
        $exam->save();

        $notification = [
            'message' => 'Department Exam Subject Update!',
            'alert-type' => 'success'
        ];

        return redirect()->route('admin.exam.details')->with($notification);
    }

    public function destroy($id){
        $exam = ExamManager::find($id);
        // dd($exam);
        $exam->delete();

        $notification = [
           'message' => 'Department Exam Subject Deleted!',
            'alert-type' => 'success'
        ];

        return redirect()->back()->with($notification);
    }




    public function subjects(){
        $subjects = ExamSubject::latest()->get();
        return view("admin.subjects.examSubject", compact('subjects'));
    }

    public function subjectStore(Request $request){
        $request->validate([
            'name' =>'required|string|unique:exam_subjects'
        ]);

        ExamSubject::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ]);

        $notification = [
           'message' => 'Exam Subject Created!',
            'alert-type' =>'success'
        ];

        return redirect()->back()->with($notification);
    }

    public function subjectDel(ExamSubject $subject){
        $subject->delete();

        $notification = [
           'message' => 'Exam Subject Deleted!',
            'alert-type' =>'success'
        ];

        return redirect()->back()->with($notification);
    }
}

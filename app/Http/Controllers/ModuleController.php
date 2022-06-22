<?php

namespace App\Http\Controllers;

use App\Course;
use App\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
Use Image;
use Illuminate\Support\Facades\Storage;

class ModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->input('course_id')){
            $modules = Module::where("course_id", $request->input('course_id'))->orderBy('module_order')->get();
        }else
            $modules = Module::orderBy('module_order')->get();
        return view('admin.modules.index')->with('modules',$modules);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.modules.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'module_name' => 'required|max:255',
            'module_slug' => 'required|max:50',
            'module_type' => 'required',
            'video_url' => 'max:100',
            'module_content' => 'max:5000',
            //'module_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
       
        $module_order = 2;
        if($request->module_type=='pre')
            $module_order = 1;
        else if($request->module_type=='post')
            $module_order = Module::where('course_id',$request->course_id)->count()+1;
        else {
            $moduleLists = Module::select('module_type')->where('course_id',$request->course_id)->orderBy('module_order')->get(); 
            $module_order = count($moduleLists);
                
            if($moduleLists->contains('module_type','post')) {
                Module::where([['course_id',$request->course_id],['module_type','post']])->update(['module_order' => $module_order+1]);
            } 
        }
        
        $module = new Module;
        $module->module_name = $request->module_name;
        $module->course_id = $request->course_id;
        $module->module_slug = $request->module_slug;
        $module->module_type = $request->module_type;
        $module->video_url = $request->video_url;
        $module->module_content = $request->module_content;
        $module->module_order = $module_order;
        if($request->hasFile('module_image')) {

            $filename = $fileName = time().'.'.$request->module_image->extension();
            $request->module_image->move(public_path('images/modules'), $fileName);
            $module->module_image = $filename;
        }
        $module->save();

        if($request->module_type=='pre' || $request->module_type=='post') {
            
            $quiz = new QuizController;
            
            $quizPassingRateRequest = new Request([
                'course_id' => $request->course_id, 
                'attempt' => 1,
                'score' => $request->passing_rate,
                'exam_type' => $request->module_type
            ]);
            $quiz->setPassingRate($quizPassingRateRequest);

            foreach($request->questions as $question) {
                
                $quizRequest = new Request([
                    'course_id' => $request->course_id,
                    'question' => $question['text'],
                    'quiz_type' => $request->module_type,
                    'score_value' => 1
                ]);
                $newQuizObj = $quiz->store($quizRequest);

                foreach($question['choices'] as $choice) {
                    
                    $quizChoiceRequest = new Request([
                        'quiz_id' => $newQuizObj->id,
                        'choice' => $choice['text'],
                        'is_correct' => $choice['isCorrect']
                    ]); 
                    $quiz->setChoices($quizChoiceRequest);
                }
            }
            
            return 0;
        }
        //return url('admin/modules?course_id='. $module->course_id);
        return redirect('admin/modules?course_id='. $module->course_id)->with('message', 'Module successfully created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Module  $module
     * @return \Illuminate\Http\Response
     */
    public function show(Module $module)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Module  $module
     * @return \Illuminate\Http\Response
     */
    public function edit(Module $module)
    {
        //
        return view('admin.modules.edit', compact('module'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Module  $module
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Module $module)
    {
        //
        $request->validate([
            'module_name' => 'required|max:255',
            'module_slug' => 'required|max:50',
            'module_type' => 'required',
            'video_url' => 'max:100',
            'module_content' => 'max:5000',
            'module_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        $module->update($request->all());
        $module->module_name = $request->module_name;
        $module->module_slug = $request->module_slug;
        $module->module_content = $request->module_content;
        $module->module_type = $request->module_type;
        $module->video_url = $request->video_url;
        if($request->hasFile('module_image')) {
            $filename = $fileName = time().'.'.$request->module_image->extension();
            $request->module_image->move(public_path('images/modules'), $fileName);
            $module->module_image = $filename;
            // $image = $request->file('module_image')->store('modules');
            // $module->module_image = Storage::url($image);
        }
        $module->save();
        return redirect('admin/modules?course_id='. $module->course_id)->with('message', 'Module successfully created!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Module  $module
     * @return \Illuminate\Http\Response
     */
    public function destroy(Module $module)
    {
        //
        $module->delete();
        return redirect('admin/modules?course_id='. $module->course_id)->with('danger-message', 'Module successfully deleted!');
    }
}

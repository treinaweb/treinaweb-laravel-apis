<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\StudentRequest;
use App\Http\Resources\Student as StudentResource;
use App\Http\Resources\Students as StudentCollection;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->query('includes') === 'classroom') {
            $students = Student::with('classroom')->paginate(2);
        } else {
            $students = Student::paginate(2);
        }

        return (new StudentCollection($students))
                    ->response()
                    ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StudentRequest $request)
    {
       return Student::create($request->all());
    } 

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        if (request()->header("Accept") === "application/xml") {
            return $this->getStudentXmlResponse($student);
        }

        if (request()->wantsJson()) {
            return new StudentResource($student);
        }

        return response(['message'=>'não conheço esse formato']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StudentRequest $request, Student $student)
    {
        $student->update($request->all());

        return [];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        $student->delete();

        return [];
    }

    public function getStudentXmlResponse($student)
    {
       $student = $student->toArray();

       $xml = new \SimpleXMLElement('<student/>');

       array_walk_recursive($student, function($value, $key) use ($xml) {
            $xml->addChild($key, $value);
       });

       return response($xml->asXML(), 200)
                    ->header('Content-Type', 'application/xml');
    }
}

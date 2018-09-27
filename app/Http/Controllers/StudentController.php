<?php

/**
 * @SWG\Swagger(
 *     basePath="/api",
 *     schemes={"http"},
 *     host="http://escola.test",
 *     @SWG\Info(
 *         version="1.0.0",
 *         title="API Treinaweb",
 *         description="Projeto de API do curso de Laravel do Treinaweb",
 *         @SWG\Contact(
 *             email="elton.fonseca@treinaweb.com.br"
 *         ),
 *     )
 * )
 */


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
     * @SWG\Get(
     *      path="/students",
     *      operationId="getstudentsList",
     *      tags={"students"},
     *      summary="Get list of students",
     *      description="Returns list of students",
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *       @SWG\Response(response=400, description="Bad request"),
     *       security={
     *           {"api_key_security_example": {}}
     *       }
     *     )
     *
     * Returns list of students
     */

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->query('includes') === 'classroom') {
            $students = Student::with('classroom')->paginate(20);
        } else {
            $students = Student::paginate(20);
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
     * @SWG\Get(
     *      path="/students/{id}",
     *      operationId="getStudentById",
     *      tags={"students"},
     *      summary="Get Student information",
     *      description="Returns Student data",
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *      @SWG\Response(response=400, description="Bad request"),
     *      @SWG\Response(response=404, description="Resource Not Found"),
     *      security={
     *         {
     *             "oauth2_security_example": {"write:students", "read:students"}
     *         }
     *     },
     * )
     *
     */
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        $student->load('classroom');

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

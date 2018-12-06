<?php

namespace App\Http\Controllers;

use App\Section;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\SectionRequest;

class SectionController extends Controller
{
    /**
     * Get section data from the database.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getSection($id)
    {
        $section = Section::where('id', $id)->with('users')->first();
        return response()->json($section, Response::HTTP_OK);
    }

    /**
     * Get the sections from the database and paginate with 5 results each page.
     *
     * @return \Illuminate\Http\Response
     */
    public function getSections()
    {
        $sections = Section::with('users')->paginate(5);
        return response()->json($sections, Response::HTTP_OK);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('sections.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('sections.edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  SectionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SectionRequest $request)
    {
        $path = $request->file('logo')->store('logo');
        $input = $request->all();
        $input['logo'] = $path;

        $section = Section::create($input);
        $section->users()->attach($request->users);
        return redirect('section');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function edit(Section $section)
    {
        return view('sections.edit', ['section' => $section]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  SectionRequest  $request
     * @param  \App\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function update(SectionRequest $request, Section $section)
    {
        $input = $request->all();
        if($request->has('logo')) {
            $path = $request->file('logo')->store('logo');
            $input['logo'] = $path;
        }
        $section->update($input);
        $section->users()->sync($request->users);
        return redirect('section');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function destroy(Section $section)
    {
        try {
            $section->delete();
        }catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json(['message' => 'OK'], Response::HTTP_OK);
    }
}

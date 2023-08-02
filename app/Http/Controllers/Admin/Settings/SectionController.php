<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Models\Section;
use Illuminate\Http\Request;
use App\Http\Traits\RedirectTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Sections\StoreSectionRequest;
use App\Http\Requests\Sections\UpdateSectionRequest;

class SectionController extends Controller
{
    use RedirectTrait;

    public function index()
    {
        $sections = Section::get();
        return view("Admin.pages.sections.index",compact("sections")); //compact: var name not var
    }

    public function create()
    {
        return view("Admin.pages.sections.create");
    }

    public function store(StoreSectionRequest $request)
    {
        Section::create([
            "name" => $request->name,
            "description" => $request->description,
            "created_by" => auth()->user()->name,
        ]);

        return $this->redirect("Section Has Been Created Successfully","admin.sections.index");

    }

    public function edit(Section $section)
    {
        return view("Admin.pages.sections.edit",compact("section"));
    }

    public function update(UpdateSectionRequest $request , Section $section)
    {
        $section->update([
            "name" => $request->name,
            "description" => $request->description,
            "created_by" => auth()->user()->name,
        ]);

        return $this->redirect("Section Has Been Updated Successfully","admin.sections.index");
    }

    public function destroy(Section $section)
    {
        $section->delete();
        return $this->redirect("Section Has Been Deleted Successfully","admin.sections.index");
    }

}

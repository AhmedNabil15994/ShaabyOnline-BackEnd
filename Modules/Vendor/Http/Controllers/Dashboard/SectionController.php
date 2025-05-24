<?php

namespace Modules\Vendor\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Core\Traits\DataTable;
use Modules\Vendor\Http\Requests\Dashboard\SectionRequest;
use Modules\Vendor\Transformers\Dashboard\SectionResource;
use Modules\Vendor\Repositories\Dashboard\SectionRepository as Section;

class SectionController extends Controller
{
    protected $section;

    function __construct(Section $section)
    {
        $this->section = $section;
    }

    public function index()
    {
        return view('vendor::dashboard.sections.index');
    }

    public function datatable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->section->QueryTable($request));

        $datatable['data'] = SectionResource::collection($datatable['data']);

        return Response()->json($datatable);
    }

    public function create()
    {
        return view('vendor::dashboard.sections.create');
    }

    public function store(SectionRequest $request)
    {
        try {
            $create = $this->section->create($request);

            if ($create) {
                return Response()->json([true, __('apps::dashboard.general.message_create_success')]);
            }

            return Response()->json([false, __('apps::dashboard.general.message_error')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function show($id)
    {
        abort(404);
        return view('vendor::dashboard.sections.show');
    }

    public function edit($id)
    {
        $section = $this->section->findById($id);
        if (!$section)
            abort(404);

        return view('vendor::dashboard.sections.edit', compact('section'));
    }

    public function update(SectionRequest $request, $id)
    {
        try {
            $update = $this->section->update($request, $id);

            if ($update) {
                return Response()->json([true, __('apps::dashboard.general.message_update_success')]);
            }

            return Response()->json([false, __('apps::dashboard.general.message_error')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function destroy($id)
    {
        try {
            $delete = $this->section->delete($id);

            if ($delete) {
                return Response()->json([true, __('apps::dashboard.general.message_delete_success')]);
            }

            return Response()->json([false, __('apps::dashboard.general.message_error')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function deletes(Request $request)
    {
        try {
            $deleteSelected = $this->section->deleteSelected($request);

            if ($deleteSelected) {
                return Response()->json([true, __('apps::dashboard.general.message_delete_success')]);
            }

            return Response()->json([false, __('apps::dashboard.general.message_error')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }
}

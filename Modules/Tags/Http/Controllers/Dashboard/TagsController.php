<?php

namespace Modules\Tags\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Core\Traits\DataTable;
use Modules\Tags\Http\Requests\Dashboard\TagRequest;
use Modules\Tags\Transformers\Dashboard\TagsResource;
use Modules\Tags\Repositories\Dashboard\TagsRepository as Tag;

class TagsController extends Controller
{
    protected $tag;

    function __construct(Tag $tag)
    {
        $this->tag = $tag;
    }

    public function index()
    {
        return view('tags::dashboard.tags.index');
    }

    public function datatable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->tag->QueryTable($request));
        $datatable['data'] = TagsResource::collection($datatable['data']);
        return Response()->json($datatable);
    }

    public function create()
    {
        return view('tags::dashboard.tags.create');
    }

    public function store(TagRequest $request)
    {
        try {
            $create = $this->tag->create($request);

            if ($create) {
                return Response()->json([true, __('apps::dashboard.general.message_create_success')]);
            }

            return Response()->json([false, __('apps::dashboard.general.message_error')]);
        } catch (\Exception $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function show($id)
    {
        return view('tags::dashboard.tags.show');
    }

    public function edit($id)
    {
        $tag = $this->tag->findById($id);
        if (!$tag)
            abort(404);
        return view('tags::dashboard.tags.edit', compact('tag'));
    }

    public function clone($id)
    {
        $tag = $this->tag->findById($id);
        if (!$tag)
            abort(404);
        return view('tags::dashboard.tags.clone', compact('tag'));
    }

    public function update(TagRequest $request, $id)
    {
        try {
            $update = $this->tag->update($request, $id);

            if ($update) {
                return Response()->json([true, __('apps::dashboard.general.message_update_success')]);
            }

            return Response()->json([false, __('apps::dashboard.general.message_error')]);
        } catch (\Exception $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function destroy($id)
    {
        try {
            $delete = $this->tag->delete($id);

            if ($delete) {
                return Response()->json([true, __('apps::dashboard.general.message_delete_success')]);
            }

            return Response()->json([false, __('apps::dashboard.general.message_error')]);
        } catch (\Exception $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function deletes(Request $request)
    {
        try {
            $deleteSelected = $this->tag->deleteSelected($request);

            if ($deleteSelected) {
                return Response()->json([true, __('apps::dashboard.general.message_delete_success')]);
            }

            return Response()->json([false, __('apps::dashboard.general.message_error')]);
        } catch (\Exception $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }
}

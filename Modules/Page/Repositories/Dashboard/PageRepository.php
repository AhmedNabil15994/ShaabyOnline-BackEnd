<?php

namespace Modules\Page\Repositories\Dashboard;

use Modules\Page\Entities\Page;
use Hash;
use DB;

class PageRepository
{

    function __construct(Page $page)
    {
        $this->page   = $page;
    }

    public function getAllActive($order = 'id', $sort = 'desc')
    {
        $pages = $this->page->active()->orderBy($order, $sort)->get();
        return $pages;
    }

    public function getAll($order = 'id', $sort = 'desc')
    {
        $pages = $this->page->orderBy($order, $sort)->get();
        return $pages;
    }

    public function findById($id)
    {
        $page = $this->page->withDeleted()->find($id);
        return $page;
    }

    public function create($request)
    {
        DB::beginTransaction();

        try {

          $page = $this->page->create([
            'page_id'  => $request->page_id ? $request->page_id : null,
            'status'   => $request->status ? 1 : 0,
            'type'     => $request->type ? 1 : 0,
            "title"    => $request->title,
            "description"=> $request->description,
            "seo_description"=> $request->seo_description,
            "seo_keywords"=> $request->seo_keywords,
          ]);


          DB::commit();
          return true;

        }catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
    }

    public function update($request,$id)
    {
        DB::beginTransaction();

        $page = $this->findById($id);
        $restore = $request->restore ? $this->restoreSoftDelte($page) : null;

        try {

            $page->update([
              'page_id'  => $request->page_id ? $request->page_id : null,
              'status'   => $request->status ? 1 : 0,
              'type'     => $request->type ? 1 : 0,
              "title"    => $request->title ,
              "description"=> $request->description,
              "seo_description"=> $request->seo_description,
              "seo_keywords"=> $request->seo_keywords,
            ]);

           

            DB::commit();
            return true;

        }catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
    }

    public function restoreSoftDelte($model)
    {
        $model->restore();
    }

   

    public function delete($id)
    {
        DB::beginTransaction();

        try {

            $model = $this->findById($id);

            if ($model->trashed()):
              $model->forceDelete();
            else:
              $model->delete();
            endif;

            DB::commit();
            return true;

        }catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
    }

    public function deleteSelected($request)
    {
        DB::beginTransaction();

        try {

            foreach ($request['ids'] as $id) {
                $model = $this->delete($id);
            }

            DB::commit();
            return true;

        }catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
    }

    public function QueryTable($request)
    {
        $query = $this->page->where(function($query) use($request){
                      $query->where('id', 'like' , '%'. $request->input('search.value') .'%');
                      $query->orWhere( function( $query ) use($request){
                        $query->where('description'        , 'like' , '%'. $request->input('search.value') .'%');
                        $query->orWhere('title'            , 'like' , '%'. $request->input('search.value') .'%');
                        $query->orWhere('slug'             , 'like' , '%'. $request->input('search.value') .'%');
                      });
                });

        $query = $this->filterDataTable($query,$request);

        return $query;
    }

    public function filterDataTable($query,$request)
    {
        // Search Pages by Created Dates
        if (isset($request['req']['from']) && $request['req']['from'] != '')
            $query->whereDate('created_at'  , '>=' , $request['req']['from']);

        if (isset($request['req']['to']) && $request['req']['to'] != '')
            $query->whereDate('created_at'  , '<=' , $request['req']['to']);

        if (isset($request['req']['deleted']) &&  $request['req']['deleted'] == 'only')
            $query->onlyDeleted();

        if (isset($request['req']['deleted']) &&  $request['req']['deleted'] == 'with')
            $query->withDeleted();

        if (isset($request['req']['status']) &&  $request['req']['status'] == '1')
            $query->active();

        if (isset($request['req']['status']) &&  $request['req']['status'] == '0')
            $query->unactive();

        return $query;
    }

}

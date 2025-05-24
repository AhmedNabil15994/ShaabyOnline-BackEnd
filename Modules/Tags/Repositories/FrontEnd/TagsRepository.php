<?php

namespace Modules\Tags\Repositories\FrontEnd;

use Modules\Tags\Entities\Tag;
use Illuminate\Support\Facades\DB;

class TagsRepository
{
    protected $tag;

    function __construct(Tag $tag)
    {
        $this->tag = $tag;
    }

    public function getAll($order = 'id', $sort = 'desc')
    {
        $tags = $this->tag->orderBy($order, $sort)->get();
        return $tags;
    }

    public function getAllActive($order = 'id', $sort = 'desc')
    {
        $tags = $this->tag->orderBy($order, $sort)->active()->get();
        return $tags;
    }

    public function findById($id)
    {
        $tag = $this->tag->withDeleted()->find($id);
        return $tag;
    }

}

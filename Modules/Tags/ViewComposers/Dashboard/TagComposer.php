<?php

namespace Modules\Tags\ViewComposers\Dashboard;

use Modules\Tags\Repositories\Dashboard\TagsRepository as Tag;
use Illuminate\View\View;
use Cache;

class TagComposer
{
    public $tags = [];

    public function __construct(Tag $tag)
    {
        $this->tags = $tag->getAllActive();
    }

    /**
     * Bind data to the view.
     *
     * @param View $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('tags', $this->tags);
    }
}

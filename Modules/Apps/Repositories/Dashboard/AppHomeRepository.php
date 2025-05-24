<?php

namespace Modules\Apps\Repositories\Dashboard;

use Modules\Apps\Entities\AppHome;
use Modules\Core\Repositories\Dashboard\CrudRepository;

class AppHomeRepository extends CrudRepository
{
    public function __construct()
    {
        parent::__construct(new AppHome());
    }

    public function modelCreated($model, $request, $is_created = true): void
    {
        $type = $request->type;
        if($type != 'description'){

            $model->$type()->attach($request->$type);
        }

        parent::modelCreated($model, $request, $is_created);
    }

    public function modelUpdated($model, $request): void
    {
        $type = $request->type;

        if($type != 'description'){

            $model->$type()->sync($request->$type);
        }

        parent::modelUpdated($model, $request);
    }
}

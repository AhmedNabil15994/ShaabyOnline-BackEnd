<?php


namespace Modules\Catalog\Imports;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\ToModel;
use Modules\Catalog\Repositories\Dashboard\ProductRepository;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Modules\Catalog\Entities\Category;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ProductImport implements ToCollection, WithHeadingRow
{
    private $request;
    private $repo;

    public function __construct(Request $request)
    {
        $this->request = $this->requestInitializing($request);
    }

    public function collection(Collection $rows)
    {
        $this->repo = new ProductRepository();

        foreach ($rows as $row) 
        {
            $request = new Request();

            if(isset($row[$this->request['category']]) && $row[$this->request['category']]){
                
                $categoriesNames = explode(',',$row[$this->request['category']]);
                $categories = Category::whereIn('title->ar', $categoriesNames)->orWhereIn('title->en', $categoriesNames)->pluck('id')->toArray();

            }else{
                $categories = $this->request['category_id'];
            }
        
            $request->replace([
                'category_id' => $categories && count($categories) ?  $categories : [1],
                'imported_excel' => 1,
                'qty' => $this->request['qty'] ?
                    $row[$this->request['qty']] : null,
                'manage_qty' => $this->request['qty'] ?
                    'limited' : null,
                'status' => $this->request['status'] ?
                    $row[$this->request['status']] : null,
                'title' => [
                    'en' => $this->request['title_en'] ?
                        $row[$this->request['title_en']] : '',
                    'ar' => $this->request['title_ar'] ?
                        $row[$this->request['title_ar']]: '',
                ],
                'description' => [
                    'en' => $this->request['description_en'] ?
                        $row[$this->request['description_en']] : '',
                    'ar' => $this->request['description_ar'] ?
                        $row[$this->request['description_ar']]: '',
                ],
                'price' => $row[$this->request['price']],
                'sku' => $this->request['sku'] ? preg_replace('/\s+/', '', $row[$this->request['sku']]) : null,
                'offer_type' => 'amount',
                'offer_status' =>   $this->request['offer_price'] && $this->request['offer_start_at'] && $this->request['offer_end_at']
                                    && $row[$this->request['offer_price']] && $row[$this->request['offer_start_at']] && $row[$this->request['offer_end_at']] ? 
                    'on' : null,
                'offer_price' => $this->request['offer_price'] && $row[$this->request['offer_price']] ? $row[$this->request['offer_price']] : null,
                'start_at' => $this->request['offer_start_at'] && $row[$this->request['offer_start_at']] ? $row[$this->request['offer_start_at']] : null,
                'end_at' => $this->request['offer_end_at'] && $row[$this->request['offer_end_at']] ? $row[$this->request['offer_end_at']] : null,
            ]);
            
            $model = $request->sku ? $this->repo->findBySku($request->sku) : null;

            if($model){

                return $this->repo->update($request,$model->id);
            }else{

                return $this->repo->create($request);
            }
        }
    }

    private function requestInitializing($oldRequest){

        $request = [];
        dd($oldRequest->all());
        foreach($oldRequest->all() as $key => $value){
            if (!in_array($key,['excel_file','images']))
                $request[$key] = str_replace(' ' ,'_',strtolower($oldRequest[$key])) ?? null;
            else
            $request[$key] = $value;
        }

        return $request;
    }
}
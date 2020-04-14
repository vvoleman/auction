<?php

namespace App\Http\Controllers;

use App\Offer;
use App\OfferSell;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AdminPanelController extends Controller
{

    private $months = [
        'Leden',
        'Únor',
        'Březen',
        'Duben',
        'Květen',
        'Červen',
        'Červenec',
        'Srpen',
        'Září',
        'Říjen',
        'Listopad',
        'Prosinec'
    ];

    public function getPanel(){
    	return view('admin/panel/panel');
    }

    //API
    public function ajaxGetBits(){
        $registered = User::count();
        $active = Offer::whereNull('sold_to')->whereNull('delete_reason')->whereDate('end_date','>=',Carbon::now())->count();
        $selled_today = OfferSell::whereDate('confirmed_at',Carbon::today())->count();
        $today = User::whereDate('last_logged',Carbon::today())->count();

        return [
            ["label"=>"reg. uživatelů","value"=>$registered],
            ["label"=>"akt. nabídky","value"=>$active],
            ["label"=>"dnes prodáno","value"=>$selled_today],
            ["label"=>"dnes přihlášeno","value"=>$today]
        ];
    }
    public function ajaxGetByYear(){
        $users = $this->getUsers();
        $offers = $this->getOffers();
        $toReturn = [];
        if(sizeof($users) > 0){
            $toReturn[] = $users;
        }
        if(sizeof($offers) > 0){
            $toReturn[] = $offers;
        }
        return $toReturn;
    }
    public function ajaxGetCategoryPercentage(){
        return $this->getCategoryPercentage();
    }

    private function getUsers(){
        $res = User::select(DB::raw("count(id_u) as amount,YEAR(created_at) as year, MONTH(created_at) as month"))->orderBy("created_at")->groupBy(DB::raw("YEAR(created_at),MONTH(created_at)"))->get();
        foreach($res as $r){
            $data[$r["year"]][$r["month"]-1] = $r["amount"];
        }

        $data = $this->addZero($data);

        $years = [];
        foreach($data as $key => $d){
            $years[] = [
                "year"=>$key,
                "graph"=>[
                    "name"=>"Registrovaní uživatelé",
                    "labels"=>$this->months,
                    "datasets"=>[$this->createDataset("Počet","#42b883",$d)]
                ]
            ];
        }
        return $years;
    }
    private function getOffers(){
        //vytvořené
        $created = Offer::select(DB::raw("count(id_o) as amount, YEAR(created_at) as year,MONTH(created_at) as month"))
            ->groupBy(DB::raw("YEAR(created_at),MONTH(created_at)"))
            ->get();
        $categories = Offer::select(DB::raw("count(id_c) as amount, categories.label as name, YEAR(offers.created_at) as year,MONTH(offers.created_at) as month"))
            ->groupBy(DB::raw("YEAR(offers.created_at),MONTH(offers.created_at),categories.label"))
            ->join("categories","offers.category_id","=","categories.id_c")
            ->get();


        $data = collect($this->formatCategories($categories));
        $offers = $this->formatOffers($created);

        foreach($offers as $key => $o){
            $i = $data->search(function($x)use($key) {
                return $x["year"] === $key;
            });
            $temp = $data[$i];
            $temp["graph"]["datasets"][] = [
                "label"=>"Vytvořeno",
                "backgroundColor"=>"#42b883",
                "data"=>$o
            ];
            $data[$i] = $temp;
        }
        return $data;
    }
    private function getCategoryPercentage(){
        $total = Offer::whereNull('sold_to')->whereNull('delete_reason')->count();
        $labels = [];
        $data = [];
        $colors = [];
        $offers = Offer::whereNull('sold_to')->whereNull('delete_reason')
            ->select(DB::raw('count(id_o) as amount, categories.label as name'))
            ->join('categories','offers.category_id','=','categories.id_c')
            ->groupBy('categories.id_c')
            ->get();

        foreach($offers as $o){
            $labels[] = $o->name;
            $data[] = round($o["amount"]/$total*100,2);
            $colors[] = $this->genereteColor();
        }
        return [
            "datasets"=>[
                "data"=>$data,
                "backgroundColor"=>$colors
            ],
            "labels"=>$labels
        ];
    }

    private function addZero($data){
        foreach($data as $key => $d){
            for($i=0;$i<12;$i++){
                if(!isset($d[$i])){
                    $data[$key][$i] = 0;
                }
            }
            $data[$key] = array_values($data[$key]);
        }
        return $data;
    }
    private function createDataset($label,$color,$data){
        return [
            "label"=>$label,
            "backgroundColor"=>$color,
            "data"=>$data
        ];
    }
    private function formatOffers($offers){
        $data = [];
        foreach($offers as $o){
            $data[$o["year"]][$o["month"]] = $o["amount"];
        }
        return $this->addZero($data);
    }
    private function formatCategories($categories){
        $data = [];
        foreach ($categories as $c){
            $data[$c["year"]][$c["name"]][$c["month"]-1] = $c["amount"];
        }
        $years = [];
        foreach($data as $key => $d){
            $datasets = [];
            $withZero = $this->addZero($d);
            foreach($d as $cat_key => $c){
                $datasets[] = $this->createDataset($cat_key,$this->genereteColor(),$withZero[$cat_key]);
            }
            $years[] = [
                "year"=>$key,
                "graph"=>[
                    "name"=>"Nabídky",
                    "labels"=>$this->months,
                    "datasets"=>$datasets
                ]
            ];
        }
        return $years;
    }
    private function genereteColor(){
        return "#".dechex(rand(0x000000, 0xFFFFFF));
    }
}

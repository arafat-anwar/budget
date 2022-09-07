<?php
function is_save($object,$message){
    if($object){
        success($message);
        return redirect()->back();
    }

    whoops();
    return redirect()->back();
}

function success($message='Your operation has been done successfully'){
    session()->flash('success',$message);
}

function whoops($message='Whoops! Something went Wrong!'){
    session()->flash('danger',$message);
}

function mysqlQuery($query){
    return \Str::replaceArray('?', $query->getBindings(), $query->toSql());
}

function getBudget($sector_id, $year, $month){
    $budget = DB::select("select * from `budget` where `sector_id` = '".$sector_id."' and `year` = '".$year."' and `month` = '".$month."' limit 1");
    return isset($budget[0]->id) ? ['budget' => $budget[0]->budget, 'remarks' => $budget[0]->remarks] : ['budget' => 0, 'remarks' => ''];
}

function getEntry($sector_id, $year, $month){
    $date = $year.'-'.$month;
    return DB::select("select sum(`amount`) as amount from `entries` where `sector_id` = '".$sector_id."' and substr(`date`, 1, 7) = '".$date."'")[0]->amount;
}
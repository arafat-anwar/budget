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

function getMySqlQuery($query){
    return \Str::replaceArray('?', $query->getBindings(), $query->toSql());
}

function getBudget($sector_id, $year, $month){
    $budget = \App\Models\Budget::where([
        'sector_id' => $sector_id,
        'year' => $year,
        'month' => $month,
    ])->first();
    return isset($budget->id) ? ['budget' => $budget->budget, 'remarks' => $budget->remarks] : ['budget' => 0, 'remarks' => ''];
}

function getEntry($sector_id, $year, $month){
    return \App\Models\Entry::where([
        'sector_id' => $sector_id,
    ])
    ->whereRaw('substr(`date`, 1, 10)', $year.'-'.$month)
    ->sum('amount');
}
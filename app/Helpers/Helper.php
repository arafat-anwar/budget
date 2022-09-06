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
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    public function add() {

      //dd(rq());

      if(!user_ins()->is_logged_in())
        return ['status' => 0, 'msg' => 'login required'];

      if(!rq('title'))
        return ['status' => 0, 'msg' => 'title required'];

      $this->title = rq('title');
      $this->user_id = session('user_id');
      if(rq('desc'))
        $this->desc = rq('desc');

      return $this->save() ?
        ['status' => 1, 'id' => $this->id] :
        ['status' => 0, 'msg' => 'DB insert failed'];
    }

    public function change() {
       if(!user_ins()->is_logged_in())
        return ['status' => 0, 'msg' => 'login required'];

       if(!rq('id'))
        return ['status' => 0, 'msg' => 'id required'];

       $question = $this->find(rq('id'));
       if(!$question)
        ['status' => 0, 'msg' => 'Question not exist'];
       if($question->user_id != session('user_id'))
        return ['status' => 0, 'msg' => 'permission denied'];

       if(rq('title'))
        $question->title = rq('title');
       if(rq('desc'))
        $question->desc = rq('desc');

      return $question->save() ?
        ['status' => 1] :
        ['status' => 0, 'msg' => 'DB update failed'];
    }

    public function read() {
      if(rq('id')) return ['status' => 1, 'data' => $this->find(rq('id'))];

      $limit = rq('limit') ? : 2;
      $skip = ((rq('page') ? : 1 ) - 1)* $limit;
      $r = $this
        ->orderBy('created_at')
        ->limit($limit)
        ->skip($skip)
        ->get(['id', 'title', 'desc', 'user_id'])
        ->keyBy('id');

      return ['status' => 1, 'data' => $r];
    }

    public function remove() {
      if(!user_ins()->is_logged_in())
        return ['status' => 0, 'msg' => 'login required'];

      if(!rq('id'))
        return ['status' => 0, 'msg' => 'id required'];

      $question = $this->find(rq('id'));
      if(!$question) return ['status' => 0, 'msg' => 'question not exist'];

      if(session('user_id') != $question->user_id)
        return ['status' => 0, 'msg' => 'permission denied'];


      return $question->delete() ?
        ['status' => 1] :
        ['status' => 0, 'msg' => 'DB delete failed'];
    }
}

<?php

class ForumController extends BaseController
{
	public function index()
	{
		$groups = ForumGroup::all();
		$categories = ForumCategory::all(); 
		return View::make('forum.index')->with('groups', $groups)->with('categories', $categories);
	} 

	public function category($id)
	{

	}

	public function thread($id)
	{

	}


	public function storeGroup()
	{
		$validator = Validator::make(Input::all(), array(
			'group_name' => 'required|unique:forum_groups,title'
		));
		if($validator->fails())
		{
			return Redirect::route('forum-home')->withInput()->withErrors($validator)->with('modal', '#group_form');
		}
		else
		{
			$group = new ForumGroup;
			$group->title = Input::get('group_name');
			$group->author_id = Auth::user()->id;

			if ($group->save())
			{
				return Redirect::route('forum-home')->with('success','Group Created');
			}
			else
			{
				return Redirect::route('forum-home')->with('fail','Group Creatation Failed, Please try again');
			}
		}
	}

	public function deleteGroup($id)
	{
		$group =ForumGroup::find($id);
		if ($group == null)
		{
			return Redirect::route('forum-home')->with('fail','That Group doesn\'t Exists.');
		}

		$categories = ForumCategory::where('group_id', $id); 
		$threads = ForumThread::where('group_id', $id); 
		$comments = ForumComment::where('group_id', $id); 

		$delCa = true;
		$delT = true;
		$delCo = true;

		if ($categories->count() > 0)
		{
			$delCa = $categories->delete();
		}
		
		if ($threads->count() > 0)
		{
			$delT = $threads->delete();
		}
		
		if ($comments->count() > 0)
		{
			$delCo = $comments->delete();
		}

		if ($delCa && $delT && $delCo && $group->delete())
		{
			return Redirect::route('forum-home')->with('success', 'The Group Was Deleted.');
		}
		else
		{
			return Redirect::route('forum-home')->with('fail', 'The group is not Deleted, Sorry.');
		}
	}
}
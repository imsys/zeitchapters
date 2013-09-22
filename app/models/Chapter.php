<?php

class Chapter extends Eloquent {

    public function users()
    {
        return $this->belongsToMany('User', 'chapter_user_role')->withPivot('chapterrole_id');//with('chapterrole_id');
    }

	public function coordinators()
	{
		return $this->belongsToMany('User', 'chapter_user_role')->where('chapterrole_id', '=', 1);
	}

	public function parent()
    {
		//return $this->has_one('Category', 'id', 'parent_id');
        return $this->belongsTo('Chapter');
		//return $this->has_one('Category', 'id', 'parent_id');
    }

	public function subchapters()
    {
        return $this->hasMany('Chapter', 'parent_id', 'id')->orderBy('name');
		//return $this->belongs_to('Chapter', 'parent_id');
    }
	
	public function subscriptions()
    {
        return $this->belongsToMany('User', 'subscriptions');
    }
	
	public function analytics(){
		return $this->hasMany('ChapterAnalytics');
	}
			
	public function UpdateAnalytics($type_id, $value){
		$total = $this->analytics()->where('date', '=', date('Y-m-d'))
					->where('type_id','=',$type_id)->first();

		if(!$total){
			$total = new ChapterAnalytics(array('date'=>date('Y-m-d'), 'chapter_id'=>$this->id, 'type_id'=>$type_id));
		}
		$total->value = $value;

		$total->save();
	}
	
	
	public function UpdateAnalyticsMembership(){ //type 1 total users //type 2 - todays new user
		$this->UpdateAnalytics(1, $this->users()->count());
	}
	
	public function UpdateAnalyticsSubscriptions(){ //type 1 total users //type 2 - todays new user
		$this->UpdateAnalytics(2, $this->subscriptions()->count());
	}

}

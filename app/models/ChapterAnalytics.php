<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class ChapterAnalytics extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'chapters_analytics';
	
	protected $fillable = array('date','chapter_id','type_id','value');
	
	static public function UpdateTotal(){ //type 1 total users //type 2 - todays new user
		
		$total = ChapterAnalytics::where('date', '=', date('Y-m-d'))
					->where('chapter_id','=',0)
					->where('type_id','=',1)->first();

		if(!$total){
			$total = new ChapterAnalytics(array('date'=>date('Y-m-d'), 'chapter_id'=>0, 'type_id'=>1));
		}
		$total->value = User::all()->count();

		$total->save();
		/*
		$todaysnew = ChapterAnalytics::where('date', '=', date('Y-m-d'))
					->where('chapter_id','=',0)
					->where('type_id','=',2)->first();
		if(!$todaysnew){
			$todaysnew = new ChapterAnalytics(array('date'=>date('Y-m-d'), 'chapter_id'=>0, 'type_id'=>2, 'value'=>1));
		} else{
			$todaysnew->value++;
		}
		$todaysnew->save();*/
	}
	
	/*public function UpdateMembership($chapid){ //type 1 total users //type 2 - todays new user
		$chapter = Chapter::find($chapid);
		if(!chapter) return false;
		
		
		$total = ChapterAnalytics::where('date', '=', date('Y-m-d'))
					->where('chapter_id','=',$chapid)
					->where('type_id','=',1)->first();

		if(!$total){
			$total = new ChapterAnalytics(array('date'=>date('Y-m-d'), 'chapter_id'=>$chapid, 'type_id'=>1));
		}
		$total->value = $chapter->users()->count();

		$total->save();
		
//		$todaysnew = ChapterAnalytics::where('date', '=', date('Y-m-d'))
//					->where('chapter_id','=',0)
//					->where('type_id','=',2)->first();
//		if(!$todaysnew){
//			$todaysnew = new ChapterAnalytics(array('date'=>date('Y-m-d'), 'chapter_id'=>0, 'type_id'=>2, 'value'=>1));
//		} else{
//			$todaysnew->value++;
//		}
//		$todaysnew->save();
	}*/

}
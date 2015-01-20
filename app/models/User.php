<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';
	
	protected $fillable = array('name', 'email', 'password', 'fbid', 'fblink');

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password');

	//public $timestamps = true;
	
	public static function boot()
    {
		parent::boot();

        User::created(function($user)
		{
			ChapterAnalytics::UpdateTotal();
			
		});
    }

	public function getRememberToken()
    {
        return $this->remember_token;
    }

    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }

    public function getRememberTokenName()
    {
        return 'remember_token';
    }

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}

    public function chapters()
    {
        return $this->belongsToMany('Chapter', 'chapter_user_role')->withPivot('chapterrole_id');
    }

    public function roles()
    {
        return $this->belongsToMany('Role', 'role_user');
    }

	public function subscriptions()
    {
        return $this->belongsToMany('Chapter', 'subscriptions');
    }

	public function is_subscribed_to($chapter_id){
		return $this->subscriptions()->where('chapter_id','=',$chapter_id)->first();
	}

    public function has_role($key)
    {
        foreach($this->roles as $role)
        {
            if($role->name == $key)
            {
                return true;
            }
        }

        return false;
    }

    public function has_any_role($keys)
    {
        if( ! is_array($keys))
        {
            $keys = func_get_args();
        }

        foreach($this->roles as $role)
        {
            if(in_array($role->name, $keys))
            {
                return true;
            }
        }

        return false;
    }

	public function what_role_on_chapter($chapterid)
	{
		$chapter = $this->chapters()->where('chapter_id', '=', $chapterid)->first();
		if ($chapter){
			$roleid = $chapter->pivot->chapterrole_id;
			return Chapterrole::find($roleid);
		}
		return false;
	}

	public function has_role_on_chapter($rolename, $chapterid) //or on subchapters
    {
		$chaprole = Chapterrole::where('name','=',$rolename);
		if(!$chaprole){return false;}
		$roleid = $chaprole->first()->id;

		$chapter = $this->chapters()->where('chapter_id', '=', $chapterid)
				->where('chapterrole_id', '=', $roleid)
				->first();
		if ($chapter){
			return true; //has hole on chapter
		}
		if(!$this->chapters()->where('chapterrole_id', '=', $roleid)->first()){
			return false; //if the user doesn't match any chapter
		}
		
		while(true){
			$chapter = Chapter::with(array('parent','parent.users' => function($query) use ($roleid)
			{
				$query->where('chapterrole_id', '=', $roleid); //how do I use a variable here?
			}))->find($chapterid);
			if(!$chapter->parent){return false;}

			foreach ($chapter->parent->users as $user){
				if ($user->id == Auth::user()->id){
					return true;
				}
			}
			$chapterid = $chapter->parent->id; //search on the parent above
		}
        return false;
    }

	/*public function has_role_on_chapter($rolename, $chapterid)
    {
		$chapter = $this->chapters()->where('chapter_id', '=', $chapterid)->first();
		if ($chapter){
			$roleid = $chapter->pivot->chapterrole_id;
			$chaprole = Chapterrole::find($roleid);
			if($chaprole->name == $rolename){
				return true;
			}
		}

        return false;
    }*/

	public function set_role_on_chapter($rolename, $chapterid)
    {
		$chaprole = Chapterrole::where('name', '=', $rolename)->first();
		if(!$chaprole || !Chapter::find($chapterid)->first()){return false;}
		$chapter = $this->chapters()->where('chapter_id', '=', $chapterid)->first();

		if ($chapter){
			$chapter->pivot->chapterrole_id = $chaprole->id;
			return $chapter->pivot->save();

		}
		$this->chapters()->attach($chapterid, array('chapterrole_id' => $chaprole->id));
        return true;
    }

}

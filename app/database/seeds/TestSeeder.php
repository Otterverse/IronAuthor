<?php

class TestSeeder extends Seeder {


  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    
    Eloquent::unguard();

    $this->call('DatabaseSeeder');
    User::create(array('username' => 'judge', 'email' => 'judge@example.com', 'password' => Hash::make('test'), 'admin' => 0, 'judge' => 1, 'reviewer' => 0, 'contestant' => 0 ));
    User::create(array('username' => 'judge-reviewer', 'email' => 'judge-reviewer@example.com', 'password' => Hash::make('test'), 'admin' => 0, 'judge' => 1, 'reviewer' => 1, 'contestant' => 0 ));

    for ($i = 1; $i <= 50; $i++) {
      $user = new User;
      $user->username = 'test' . $i;
      $user->email = 'test' . $i . '@example.com';
      $user->password = Hash::make('test');
      $user->contestant = true;
      $user->reviewer = false;
      $user->judge = false;
      $user->admin = false;
      $user->save();

      $story = new Story;
      $story->title = "Story Title $i";
      $story->body = "This is story number $i";
      $story->user()->associate($user);
      $story->save();
    }



    for ($i = 1; $i <= 8; $i++) {
      $user = new User;
      $user->username = 'reviewer' . $i;
      $user->email = 'reviewer' . $i . '@example.com';
      $user->fimfic = 'reviewer' . $i . 'FimFic';
      $user->password = Hash::make('test');
      $user->contestant = false;
      $user->reviewer = true;
      $user->judge = false;
      $user->admin = false;
      $user->save();

      $reviewers[] = $user->id;

    }
      $pendings = array();

      while($reviewers)
      {
        $rand_user = array_rand($reviewers);
        $user = User::find($reviewers[$rand_user]);

        $stories = Story::whereNotIn('id', $user->reviews()->lists('story_id'))->get();

        $stories = $stories->filter(function ($story) {
          if($story->reviews()->count() < Contest::find(1)->max_reviews) { return true; }
        });

        if($stories->isEmpty())
        {
          unset($reviewers[$rand_user]);
          continue;
        }
        $stories->values();

        $stories->sortBy(function($story){
          return $story->reviews()->count();
        });

        $low_count = $stories->first()->reviews()->count();

        $stories = $stories->filter(function ($story) use($low_count){
          if($story->reviews()->count() == $low_count) { return true; }
        });

        $stories->values();

        $story = $stories->offsetGet( rand( 0, $stories->count() - 1) );

        $review = new Review;

        if (rand(0, 10) < 8 || in_array($rand_user, $pendings))
        {
        $review->pending = 0;
        $review->technical_score = rand(0,5);
        $review->structure_score = rand(0,5);
        $review->impact_score = rand(0,5);
        $review->theme_score = rand(0,5);
        $review->misc_score = rand(0,5);
        $review->notes = "Reviewed by " . $user->username . "\n Review for " . $story->title ;
        }else{
          $review->pending = 1;
          $pendings[] = $rand_user;
        }
        $review->story()->associate($story);
        $review->user()->associate($user);
        $review->save();
      }
	}
}
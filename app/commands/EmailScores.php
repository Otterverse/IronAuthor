<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class EmailScores extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'command:EmailScores';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Email Scores to all who requested them.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{


    $subject = "Iron Author 2017 Scores";

    $users = User::where('want_feedback', '=', '1')->get();

    $reports = array();

    foreach($users as $user){

      $username = $user->username;
      $email = $user->email;

      $story = $user->story;

      if(!$story){ continue; }

      $reviews = $story->reviews()->get();

      $report = array('username' => $username, 'email' => $email, 'title' => $story->title, 'body' => $story->body);

      $i = 0;
      $tech_total = 0;
      $struct_total = 0;
      $impact_total = 0;
      $theme_total = 0;
      $misc_total = 0;

      foreach ($reviews as $review){
        $i++;

        $report["tech_$i"] = $review->technical_score;
        $tech_total += $review->technical_score;

        $report["struct_$i"] = $review->structure_score;
        $struct_total += $review->structure_score;

        $report["impact_$i"] = $review->impact_score;
        $impact_total += $review->impact_score;

        $report["theme_$i"] = $review->theme_score;
        $theme_total += $review->theme_score;

        $report["misc_$i"] = $review->misc_score;
        $misc_total += $review->misc_score;

        $report["notes_$i"] = $review->notes;

        $report["review_total_$i"] =
         $review->technical_score +
         $review->structure_score +
         $review->impact_score +
         $review->theme_score +
         $review->misc_score;

      }

      $report['tech_total'] = number_format($tech_total / $i, 2);
      $report['struct_total'] = number_format($struct_total / $i, 2);
      $report['impact_total'] = number_format($impact_total / $i, 2);
      $report['theme_total'] = number_format($theme_total / $i, 2);
      $report['misc_total'] = number_format($misc_total / $i, 2);

      $report['final_total'] = number_format(
        ($tech_total +
        $struct_total +
        $impact_total +
        $theme_total +
        $misc_total) / $i, 2);

      array_push($reports, $report);

    }

    foreach ($reports as $report){
      $text = "Username: " . $report['username'] . "\n" .
        "Story Title: " . $report['title'] . "\n" .
        "Email: " . $report['email'] . "\n" .
        "Averaged Scores: " . "\n" .
        " Technical: " . $report['tech_total'] . "\n" .
        " Structure: " . $report['struct_total'] . "\n" .
        " Theme: " . $report['theme_total'] . "\n" .
        " Impact: " . $report['impact_total'] . "\n" .
        " Misc: " . $report['misc_total'] . "\n" .
        " Final Score: " . $report['final_total'] . "\n\n\n";

      $x = 0;
      while($x < 3){
              $x++;
              $text .= "Review $x:\n---------\n" .
                "Scores: \n" .
                " Technical: " . $report["tech_$x"] . "\n" .
                " Structure: " . $report["struct_$x"] . "\n" .
                " Theme: " . $report["theme_$x"] . "\n" .
                " Impact: " . $report["impact_$x"] . "\n" .
                " Misc: " . $report["misc_$x"] . "\n" .
                " Total Score: " . ($report["tech_$x"] + $report["struct_$x"] + $report["theme_$x"] + $report["impact_$x"] + $report["misc_$x"]) . "\n\n" .
                "Notes: " . $report["notes_$x"] . "\n---------\n\n\n";


      }

      $text .= "A copy of your story is included below, including any BBCode you used, so it can be easily pasted into FimFiction.\n---------\n\n";
      $text .= $report['title'] . " by " . $report['username'] . "\n\n";
      $text .= $report['body'] . "\n\n";

       Mail::send(array('text' => 'email_scores'), compact('report'), function($message) use ($report, $subject){
         $message->to($report['email'], $report['username']);
         $message->subject($subject);
       });

    }

		//$this->confirm($question, false);
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			array('example', InputArgument::OPTIONAL, 'An example argument.'),
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			array('example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
		);
	}

}

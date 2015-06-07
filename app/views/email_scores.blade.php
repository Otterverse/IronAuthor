Hello {{ $report['username'] }},

Thank you for participating in the 2015 Everfree Northwest Iron Author contest! This email contains your scores and any notes made by reviewing judges for your entry. But first, a quick reminder of the rules and judging methods.

We had over a dozen reviewers for the initial phase of scoring. Reviewers were assigned stories randomly and anonymously. They then scored the story in five categories, on a scale of zero to five in each, and optionally left notes. Each story was scored by three different reviewers, and the scores were then averaged. The top stories were then reviewed and discussed by Pen Stroke, Asylum, Ocalhoun, and myself (Xepher) as final judges. Only after winners were selected did we reveal the names of the authors.

The categories we judged on were:

Technical: This is basic grammar, spelling, punctuation, etc.

Structure: This is the larger scale structure of your story. Typically that means "plot" but might also include things such as the clues and reveal in a mystery, or the setup of a shaggy dog joke.

Impact: Basically, how much impact the story had on the reader. If it was a sad story, how well did it trigger the feels. If it was a mystery, how clever was the reveal.

Theme: How well you implemented the given prompts/themes of this year's contest. The themes were: "One Brief, Shining Moment," "A Voyage," and "Masks."

Misc: Pretty much "judge's choice" and provides a place for extra credit if something stood out that wasn't covered by the other categories.


In summary, you can have anything from 0 to 5 in each category, with a total ranging between 0 and 25. Actual (final/total) scores ranged from 7.33 to 22.33, with the majority of stories evenly distributed between 8 and 20.



Below, you will find your average scores in each category (and your final/total) score, as well as three individual reviews. Each individual review is from a single reviewer, and represents the exact score they gave, along with any notes they provided. Some notes may be signed, while others may be anonymous. It was up to the individual reviewer if they wished to sign their reviews.

At the end of this message, the full text of your story is included. It is in raw format, which includes any BBCode you may have used, making it suitable to paste directly into FimFiction if you desire to publish your story.

One last note: The Iron Author website and public story list ( http://ironauthor.xepher.net ) will remain online for at least a month, but may be taken down after that. If you wish to read the stories of your fellow contestants, please do so before then.

If you have any further questions or problems, feel free to contact me. I'm Xepher on FimFiction.net, or you can email xepher@xepher.net

Thanks again for participating in this year's contest, and I hope you enjoyed it as much as we all did!

--Xepher


Username: {{ $report['username'] }}

Story Title: {{ $report['title'] }}

Email: {{ $report['email'] }}



Averaged Scores

-----

Technical: {{ $report['tech_total'] }}

Structure: {{$report['struct_total'] }}

Impact: {{$report['impact_total']}}

Theme: {{$report['theme_total']}}

Misc: {{$report['misc_total']}}

Final Score: {{$report['final_total']}}




@foreach(array(1, 2, 3) as $x)
Review {{ $x }}

----------

Technical: {{ $report["tech_$x"] }}

Structure: {{$report["struct_$x"] }}

Impact: {{$report["impact_$x"]}}

Theme: {{$report["theme_$x"]}}

Misc: {{$report["misc_$x"]}}

Total: {{ $report["tech_$x"] + $report["struct_$x"] + $report["theme_$x"] + $report["impact_$x"] + $report["misc_$x"] }}


Notes: {{ $report["notes_$x"] }}

----------



@endforeach


A copy of your story is included below, including any BBCode you used, so it can be easily pasted into FimFiction.

----------

{{ $report['title'] }} by {{ $report['username'] }}


{{ $report['body'] }}

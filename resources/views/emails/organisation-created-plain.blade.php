Hello {{ auth()->user()->name }},

The organization has been created with the trial of one month!

Organization Details :

Name: {{ $organisation->name }}

Trial ends on {{ $organisation->trial_end->toDateString() }}


Thank you


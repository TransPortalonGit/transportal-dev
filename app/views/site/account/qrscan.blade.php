@if($users->inlab == 1)
Hello, {{ $users->first_name }} you are now in the lab. Welcome!
@else
Hello, {{ $users->first_name }} you are now exiting the lab. Bye!
@endif
<form class="m-t-md" role="form" method="POST" action="{{ url('/auth/register') }}">
   <input type="hidden" name="_token" value="{{ csrf_token() }}">
   <div class="form-group">
      <input type="text" class="form-control" name="name" value="{{ $user->name }}" placeholder="Όνομα" />
   </div>
   <div class="form-group">
      <input type="email" class="form-control" name="email" value="{{ $user->email }}" placeholder="Email" />
   </div>
   <div class="form-group">
      <input type="password" class="form-control" name="password" placeholder="Κωδικός" />
   </div>
   <div class="form-group">
      <input type="password" class="form-control" name="password_confirmation" placeholder="Επαλήθευση Κωδικού" />
   </div>
   <div class="form-group">
      <input type="text" class="form-control" name="addr" value="{{ $user->addr }}" placeholder="Διεύθυνση" />
   </div>
   <div class="form-group">
      <input type="text" class="form-control" name="tel" value="{{ $user->tel }}" placeholder="Τηλέφωνο" />
   </div>
   <button type="submit" class="btn btn-success btn-block">Δημιουργία Λογαριασμού</button>
</form>